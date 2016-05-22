<?php
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
];
