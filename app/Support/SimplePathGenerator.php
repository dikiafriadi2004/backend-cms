<?php

namespace App\Support;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class SimplePathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        // Simple path without numbered folders
        if ($this->isImage($media)) {
            return 'images/';
        }
        
        return 'files/';
    }

    public function getPathForConversions(Media $media): string
    {
        // Same path for conversions
        return $this->getPath($media);
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        // Same path for responsive images
        return $this->getPath($media);
    }

    protected function isImage(Media $media): bool
    {
        // Check by mime type first (most reliable)
        if ($media->mime_type && str_starts_with($media->mime_type, 'image/')) {
            return true;
        }
        
        // Fallback to file extension
        if ($media->file_name) {
            $extension = strtolower(pathinfo($media->file_name, PATHINFO_EXTENSION));
            return in_array($extension, [
                'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'tiff', 'ico'
            ]);
        }
        
        return false;
    }
}