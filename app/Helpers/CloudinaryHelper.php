<?php

namespace App\Helpers;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CloudinaryHelper
{
    /**
     * Image constants with their full versioned paths
     * Add your images here with their exact Cloudinary paths
     */
    const IMAGES = [
        'hero-bg' => 'v1757681837/ibibio_dancer_1_amxghj.jpg',
        'projects-hero' => 'v1757681837/ibibio_dancer_1_amxghj.jpg', // Using same image for now, can be changed later
        'news-hero' => 'v1757681837/ibibio_dancer_1_amxghj.jpg', // Using same image for now, can be changed later
        'about-hero' => 'v1757681837/ibibio_dancer_1_amxghj.jpg', // Using same image for now, can be changed later
        'project-1' => 'v1757681838/project_image_1_abc123.jpg',
        'project-2' => 'v1757681839/project_image_2_def456.jpg',
        'team-photo' => 'v1757681840/team_building_ghi789.jpg',
        'about-bg' => 'v1757681841/about_background_jkl012.jpg',
        // Add more images as you upload them
    ];

    /**
     * Upload file to Cloudinary
     */
    public static function uploadFile($file, $folder = null, $options = [])
    {
        try {
            // Validate file before upload
            if (!$file || !$file->isValid()) {
                throw new \Exception('Invalid file provided for upload');
            }

            // Check file size (max 10MB)
            if ($file->getSize() > 10485760) {
                throw new \Exception('File size exceeds maximum limit of 10MB');
            }

            $uploadOptions = array_merge([
                'quality' => 'auto',
                'format' => 'auto',
                'resource_type' => 'auto', // Handles images, videos, etc.
            ], $options);

            if ($folder) {
                $uploadOptions['folder'] = $folder;
            }

            $result = Cloudinary::upload($file->getRealPath(), $uploadOptions);
            
            if (!$result || !$result->getSecurePath()) {
                throw new \Exception('Cloudinary upload failed - no secure path returned');
            }
            
            return $result->getSecurePath();
        } catch (\Exception $e) {
            \Log::error('Cloudinary upload failed', [
                'error' => $e->getMessage(),
                'file_name' => $file ? $file->getClientOriginalName() : 'unknown',
                'file_size' => $file ? $file->getSize() : 'unknown',
                'folder' => $folder
            ]);
            throw new \Exception('Failed to upload file to Cloudinary: ' . $e->getMessage());
        }
    }

    /**
     * Upload image for projects
     */
    public static function uploadProjectImage($file)
    {
        return self::uploadFile($file, 'aifac/projects', [
            'transformation' => [
                'quality' => 'auto',
                'format' => 'auto',
                'width' => 1200,
                'height' => 800,
                'crop' => 'limit'
            ]
        ]);
    }

    /**
     * Upload image for people/team
     */
    public static function uploadPersonImage($file)
    {
        return self::uploadFile($file, 'aifac/people', [
            'transformation' => [
                'quality' => 'auto',
                'format' => 'auto',
                'width' => 600,
                'height' => 600,
                'crop' => 'fill',
                'gravity' => 'face'
            ]
        ]);
    }

    /**
     * Upload image for news
     */
    public static function uploadNewsImage($file)
    {
        return self::uploadFile($file, 'aifac/news', [
            'transformation' => [
                'quality' => 'auto',
                'format' => 'auto',
                'width' => 1200,
                'height' => 800,
                'crop' => 'limit'
            ]
        ]);
    }

    /**
     * Get image path by friendly name
     */
    public static function getImagePath($imageName)
    {
        return self::IMAGES[$imageName] ?? $imageName;
    }

    /**
     * Generate optimized hero image URL
     */
    public static function heroImage($publicId, $width = 2070, $height = 1380)
    {
        // Check if it's a friendly name first
        $actualPath = self::getImagePath($publicId);
        
        return self::buildCloudinaryUrl($actualPath, [
            'width' => $width,
            'height' => $height,
            'crop' => 'fill',
            'quality' => 'auto',
            'format' => 'auto',
            'gravity' => 'center'
        ]);
    }

