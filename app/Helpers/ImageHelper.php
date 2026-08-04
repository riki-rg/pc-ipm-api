<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Get full URL for image path
     * 
     * @param string|null $path
     * @return string|null
     */
    public static function getImageUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        // If already full URL
        if (str_starts_with($path, 'http')) {
            return $path;
        }

        // Convert relative path to full URL
        return url('storage/' . ltrim($path, '/'));
    }

    /**
     * Get image attribute for model accessor
     * 
     * @param object $model
     * @param string $attribute
     * @return string|null
     */
    public static function getImageAttribute($model, $attribute): ?string
    {
        $path = $model->attributes[$attribute] ?? null;
        return self::getImageUrl($path);
    }
}
