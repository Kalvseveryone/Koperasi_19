<?php

return [

    'paths' => [
        'api/*',
        'auth/*',
        'sanctum/csrf-cookie',
        'login',
        'logout',
        'register',
    ],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'capacitor://localhost',      // untuk Ionic
        'ionic://localhost',          // untuk Ionic
        'http://localhost',           // untuk dev web
        'http://localhost:8100',      // untuk Ionic dev
        'http://localhost:4200',      // untuk Angular dev
        'https://kitaada.my.id',      // domain WebApp
        '*'                           // opsional untuk testing
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => [
        'Content-Type',
        'X-Requested-With',
        'Authorization',
        'X-CSRF-TOKEN',
        'Accept',
        'Origin',
        'Cache-Control',
        'X-File-Name',
    ],

    'exposed_headers' => [
        'Cache-Control',
        'Content-Language',
        'Content-Type',
        'Expires',
        'Last-Modified',
        'Pragma',
    ],

    // ❗️Harus TRUE jika WebApp pakai cookie/session
    'supports_credentials' => true,

    'max_age' => 0,
];
