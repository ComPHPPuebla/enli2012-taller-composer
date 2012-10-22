<?php
$config = array(
    'instance' => array(
    	'ComPHPPuebla\Controller\BooksController' => array(
   			'parameters' => array(
 				'notORM' => 'NotORM',
    		),
    	),
        'Aura\Router\Map' => array(
            'parameters' => array(
                'route_factory' => 'Aura\Router\RouteFactory',
                'attach' => array(
                    '/books' => array(
                        'name_prefix' => 'composer.books.',
                        'values' => array(
                        	// Default value for controller is book
                            'controller' => 'books', 
                        ),
                        'routes' => array(
                            'list' => '/{:action}',
                            'show' => '/{:action}/{:bookId}'
                        )
                    )
                ),
            ),
        ),
        'Twig_Environment' => array(
            'parameters' => array(
                'loader' => 'Twig_Loader_Filesystem',
                'options' => array(
                    __DIR__ . '/../views/cache'
                ),
            )
        ),
        'Twig_Loader_Filesystem' => array(
            'parameters' => array(
                'paths' => __DIR__ . '/../views',
            )
        ),
        'NotORM' => array(
            'parameters' => array(
                'connection' => 'PDO',
            )
        ),
        'PDO' => array(
            'parameters' => array(
                'dsn' => 'mysql:host=localhost;dbname=book_store',
                'username' => 'bstore_user',
                'passwd' => 'book_store_us3r',
            )
        ),
    ),
);
return $config;