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
            <<<EOT
                Generate a 500-word text in :language for typing practice in the :genre genre.

                CRITICAL REQUIREMENTS - MUST BE FOLLOWED:
                - ALWAYS write in the EXACT language specified in first line of the prompt - never translate or substitute words
                - USE ONLY these 7 symbols: . , : ; ? ! -
                - For dashes: use ONLY basic hyphen with spaces around it - like this
                - ABSOLUTELY NO long dashes (—) or special dashes of any kind
                - ABSOLUTELY NO apostrophes in ANY form - write 'autumns' NOT 'autumn's', 'souls' NOT 'soul's'
                - ABSOLUTELY NO quotation marks in ANY form
                - Text must contain ONLY letters, numbers, spaces, and the 7 allowed punctuation marks

                REQUIREMENTS:
                - WRITE in literary, professional style with natural flow
                - CREATE a COMPLETE, self-contained piece with proper conclusion
                - ENSURE text flows continuously from start to finish
                - ABSOLUTELY NO headings or titles
                - ABSOLUTELY NO paragraph breaks or line separation
                - ABSOLUTELY NO leading/trailing spaces
                - ABSOLUTELY NO empty lines

                OUTPUT FORMAT:
                - if NOT poetry - OUTPUT as SINGLE continuous paragraph
                - if poetry - OUTPUT each line on a NEW line,
                    NO paragraphs,
                    NO empty lines between lines,
                    NO indentation,
                    NO trailing spaces,
                    each line starts with a capital letter

                Output clean, ready-to-use text for typing practice.
                EOT,
        ),
        'cloud' => [
            'enabled' => env('AI_TEXT_GENERATION_CLOUD_ENABLED', true),
            'key' => env('AI_TEXT_GENERATION_CLOUD_KEY'),
            'url' => env('AI_TEXT_GENERATION_CLOUD_URL'),
            'model' => env('AI_TEXT_GENERATION_CLOUD_MODEL', ''),
            'timeout' => env('AI_TEXT_GENERATION_CLOUD_TIMEOUT', 30),
            'max_tokens' => env('AI_TEXT_GENERATION_CLOUD_MAX_TOKENS', 16384),
            'temperature' => env('AI_TEXT_GENERATION_CLOUD_TEMPERATURE', 0.7),
            'stream' => env('AI_TEXT_GENERATION_CLOUD_STREAM', false),
        ],
        'local' => [
            'enabled' => env('AI_TEXT_GENERATION_LOCAL_ENABLED', true),
            'key' => env('AI_TEXT_GENERATION_LOCAL_KEY'),
            'url' => env('AI_TEXT_GENERATION_LOCAL_URL', 'http://localhost:1234/v1/chat/completions'),
            'model' => env('AI_TEXT_GENERATION_LOCAL_MODEL', 'qwen/qwen3-1.7b'),
            'timeout' => env('AI_TEXT_GENERATION_LOCAL_TIMEOUT', 180),
            'max_tokens' => env('AI_TEXT_GENERATION_LOCAL_MAX_TOKENS', 16384),
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
