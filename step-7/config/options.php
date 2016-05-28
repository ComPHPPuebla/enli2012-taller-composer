<?php
$options = [
    'db' => [
        'options' => [
            'driver' => 'Pdo_Mysql',
            'database' => getenv('DATABASE'),
            'username' => getenv('USERNAME'),
            'password' => getenv('PASSWORD'),
            'hostname' => getenv('HOST'),
        ],
    ],
    'view' => [
        'paths' => [
            __DIR__ . '/../templates'
        ],
        'options' => [
            'cache' => __DIR__ . '/../var/cache',
            'strict_variables' => true,
            'debug' => true,
        ],
    ],
    'routes' => [
        'books.view_all' => [
            'method' => 'GET',
            'path' => '/books',
            'handler' => 'viewAll'
        ],
        'books.show_details' => [
            'method' => 'GET',
            'path' => '/books/{id:\d+}',
            'handler' => 'showDetails',
        ],
    ],
];
