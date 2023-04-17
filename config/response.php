<?php

return [
    'register_success' => [
        'code' => 200,
        'message' => 'Register Successfully',
    ],
    'register_failed' => [
        'code' => 400,
        'message' => 'Register Failed',
    ],
    'login_success' => [
        'code' => 200,
        'message' => 'Login Successfully',
    ],
    'login_failed' => [
        'code' => 400,
        'message' => 'Login Failed',
    ],
    'logout_success' => [
        'code' => 200,
        'message' => 'Logout Successfully',
    ],
    'unauthorized' => [
        'code' => 401,
        'message' => 'Unauthorized',
    ],
    'unauthenticated' => [
        'code' => 401,
        'message' => 'Token is invalid',
    ],
    'forbidden' => [
        'code' => 403,
        'message' => 'Forbidden',
    ],
    'not_found' => [
        'code' => 404,
        'message' => 'Not Found',
    ],
    'url_not_found' => [
        'code' => 404,
        'message' => 'Url Not Found',
    ],
    'method_not_allowed' => [
        'code' => 405,
        'message' => 'Method Not Allowed',
    ],
    'validation_error' => [
        'code' => 422,
        'message' => 'The given data was invalid.',
    ],
    'internal_server_error' => [
        'code' => 500,
        'message' => 'Internal Server Error',
    ],
    'http_exception' => [
        'code' => 500,
        'message' => 'Http Exception',
    ],
];
