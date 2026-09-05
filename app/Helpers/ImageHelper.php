<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Translate PHP file upload error codes into descriptive Indonesian messages.
     * 
     * @param int $errorCode
     * @param string|null $filename
     * @return string
     */
    public static function getUploadErrorMessage(int $errorCode, ?string $filename = null): string
    {
        $prefix = $filename ? "Berkas '{$filename}': " : "Berkas unggahan: ";
        $maxUpload = ini_get('upload_max_filesize') ?: '2M';

        return match ($errorCode) {
            UPLOAD_ERR_INI_SIZE => "{$prefix}Ukuran berkas melebihi batas maksimal server PHP (upload_max_filesize: {$maxUpload}). Harap pilih foto yang lebih kecil atau kompres terlebih dahulu.",
            UPLOAD_ERR_FORM_SIZE => "{$prefix}Ukuran berkas melebihi batas maksimal yang diizinkan oleh formulir.",
            UPLOAD_ERR_PARTIAL => "{$prefix}Berkas hanya terunggah sebagian. Koneksi internet mungkin terputus saat proses upload.",
            UPLOAD_ERR_NO_FILE => "{$prefix}Tidak ada berkas yang dipilih untuk diunggah.",
            UPLOAD_ERR_NO_TMP_DIR => "{$prefix}Server PHP kehilangan folder penampung sementara (missing temporary folder). Hubungi administrator.",
            UPLOAD_ERR_CANT_WRITE => "{$prefix}Gagal menulis berkas ke media penyimpanan server (gagal write to disk). Periksa izin folder server.",
            UPLOAD_ERR_EXTENSION => "{$prefix}Unggahan berkas dihentikan oleh salah satu modul/ekstensi PHP.",
            default => "{$prefix}Terjadi kesalahan saat mengunggah berkas (Kode error PHP: {$errorCode})."
        };
    }

    /**
     * Compress and save an uploaded image to the public storage disk using GD.
     * 
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  string  $subFolder
     * @param  string  $prefix
     * @return string  Relative public URL (e.g. /storage/stories/thumb_xxx.jpg)
     * @throws \Exception
     */
    public static function compressAndSave($file, string $subFolder, string $prefix = ''): string
    {
        // 1. Validate UploadedFile instance
        if (!$file instanceof UploadedFile) {
            throw new \InvalidArgumentException("Berkas yang diberikan tidak valid atau bukan file yang diunggah.");
        }

        if (!$file->isValid()) {
            $errorMsg = self::getUploadErrorMessage($file->getError(), $file->getClientOriginalName());
            Log::error("ImageHelper upload error: " . $errorMsg);
            throw new \RuntimeException($errorMsg);
        }

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
        $cleanPrefix = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $prefix));
        $filename = time() . '_' . ($cleanPrefix ? $cleanPrefix . '_' : '') . uniqid() . '.' . $extension;
        
        // Define directory paths in public storage using Storage disk abstraction
        $cleanSubFolder = trim($subFolder, '/\\');
        $disk = Storage::disk('public');
        $dirPath = $disk->path($cleanSubFolder);
        if (!file_exists($dirPath)) {
            @mkdir($dirPath, 0755, true);
        }
        
        $destination = $dirPath . DIRECTORY_SEPARATOR . $filename;
        $tempPath = $file->getRealPath();

        // 2. Direct save for vector images (SVG) or when GD is not applicable
        if ($extension === 'svg') {
            $path = $file->storeAs($cleanSubFolder, $filename, 'public');
            self::ensureFileSaved($destination, $cleanSubFolder . '/' . $filename);
            return '/storage/' . $cleanSubFolder . '/' . $filename;
        }

        // 3. Process with GD library compression if available
        $compressedSuccessfully = false;
        if (extension_loaded('gd') && $tempPath && file_exists($tempPath)) {
            try {
                $image = null;
                if ($extension === 'jpeg' || $extension === 'jpg') {
                    $image = @imagecreatefromjpeg($tempPath);
                } elseif ($extension === 'png') {
                    $image = @imagecreatefrompng($tempPath);
                } elseif ($extension === 'gif') {
                    $image = @imagecreatefromgif($tempPath);
                } elseif ($extension === 'webp') {
                    if (function_exists('imagecreatefromwebp')) {
                        $image = @imagecreatefromwebp($tempPath);
                    }
                }

                if ($image) {
                    $origWidth = imagesx($image);
                    $origHeight = imagesy($image);
                    
                    // Constrain maximum width and height
                    $maxWidth = 1600;
                    $maxHeight = 1600;
                    
                    $width = $origWidth;
                    $height = $origHeight;
                    
                    if ($width > $maxWidth || $height > $maxHeight) {
                        $ratio = $width / $height;
                        if ($ratio > 1) {
                            $width = $maxWidth;
                            $height = (int)round($maxWidth / $ratio);
                        } else {
                            $height = $maxHeight;
                            $width = (int)round($maxHeight * $ratio);
                        }
                    }
                    
                    $newImage = imagecreatetruecolor($width, $height);
                    
                    // Handle transparency for PNG and WebP
                    if ($extension === 'png' || $extension === 'webp') {
                        imagealphablending($newImage, false);
                        imagesavealpha($newImage, true);
                        $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                        imagefilledrectangle($newImage, 0, 0, $width, $height, $transparent);
                    }
                    
                    // Resample image
                    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $width, $height, $origWidth, $origHeight);

                    // Save with high quality / optimized compression
                    if ($extension === 'png') {
                        imagepng($newImage, $destination, 7);
                    } elseif ($extension === 'webp' && function_exists('imagewebp')) {
                        imagewebp($newImage, $destination, 78);
                    } elseif ($extension === 'gif') {
                        imagegif($newImage, $destination);
                    } else {
                        imagejpeg($newImage, $destination, 78);
                    }
                    
                    imagedestroy($image);
                    imagedestroy($newImage);
                    
                    if (file_exists($destination) && filesize($destination) > 0) {
                        $compressedSuccessfully = true;
                    }
                }
            } catch (\Throwable $e) {
                Log::warning("GD Compression failed, falling back to standard storeAs: " . $e->getMessage());
            }
        }

        // 4. Fallback if GD was not successful
        if (!$compressedSuccessfully) {
            $path = $file->storeAs($cleanSubFolder, $filename, 'public');
            if (!$path) {
                throw new \RuntimeException("Gagal menyimpan berkas '{$filename}' ke disk public storage.");
            }
        }

        // 5. Final check to ensure file is physically on disk
        self::ensureFileSaved($destination, $cleanSubFolder . '/' . $filename);

        return '/storage/' . $cleanSubFolder . '/' . $filename;
    }

    /**
     * Safely delete an existing image file from storage.
     * 
     * @param string|null $path
     * @return bool
     */
    public static function deleteFile(?string $path): bool
    {
        if (empty($path)) {
            return false;
        }

        try {
            // Check if stored in /storage/
            if (str_starts_with($path, '/storage/')) {
                $relativePath = substr($path, strlen('/storage/'));
                if (Storage::disk('public')->exists($relativePath)) {
                    return Storage::disk('public')->delete($relativePath);
                }
            } elseif (str_starts_with($path, 'storage/')) {
                $relativePath = substr($path, strlen('storage/'));
                if (Storage::disk('public')->exists($relativePath)) {
                    return Storage::disk('public')->delete($relativePath);
                }
            }

            // Check if stored directly in public directory
            $publicPath = public_path(ltrim($path, '/\\'));
            if (File::exists($publicPath) && is_file($publicPath)) {
                return File::delete($publicPath);
            }
        } catch (\Throwable $e) {
            Log::warning("ImageHelper deleteFile error for {$path}: " . $e->getMessage());
        }

        return false;
    }

    /**
     * Verify that the file was written to disk.
     */
    protected static function ensureFileSaved(string $destination, string $relativePath): void
    {
        if (!file_exists($destination) && !Storage::disk('public')->exists($relativePath)) {
            Log::error("ImageHelper: File was not created at {$destination}");
            throw new \RuntimeException("Berkas gagal tersimpan di server. Pastikan izin direktori storage dapat ditulisi (writable).");
        }
    }
}
