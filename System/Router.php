<?php
namespace System;

use Controllers\IndexController;

class Router
{
    private $routes;
    private $controller;

    /**
     * Router constructor.
     * @param array $routes
     */
    public function __construct(array $routes)
    {
        $this->routes     = $routes;
        $this->controller = new IndexController();
    }

    public function run(): void
    {
        $pathUrl = parse_url($_SERVER['REQUEST_URI'])['path'];

        foreach ($this->routes as $route) {
            if (empty($route['method']) || empty($route['uri'])) {
                echo 'Route error: [data/routes.php] - ' . json_encode($route) . '. Required values are missing';
                die();
            }
            if ($route['uri'] === $pathUrl) {
                if ($_SERVER['REQUEST_METHOD'] === $route['method']) {
                    $this->execute($route);
                }
            }
        }
    }

    /**
     * @param array $route
     */
    public function execute(array $route)
    {
        $action = $route['action'];
        $view   = $route['view'] ?? '';

        $this->controller->$action($view);
    }
}