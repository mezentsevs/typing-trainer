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

    'ai_text_generation' => [
        'prompt_template' => env(
            'AI_TEXT_GENERATION_PROMPT_TEMPLATE',
            'Generate a 500-word text in :language for typing practice in the :genre genre.',
        ),
        'cloud' => [
            'enabled' => env('AI_TEXT_GENERATION_CLOUD_ENABLED', true),
            'key' => env('AI_TEXT_GENERATION_CLOUD_KEY'),
            'url' => env('AI_TEXT_GENERATION_CLOUD_URL'),
            'model' => env('AI_TEXT_GENERATION_CLOUD_MODEL', ''),
            'timeout' => env('AI_TEXT_GENERATION_CLOUD_TIMEOUT', 30),
            'max_tokens' => env('AI_TEXT_GENERATION_CLOUD_MAX_TOKENS', 1000),
            'temperature' => env('AI_TEXT_GENERATION_CLOUD_TEMPERATURE', 0.7),
            'stream' => env('AI_TEXT_GENERATION_CLOUD_STREAM', false),
        ],
        'local' => [
            'enabled' => env('AI_TEXT_GENERATION_LOCAL_ENABLED', true),
            'key' => env('AI_TEXT_GENERATION_LOCAL_KEY'),
            'url' => env('AI_TEXT_GENERATION_LOCAL_URL', 'http://localhost:1234/v1/chat/completions'),
            'model' => env('AI_TEXT_GENERATION_LOCAL_MODEL', 'qwen/qwen3-1.7b'),
            'timeout' => env('AI_TEXT_GENERATION_LOCAL_TIMEOUT', 120),
            'max_tokens' => env('AI_TEXT_GENERATION_LOCAL_MAX_TOKENS', 1000),
            'temperature' => env('AI_TEXT_GENERATION_LOCAL_TEMPERATURE', 0.7),
            'stream' => env('AI_TEXT_GENERATION_LOCAL_STREAM', false),
        ],
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
