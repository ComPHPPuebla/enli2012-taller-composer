<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/environment.php';

use DI\ContainerBuilder;
use FastRoute\Dispatcher;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

try {
    $builder = new ContainerBuilder();
    $builder->addDefinitions(require __DIR__ . '/../config/definitions.php');
    $container = $builder->build();
    $dispatcher = $container->get('FastRoute/SimpleDispatcher');
    $request = ServerRequestFactory::fromGlobals();
    $route = $dispatcher->dispatch(
        $request->getMethod(),
        $request->getUri()->getPath()
    );
    switch ($route[0]) {
        case Dispatcher::FOUND:
            list($controller, $action) = explode(':', $route[1]);
            $vars = $route[2];
            $controller = $container->get($controller);
            $response = call_user_func_array([$controller, $action], $vars);
            break;
        default:
            throw new RuntimeException('Route not found.');
    }
} catch (Exception $e) {
    error_log("Exception: \n{$e}\n");
    //$response = new HtmlResponse($view->render('errors/500.html.twig'), 500);
} finally {
    $emitter = new SapiEmitter();
    $emitter->emit($response);
}
