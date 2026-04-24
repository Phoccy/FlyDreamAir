<?php 
declare(strict_types=1);

namespace Sys\Core;

final class Router
{
    private array $routes = [];

    public function add(string $method, string $uri, string $action): void
    {
        $this->routes[$method][] = [
            'uri' => $uri,
            'action'=> $action
        ];
    }

    public function dispatch(string $method, string $uri): mixed
    {
        $uri = parse_url($uri, PHP_URL_PATH);

        foreach ($this->routes[$method] as $route) {
            $pattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $route['uri']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                return $this->execute($route['action'], $matches);
            }
        }

        http_response_code(404);
        return "404 - Route not found!";
    }

    private function execute(string $action, array $params = []): mixed
    {
        [$controller, $method] = explode('@', $action);

        if (!class_exists($controller)) die ("Controller not found: {$controller}");

        $instance = new $controller;

        if (!method_exists($instance, $method)) die ("Method {$method} not found in {$controller}");

        return call_user_func_array([$instance, $method], $params);
    }
}