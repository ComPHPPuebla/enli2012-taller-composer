<?php
namespace ComPHPPuebla\Dispatcher;

use ComPHPPuebla\Controller\HttpController;

class Dispatcher
{
    /**
     * @var string
     */
    protected $controllerName;

    /**
     * @var string
     */
    protected $actionName;

    /**
     * @var string
     */
    protected $templateName;

    /**
     * @param HttpController $controller
     * @param array $params
     * @throws ActionNotFoundException
     * @return array
     */
    public function dispatch(HttpController $controller, array $params)
    {
        $controller->setParams($params);
        $this->generateTemplateName($params['controller'], $params['action']);
        $this->generateActionName($params['action']);
        try {
            $method = new \ReflectionMethod($controller, $this->getActionName());
            return $method->invoke($controller);
        } catch (\ReflectionException $e) {
            throw new ActionNotFoundException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param string $controllerParam
     * @param string $actionParam
     */
    protected function generateTemplateName($controllerParam, $actionParam)
    {
        $this->templateName = "$controllerParam/$actionParam.phtml";
    }

    /**
     * @return string
     */
    public function getTemplateName()
    {
        return $this->templateName;
    }

    /**
     * @param string $actionParam
     * @return string
     */
    protected function generateActionName($actionParam)
    {
        $this->actionName = $actionParam . 'Action';
    }
    
    /**
     * @return string
     */
    public function getActionName()
    {
    	return $this->actionName;
    }

    /**
     * @param string $route
     * @throws NotFoundException
     * @return string
     */
    public function getControllerClass($route)
    {
        if (!$route) {
            throw new RouteNotFoundException('No route found');
        }
        $this->generateControllerName($route->values['controller']);
        return $this->getControllerName();
    }

    /**
     * @param string $controllerParam
     * @throws ControllerNotFoundException
     */
    protected function generateControllerName($controllerParam)
    {
    	$controller = ucfirst($controllerParam);
        $className = sprintf('ComPHPPuebla\Controller\%sController', $controller);
        if (!class_exists($className)) {
            $message = "Controller '$className' cannot be instantiated";
            throw new ControllerNotFoundException($message);
        }
        $this->controllerName = $className;
    }

    /**
     * @return string
     */
    protected function getControllerName()
    {
        return $this->controllerName;
    }

}