<?php
$config = [
    'instance' => [
        'ComPHPPuebla\Controller\BooksController' => [
            'parameters' => [
                 'notORM' => 'NotORM',
            ],
        ],
        'Aura\Router\Map' => [
            'parameters' => [
                'route_factory' => 'Aura\Router\RouteFactory',
                'attach' => [
                    '/books' => [
                        'name_prefix' => 'composer.books.',
                        'values' => [
                            'controller' => 'books', // Default value for controller is book
                        ],
                        'routes' => [
                            'list' => '/{:action}',
                            'show' => '/{:action}/{:bookId}'
                        ]
                    ]
                ],
            ],
        ],
        'Twig_Environment' => [
            'parameters' => [
                'loader' => 'Twig_Loader_Filesystem',
                'options' => [
                    'cache' => 'tmp/cache',
                    'strict_variables' => true,
                ],
            ]
        ],
        'Twig_Loader_Filesystem' => [
            'parameters' => [
                'paths' => 'views',
            ]
        ],
        'NotORM' => [
            'parameters' => [
                'connection' => 'PDO',
            ]
        ],
        'PDO' => [
            'parameters' => [
                'dsn' => 'mysql:host=localhost;dbname=book_store',
                'username' => 'bstore_user',
                'passwd' => 'book_store_us3r',
                'options' => [],
            ]
        ],
    ],
];

return $config;
