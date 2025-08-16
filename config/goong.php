<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Goong.io API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Goong.io API services used for address autocomplete
    | and geocoding functionality.
    |
    */

    'api_key' => env('GOONG_API_KEY', ''),
    
    'base_url' => 'https://rsapi.goong.io',
    
    'endpoints' => [
        'place_autocomplete' => '/Place/AutoComplete',
        'place_detail' => '/Place/Detail',
        'geocode' => '/Geocode',
        'districts' => '/District',
        'wards' => '/Ward',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Settings
    |--------------------------------------------------------------------------
    |
    | Cache configuration for API responses to improve performance
    |
    */
    
    'cache' => [
        'enabled' => env('GOONG_CACHE_ENABLED', true),
        'ttl' => env('GOONG_CACHE_TTL', 86400), // 24 hours
        'prefix' => 'goong_',
    ],

    /*
    |--------------------------------------------------------------------------
    | Request Settings
    |--------------------------------------------------------------------------
    |
    | HTTP request configuration
    |
    */
    
    'timeout' => env('GOONG_TIMEOUT', 10),
    'retry_attempts' => env('GOONG_RETRY_ATTEMPTS', 3),
];