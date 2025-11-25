<?php

return [
    'providers' => [
        'newsapi' => [
            'api_key' => env('NEWSAPI_API_KEY'),
        ],
        'newyorktimes' => [
            'api_key' => env('NEWYORK_TIMES_API_KEY'),
        ],
        'guardian' => [
            'api_key' => env('GUARDIAN_API_KEY'),
        ],
    ],
];
