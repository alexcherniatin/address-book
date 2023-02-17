<?php

namespace AddressBook\Core;

class Router
{
    /**
     * Boot application
     * 
     * @return void 
     */
    public static function boot(): void
    {
        $controllerName = 'Main';

        $actionName = 'index';

        $uri = explode('?', $_SERVER['REQUEST_URI']);

        $routes = explode('/', $uri[0]);

        if (!empty($routes[1])) {
            $controllerName = str_replace('-', '', $routes[1]);
        }

        if (!empty($routes[2])) {
            $actionName = str_replace('-', '', $routes[2]);
        }

        $controllerName = 'Controller_' . ucfirst($controllerName);

        $actionName = $actionName;

        $controllerPath = __DIR__ . '/../Controllers/' . $controllerName . '.php';

        if (!file_exists($controllerPath)) {
            self::error404();
        }

        require_once $controllerPath;

        $controller = new $controllerName;

        $action = $actionName;

        if (!method_exists($controller, $action)) {
            self::error404();
        }

        $controller->$action();
    }

    /**
     * Show 404 error
     * 
     * @return void 
     */
    public static function error404(): void
    {
        header('HTTP/1.0 404 Not Found');

        header('Status: 404 Not Found');

        echo '404 Page not found';

        exit();
    }

    /**
     * Get part of the URL
     *
     * @param int $index Position index
     *
     * @return ?string 
     */
    public static function getUrlPart(int $index): ?string
    {
        $uri = explode('?', $_SERVER['REQUEST_URI']);

        $routes = explode('/', $uri[0]);

        return $routes[$index] ?? null;
    }
}
