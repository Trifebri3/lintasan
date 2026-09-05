<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleFileUploadErrors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check if post_max_size was exceeded (causes $_POST & $_FILES to be silently dropped by PHP)
        if ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('patch')) {
            $contentLength = (int) ($request->server('CONTENT_LENGTH') ?? 0);
            $postMaxSize = ini_get('post_max_size') ?: '8M';
            $postMaxBytes = $this->parseSizeToBytes($postMaxSize);

            if ($contentLength > $postMaxBytes && empty($request->post()) && empty($request->allFiles())) {
                $formattedLength = $this->formatBytes($contentLength);
                return redirect()->back()->with('error', "Gagal mengunggah! Total ukuran data/berkas ({$formattedLength}) melebihi batas server PHP (post_max_size: {$postMaxSize}). Harap kurangi jumlah atau ukuran foto yang diunggah.");
            }
        }

        // 2. Check for individual file upload errors in $_FILES
        if (!empty($_FILES)) {
            $uploadErrors = [];
            $uploadMax = ini_get('upload_max_filesize') ?: '2M';

            foreach ($_FILES as $inputName => $fileData) {
                if (is_array($fileData['error'] ?? null)) {
                    // Multi-file array (like gallery[])
                    foreach ($fileData['error'] as $idx => $err) {
                        if ($err === UPLOAD_ERR_INI_SIZE) {
                            $origName = $fileData['name'][$idx] ?? "File ke-" . ($idx + 1);
                            $uploadErrors[] = "Berkas '{$origName}' melebihi batas maksimal server PHP (upload_max_filesize: {$uploadMax}).";
                        } elseif ($err !== UPLOAD_ERR_OK && $err !== UPLOAD_ERR_NO_FILE) {
                            $origName = $fileData['name'][$idx] ?? "File ke-" . ($idx + 1);
                            $uploadErrors[] = \App\Helpers\ImageHelper::getUploadErrorMessage($err, $origName);
                        }
                    }
                } else {
                    $err = $fileData['error'] ?? UPLOAD_ERR_OK;
                    if ($err === UPLOAD_ERR_INI_SIZE) {
                        $origName = $fileData['name'] ?? $inputName;
                        $uploadErrors[] = "Berkas '{$origName}' melebihi batas maksimal server PHP (upload_max_filesize: {$uploadMax}).";
                    } elseif ($err !== UPLOAD_ERR_OK && $err !== UPLOAD_ERR_NO_FILE) {
                        $origName = $fileData['name'] ?? $inputName;
                        $uploadErrors[] = \App\Helpers\ImageHelper::getUploadErrorMessage($err, $origName);
                    }
                }
            }

            if (!empty($uploadErrors)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', "Gagal mengunggah berkas:\n" . implode("\n", $uploadErrors) . "\nTips: Gunakan foto berukuran di bawah {$uploadMax} atau kompres terlebih dahulu.");
            }
        }

        return $next($request);
    }

    /**
     * Convert PHP size string (e.g. 2M, 8M, 1G) to bytes.
     */
    private function parseSizeToBytes(string $size): int
    {
        $unit = strtoupper(substr(trim($size), -1));
        $val = (int) $size;

        return match ($unit) {
            'G' => $val * 1024 * 1024 * 1024,
            'M' => $val * 1024 * 1024,
            'K' => $val * 1024,
            default => $val,
        };
    }

    /**
     * Format bytes to human readable format.
     */
    private function formatBytes(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1) . ' MB';
        }
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 1) . ' KB';
        }
        return $bytes . ' B';
    }
}
