<?php
/**
 * PHP version 7
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
$options = [
    'db' => [
        'options' => [
            'driver' => 'Pdo_Mysql',
            'database' => getenv('DATABASE'),
            'username' => getenv('USERNAME'),
            'password' => getenv('PASSWORD'),
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
];
