<?php
/**
 * PHP version 7
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace ComPHPPuebla\BooksApplication;

use FastRoute\Dispatcher;
use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class RouteDispatcher
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
    public function dispatch(string $httpMethod, string $uri): ResponseInterface
    {
        $route = $this->dispatcher->dispatch($httpMethod, $uri);
        switch ($route[0]) {
            case Dispatcher::FOUND:
                list($controller, $action) = explode(':', $route[1]);
                $vars = array_values($route[2]);
                $controller = $this->container->get($controller);
                return $controller->$action(...$vars);
                break;
            default:
                throw new RuntimeException('Route not found.');
        }
    }
}