    /**
     * Generate card/thumbnail image URL
     */
    public static function cardImage($publicId, $width = 400, $height = 300)
    {
        $actualPath = self::getImagePath($publicId);
        
        return self::buildCloudinaryUrl($actualPath, [
            'width' => $width,
            'height' => $height,
            'crop' => 'fill',
            'quality' => 'auto',
            'format' => 'auto',
            'gravity' => 'center'
        ]);
    }

    /**
     * Simple image URL without transformations
     */
    public static function simpleUrl($publicId)
    {
        $actualPath = self::getImagePath($publicId);
        return self::buildCloudinaryUrl($actualPath);
    }

    /**
     * Build Cloudinary URL manually to handle version numbers and extensions
     */
    private static function buildCloudinaryUrl($publicId, $transformations = [])
    {
        $cloudName = config('cloudinary.cloud_name', 'dgsctl247');
        
        // Build transformation string
        $transformString = '';
        if (!empty($transformations)) {
            $params = [];
            foreach ($transformations as $key => $value) {
                switch ($key) {
                    case 'width':
                        $params[] = "w_{$value}";
                        break;
                    case 'height':
                        $params[] = "h_{$value}";
                        break;
                    case 'crop':
                        $params[] = "c_{$value}";
                        break;
                    case 'quality':
                        $params[] = "q_{$value}";
                        break;
                    case 'format':
                        $params[] = "f_{$value}";
                        break;
                    case 'gravity':
                        $params[] = "g_{$value}";
                        break;
                    default:
                        $params[] = "{$key}_{$value}";
                }
            }
            $transformString = implode(',', $params) . '/';
        }

        // Handle versioned URLs (like v1757681837/ibibio_dancer_1_amxghj.jpg)
        if (strpos($publicId, 'v') === 0 && strpos($publicId, '/') !== false) {
            // Already includes version, use as-is
            return "https://res.cloudinary.com/{$cloudName}/image/upload/{$transformString}{$publicId}";
        }

        // Regular public ID
        return "https://res.cloudinary.com/{$cloudName}/image/upload/{$transformString}{$publicId}";
    }

    /**
     * Generate responsive image URLs
     */
    public static function responsiveImage($publicId, $sizes = [])
    {
        $actualPath = self::getImagePath($publicId);
        
        $defaultSizes = [
            'mobile' => ['width' => 640, 'height' => 480],
            'tablet' => ['width' => 1024, 'height' => 768],
            'desktop' => ['width' => 1920, 'height' => 1080]
        ];

        $sizes = array_merge($defaultSizes, $sizes);
        $urls = [];

        foreach ($sizes as $breakpoint => $dimensions) {
            $urls[$breakpoint] = self::buildCloudinaryUrl($actualPath, [
                'width' => $dimensions['width'],
                'height' => $dimensions['height'],
                'crop' => 'fill',
                'quality' => 'auto',
                'format' => 'auto',
                'gravity' => 'center'
            ]);
        }

        return $urls;
    }

    /**
     * Generate image with effects
     */
    public static function imageWithEffects($publicId, $effects = [], $width = 800, $height = 600)
    {
        $actualPath = self::getImagePath($publicId);
        
        $transformations = [
            'width' => $width,
            'height' => $height,
            'crop' => 'fill',
            'quality' => 'auto',
            'format' => 'auto',
            'gravity' => 'center'
        ];

        // Add effects
        if (isset($effects['blur'])) {
            $transformations['effect'] = 'blur:' . $effects['blur'];
        }
        if (isset($effects['brightness'])) {
            $transformations['effect'] = 'brightness:' . $effects['brightness'];
        }
        if (isset($effects['overlay'])) {
            $transformations['overlay'] = $effects['overlay'];
        }

        return self::buildCloudinaryUrl($actualPath, $transformations);
    }

    /**
     * List all available images
     */
    public static function listImages()
    {
        return array_keys(self::IMAGES);
    }
} 