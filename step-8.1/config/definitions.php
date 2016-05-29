<?php
/**
 * PHP version 7
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
use ComPHPPuebla\BooksApplication\ErrorHandler;
use ComPHPPuebla\BooksApplication\RouteDispatcher;
use ComPHPPuebla\BooksCatalog\Books;
use ComPHPPuebla\BooksCatalog\ShowBooks;
use FastRoute\RouteCollector;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
use function FastRoute\simpleDispatcher;

return [
    'db.options' => [
        'driver' => 'Pdo_Mysql',
        'database' => getenv('DATABASE'),
        'username' => getenv('USERNAME'),
        'password' => getenv('PASSWORD'),
        'hostname' => getenv('HOST'),
    ],
    'router.routes' => [
        'books.view_all' => [
            'method' => 'GET',
            'path' => '/books',
            'handler' => ShowBooks::class . ':viewAll'
        ],
        'books.show_details' => [
            'method' => 'GET',
            'path' => '/books/{id:\d+}',
            'handler' => ShowBooks::class . ':showDetails',
        ],
    ],
    'views.path' => __DIR__ . '/../templates',
    'views.options' => [
        'cache' => __DIR__ . '/../var/cache',
        'strict_variables' => true,
    ],
    ShowBooks::class => function (ContainerInterface $container) {
        return new ShowBooks(
            $container->get(Books::class),
            $container->get(Twig_Environment::class)
        );
    },
    RouteDispatcher::class => function (ContainerInterface $container) {
        $routes = $container->get('router.routes');
        $dispatcher = simpleDispatcher(function(RouteCollector $router) use ($routes) {
            foreach ($routes as $route) {
                $router->addRoute(
                    $route['method'],
                    $route['path'],
                    $route['handler']
                );
            }
        });
        return new RouteDispatcher($dispatcher, $container);
    },
    Twig_Environment::class => function (ContainerInterface $container) {
        return new Twig_Environment(
            new Twig_Loader_Filesystem($container->get('views.path')),
            $container->get('views.options')
        );
    },
    Books::class => function (ContainerInterface $container) {
        return new Books(
            new TableGateway(
                ['b' => 'book'],
                new Adapter($container->get('db.options'))
            )
        );
    },
    ErrorHandler::class => function (ContainerInterface $container) {
        return new ErrorHandler($container->get(Twig_Environment::class));
    },
];
