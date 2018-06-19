<?php
/**
 * Created by IntelliJ IDEA.
 * User: isda
 * Date: 19/03/2018
 * Time: 4:47 PM
 */

return [

    'file_name' => env('LOG_FILE_NAME', 'laravel-exception.log'),

    'log' => env('LOG_OUTPUT' ,'daily'),

    'log_level' => env('LOG_LEVEL' ,'debug'),

    'enable_graylog_logging' => env('ENABLE_GRAYLOG_LOGGING', true),

    'enable_file_logging' => env('ENABLE_FILE_LOGGING', true),

    'include_headers_on_log' => env('INCLUDE_HEADER_ON_LOG', false),

    /*
    |--------------------------------------------------------------------------
    | Connection
    |--------------------------------------------------------------------------
    |
    | Define the graylog connection to be use
    |
    */
    'connection' => [
        'host' => env('UNIFIED_LOG_HOST' ,'8.8.8.8'),
        'port' => env('UNIFIED_LOG_PORT' ,12197),
    ],

    /*
    |--------------------------------------------------------------------------
    | Header Mapping
    |--------------------------------------------------------------------------
    |
    | Define header keys that this package will use in getting
    | value from header
    |
    */
    'header_mapping' => [
        'domain' => '',
        'ip' => '',
        'country_code' => ''
    ],

    /*
    |--------------------------------------------------------------------------
    | Cookie Session
    |--------------------------------------------------------------------------
    |
    | Cookie Session Name that this package will use in getting
    | session value from a request
    |
    */
    'cookie_session' => 'unified_log_session',

    /*
    |--------------------------------------------------------------------------
    | Header Session
    |--------------------------------------------------------------------------
    |
    | Cookie Session Name that this package will use in getting
    | session value from a request
    |
    */
    'header_session' => 'e_log_session',

    /*
    |--------------------------------------------------------------------------
    | Native Client Header
    |--------------------------------------------------------------------------
    |
    | Header key to detect if the request is coming from
    | Mobile Native application
    |
    */
    'native_client_header' => 'X-Client-Native',
    /*
    |--------------------------------------------------------------------------
    | Protected Fields
    |--------------------------------------------------------------------------
    |
    | Define fields that you want to protect
    | This package will automatically mask it with *
    |
    */
    'protected_fields' => [
        'password',
        'confirm_password'
    ]

];