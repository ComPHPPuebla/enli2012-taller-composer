<?php
/**
 * PHP version 7
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/environment.php';

use ComPHPPuebla\BooksApplication\ErrorHandler;
use DI\ContainerBuilder;
use FastRoute\Dispatcher;
use Zend\Diactoros\{
    Response\HtmlResponse,
    Response\SapiEmitter,
    ServerRequestFactory
};

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
            $vars = array_values($route[2]);
            $controller = $container->get($controller);
            $response = $controller->$action(...$vars);
            break;
        default:
            throw new RuntimeException('Route not found.');
    }
} catch (Exception $exception) {
    /** @var ErrorHandler $handler */
    $handler = $container->get(ErrorHandler::class);
    $response = $handler->handle($exception, 500);
} finally {
    $emitter = new SapiEmitter();
    $emitter->emit($response);
}
