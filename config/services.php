<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
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

    'whatsapp' => [
        'number' => env('WHATSAPP_NUMBER', '6281234567890'),
        'default_message' => env('WHATSAPP_DEFAULT_MESSAGE', 'Hello, I would like to inquire about your products.'),
    ],

    'instagram' => [
        'access_token' => env('INSTAGRAM_ACCESS_TOKEN'),
        'account_id' => env('INSTAGRAM_ACCOUNT_ID'),
        'api_version' => env('INSTAGRAM_API_VERSION', 'v22.0'),
        'api_base_url' => env('INSTAGRAM_API_BASE_URL', 'https://graph.facebook.com'),
        'cache_ttl' => env('INSTAGRAM_CACHE_TTL', 3600),
        'short_cache_ttl' => 300,
    ],

];
