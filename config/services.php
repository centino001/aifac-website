<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'flutterwave' => [
        'public_key' => env('FLW_PUBLIC_KEY'),
        'secret_key' => env('FLW_SECRET_KEY'),
        'encryption_key' => env('FLW_ENCRYPTION_KEY'),
        'env' => env('FLW_ENV', 'staging'),
        'log_dir' => env('FLW_LOG_DIR', 'logs'),
        'webhook_hash' => env('FLW_SECRET_HASH'),
        // Ticket splits: main settlement (Fidelity) keeps this flat share; subaccount (Wema) gets the rest.
        'ticket_subaccount_id' => env('FLW_TICKET_SUBACCOUNT_ID'),
        'ticket_main_share' => (float) env('FLW_TICKET_MAIN_SHARE', 3000),
    ],

    'gbs2026' => [
        'url' => env('GBS2026_URL', 'http://localhost:5173'),
        'cors_origins' => array_values(array_filter(array_map(
            'trim',
            explode(',', env('GBS2026_CORS_ORIGINS', 'http://localhost:5173,http://127.0.0.1:5173'))
        ))),
    ],

];
