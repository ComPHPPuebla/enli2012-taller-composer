<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace ComPHPPuebla\BooksApplication;

use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Exception;
use Interop\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\SapiEmitter;

class Application
{
    /** @var ContainerInterface */
    private $container;

    /**
     * @param array $definitions
     */
    public function __construct(array $definitions)
    {
        $this->buildContainer($definitions);
    }

    /**
     * @param ServerRequestInterface $request
     */
    public function run(ServerRequestInterface $request)
    {
        try {
            $dispatcher = $this->container->get(RouteDispatcher::class);
            $response = $dispatcher->dispatch(
                $request->getMethod(),
                $request->getUri()->getPath()
            );
        } catch (Exception $e) {
            error_log("Exception: \n{$e}\n");
            $response = new HtmlResponse($view->render('errors/500.html.twig'), 500);
        } finally {
            $emitter = new SapiEmitter();
            $emitter->emit($response);
        }
    }

    /**
     * @param array $definitions
     */
    private function buildContainer(array $definitions)
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions($definitions);
        $this->container = $builder->build();
    }
}
