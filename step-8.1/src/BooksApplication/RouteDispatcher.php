<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace ComPHPPuebla\BooksApplication;

use FastRoute\Dispatcher;
use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class RouteDispatcher implements Dispatcher
{
    /** @var Dispatcher */
    private $dispatcher;

    /** @var ContainerInterface */
    private $container;

    /**
     * @param Dispatcher $dispatcher
     * @param ContainerInterface $container
     */
    public function __construct(Dispatcher $dispatcher, ContainerInterface $container)
    {
        $this->dispatcher = $dispatcher;
        $this->container = $container;
    }

    /**
     * @param string $httpMethod
     * @param string $uri
     * @return ResponseInterface
     * @throws RuntimeException
     */
    public function dispatch($httpMethod, $uri)
    {
        $route = $this->dispatcher->dispatch($httpMethod, $uri);
        switch ($route[0]) {
            case Dispatcher::FOUND:
                list($controller, $action) = explode(':', $route[1]);
                $vars = $route[2];
                $controller = $this->container->get($controller);
                return call_user_func_array([$controller, $action], $vars);
                break;
            default:
                throw new RuntimeException('Route not found.');
        }
    }
}
