<?php

// $routes = require basePath('routes.php');
// if (array_key_exists($uri, $routes)) {

//     // inspect($uri);
//     require(basePath($routes[$uri]));
// } else {
//     // inspect($routes);
//     http_response_code(404);
//     require(basePath($routes['404']));
// }

class Router
{
    protected $routes = [];

    private function registerRoute($method, $uri, $controller)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller
        ];
    }

    //添加GET路由
    public function addGet($uri, $controller)
    {
        $this->registerRoute('GET', $uri, $controller);
    }

    //添加POST路由
    public function addPost($uri, $controller)
    {
        $this->registerRoute('POST', $uri, $controller);
    }

    //添加PUT路由
    public function addPut($uri, $controller)
    {
        $this->registerRoute('PUT', $uri, $controller);
    }

    //添加DELETE路由
    public function addPatch($uri, $controller)
    {
        $this->registerRoute('DELETE', $uri, $controller);
    }

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['uri'] === $uri) {
                require basePath($route['controller']);
                return;
            }
        }
        http_response_code(404);
        loadView('error/404');
    }
}
