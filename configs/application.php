<?php
use Aura\Router\DefinitionFactory;
use Aura\Router\Map;
use Aura\Router\RouteFactory;
use ComPHPPuebla\Controller\BooksController;

$config = [
    'pdo.dsn' => 'mysql:host=localhost;dbname=book_store',
    'pdo.user' => 'bstore_user',
    'pdo.password' => 'book_store_us3r',
    'pdo.options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    ],
    'router.routes' => [
        '/books' => [
            'name_prefix' => 'composer.books.',
            'values' => [
                'controller' => 'books',
                // Default value for controller is book
            ],
            'routes' => [
                'list' => '/{:action}',
                'show' => '/{:action}/{:bookId}'
            ],
        ],
    ],
    'views.path' => __DIR__ . '/../views',
    'views.options' => [
        'cache' => __DIR__ . '/../tmp/cache',
        'strict_variables' => true,
    ],
    BooksController::class => \DI\object()->constructor(\DI\get(NotORM::class)),
    Map::class => \DI\object()->constructor(
        \DI\get(DefinitionFactory::class),
        \DI\get(RouteFactory::class),
        \DI\get('router.routes')
    ),
    Twig_Environment::class => \DI\object()->constructor(
        \DI\get(Twig_Loader_Filesystem::class),
        \DI\get('views.options')
    ),
    Twig_Loader_Filesystem::class => \DI\object()->constructor(
        \DI\get('views.path')
    ),
    NotORM::class => \DI\object()->constructor(\DI\get(PDO::class)),
    PDO::class => \DI\object()->constructor(
        \DI\get('pdo.dsn'),
        \DI\get('pdo.user'),
        \DI\get('pdo.password'),
        \DI\get('pdo.options')
    ),
];

return $config;
