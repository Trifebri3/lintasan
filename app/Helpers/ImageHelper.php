<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Compress and save an uploaded image to the public storage disk using GD.
     * 
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  string  $subFolder
     * @param  string  $prefix
     * @return string
     */
    public static function compressAndSave($file, $subFolder, $prefix = '')
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $cleanPrefix = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $prefix));
        $filename = time() . '_' . ($prefix ? $cleanPrefix . '_' : '') . uniqid() . '.' . $extension;
        
        // Define directory paths
        $dirPath = storage_path('app/public/' . $subFolder);
        if (!file_exists($dirPath)) {
            mkdir($dirPath, 0755, true);
        }
        
        $destination = $dirPath . '/' . $filename;
        $tempPath = $file->getRealPath();

        // Check if GD library is available and compress
        if (extension_loaded('gd')) {
            $image = null;
            if ($extension === 'jpeg' || $extension === 'jpg') {
                $image = @imagecreatefromjpeg($tempPath);
            } elseif ($extension === 'png') {
                $image = @imagecreatefrompng($tempPath);
            } elseif ($extension === 'gif') {
                $image = @imagecreatefromgif($tempPath);
            } elseif ($extension === 'webp') {
                $image = @imagecreatefromwebp($tempPath);
            }

            if ($image) {
                // Get original dimensions
                $origWidth = imagesx($image);
                $origHeight = imagesy($image);
                
                // Define maximum dimensions (e.g. 1200px max width/height)
                $maxWidth = 1200;
                $maxHeight = 1200;
                
                $width = $origWidth;
                $height = $origHeight;
                
                // Calculate new dimensions keeping aspect ratio
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
                
                // Create resampled canvas
                $newImage = imagecreatetruecolor($width, $height);
                
                // Preserve transparency for PNG and WebP
                if ($extension === 'png' || $extension === 'webp') {
                    imagealphablending($newImage, false);
                    imagesavealpha($newImage, true);
                    $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                    imagefilledrectangle($newImage, 0, 0, $width, $height, $transparent);
                }
                
                // Perform scaling/resizing
                imagecopyresampled($newImage, $image, 0, 0, 0, 0, $width, $height, $origWidth, $origHeight);

                // Save image with compression
                if ($extension === 'png') {
                    // PNG compression: 0 (no) to 9 (max)
                    imagepng($newImage, $destination, 7);
                } elseif ($extension === 'webp') {
                    // WebP quality: 0 to 100
                    imagewebp($newImage, $destination, 70);
                } else {
                    // JPEG quality: 0 to 100
                    imagejpeg($newImage, $destination, 70);
                }
                
                imagedestroy($image);
                imagedestroy($newImage);
                
                return '/storage/' . $subFolder . '/' . $filename;
            }
        }

        // Fallback if GD fails or unsupported format
        $path = $file->storeAs($subFolder, $filename, 'public');
        return '/storage/' . $path;
    }
}
