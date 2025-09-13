<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | An HTTP or HTTPS URL to notify your application (a webhook) when the
    | generation of the archive is completed.
    |
    */
    'notification_url' => env('CLOUDINARY_NOTIFICATION_URL'),

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Cloud Name
    |--------------------------------------------------------------------------
    |
    | This is your Cloudinary cloud name.
    |
    */
    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),

    /*
    |--------------------------------------------------------------------------
    | Cloudinary API Key
    |--------------------------------------------------------------------------
    |
    | This is your Cloudinary API key.
    |
    */
    'api_key' => env('CLOUDINARY_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Cloudinary API Secret
    |--------------------------------------------------------------------------
    |
    | This is your Cloudinary API secret.
    |
    */
    'api_secret' => env('CLOUDINARY_API_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Secure URL
    |--------------------------------------------------------------------------
    |
    | Whether to use HTTPS URLs.
    |
    */
    'secure' => env('CLOUDINARY_SECURE_URL', true),

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Upload Preset
    |--------------------------------------------------------------------------
    |
    | Upload preset for unsigned uploads.
    |
    */
    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),
]; 