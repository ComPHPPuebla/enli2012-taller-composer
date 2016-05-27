<?php
use ComPHPPuebla\BooksApplication\RouteDispatcher;
use ComPHPPuebla\BooksLibrary\Books;
use ComPHPPuebla\BooksLibrary\ShowBooks;
use FastRoute\RouteCollector;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

return [
    'db.options' => [
        'driver' => 'Pdo_Mysql',
        'database' => getenv('DATABASE'),
        'username' => getenv('USERNAME'),
        'password' => getenv('PASSWORD'),
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
        $dispatcher = FastRoute\simpleDispatcher(function(RouteCollector $router) use ($routes) {
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
            $container->get(Twig_Loader_Filesystem::class),
            $container->get('views.options')
        );
    },
    Twig_Loader_Filesystem::class => function (ContainerInterface $container) {
        return new Twig_Loader_Filesystem($container->get('views.path'));
    },
    Books::class => function (ContainerInterface $container) {
        return new Books(
            new TableGateway(
                ['b' => 'book'],
                new Adapter($container->get('db.options'))
            )
        );
    },
];
