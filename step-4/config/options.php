<?php
/**
 * PHP version 7
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
$options = [
    'db' => [
        'dsn' => getenv('DSN'),
        'username' => getenv('USERNAME'),
        'password' => getenv('PASSWORD'),
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
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
