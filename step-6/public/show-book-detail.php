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

use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

try {
    $request = ServerRequestFactory::fromGlobals();
    /** @var \ComPHPPuebla\BooksCatalog\ShowBooks $controller */
    $controller = require __DIR__ . '/../config/controller.php';
    $response = $controller->showDetails((int) $request->getQueryParams()['id']);
} catch (Exception $e) {
    /** @var \ComPHPPuebla\BooksApplication\ErrorHandler $handler */
    $handler = require __DIR__ . '/../config/error-handler.php';
    $response = $handler->handle($exception, 500);
} finally {
    $emitter = new SapiEmitter();
    $emitter->emit($response);
}
