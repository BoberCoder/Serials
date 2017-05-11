<?php

namespace Serials\Components;

class Router
{
    private $routes;

    private $connection;

    public function __construct($connection)
    {
        $this->routes = include $_SERVER['DOCUMENT_ROOT'].'/config/routes.php';
        $this->connection = $connection;
    }
    private function getURI()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }
    public function run()
    {
        $uri = $this->getURI();
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                $segments = explode('/', $internalRoute);
                $controllerName = '\\Serials\\Controller\\'.ucfirst(array_shift($segments).'Controller');
                $actionName = 'action'.ucfirst(array_shift($segments));
                $parameters = $segments;
                $controller = new $controllerName($this->connection);
                call_user_func_array(array($controller, $actionName), $parameters);
                break;
            }
        }
    }
}
