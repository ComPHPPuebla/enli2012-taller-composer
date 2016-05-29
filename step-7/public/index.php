<?php
/**
 * PHP version 7
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/environment.php';
require __DIR__ . '/../config/options.php';
require __DIR__ . '/../config/view.php';

use FastRoute\Dispatcher;
use Zend\Diactoros\{
    Response\HtmlResponse,
    Response\SapiEmitter,
    ServerRequestFactory
};

try {
    $dispatcher = require __DIR__ . '/../config/dispatcher.php';
    $request = ServerRequestFactory::fromGlobals();
    $route = $dispatcher->dispatch(
        $request->getMethod(),
        $request->getUri()->getPath()
    );
    switch ($route[0]) {
        case Dispatcher::FOUND:
            $action = $route[1];
            $vars = array_values($route[2]);
            $controller = require __DIR__ . '/../config/controller.php';
            $response = $controller->$action(...$vars);
            break;
        default:
            throw new RuntimeException('Route not found.');
    }
} catch (Exception $exception) {
    /** @var \ComPHPPuebla\BooksApplication\ErrorHandler $handler */
    $handler = require __DIR__ . '/../config/error-handler.php';
    $response = $handler->handle($exception, 500);
} finally {
    $emitter = new SapiEmitter();
    $emitter->emit($response);
}
