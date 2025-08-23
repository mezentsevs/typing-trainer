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

    'ai_text_generation_api' => [
        'key' => env('AI_TEXT_GENERATION_API_KEY'),
        'url' => env('AI_TEXT_GENERATION_API_URL'),
        'prompt_template' => env('AI_TEXT_GENERATION_API_PROMPT_TEMPLATE', 'Generate a 500-word text in :language for typing practice in the :genre genre.'),
        'request_prompt_key' => env('AI_TEXT_GENERATION_API_REQUEST_PROMPT_KEY', 'prompt'),
        'response_text_key' => env('AI_TEXT_GENERATION_API_RESPONSE_TEXT_KEY', 'text'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
