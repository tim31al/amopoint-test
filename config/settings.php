<?php
$basePath = dirname(__DIR__);

return [
    'app_name' => 'Test work',
    'development' => getenv('DEV_MODE'),
    'files_dir' => $basePath . '/public/files',
    'doctrine' => [
        'isDevMode' => getenv('DEV_MODE'),
        'metadata_dirs' => [
            $basePath . '/src',
        ],
        'connection' => [
            'driver' => 'pdo_pgsql',
            'host' => getenv('DB_HOST'),
            'port' => getenv('DB_PORT'),
            'dbname' => getenv('POSTGRES_DB'),
            'user' => getenv('POSTGRES_USER'),
            'password' => getenv('POSTGRES_PASSWORD'),
        ]
    ],
    'api-token' => getenv('API_TOKEN'),
];
