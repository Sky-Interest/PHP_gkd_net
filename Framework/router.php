<?php

namespace Framework;

use App\Controllers\ErrorController;
use Framework\Middleware\Authorise;

class Router
{
    protected $routes = [];

    private function registerRoute($method, $uri, $action, $middleware= [])
    {
        list($controller, $controllerMethod) = explode('@', $action);

        // inspectAndDie($controllerMethon);
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod,
            'middleware' => $middleware
        ];
    }

    //添加GET路由
    public function addGet($uri, $controller, $middleware = [])
    {
        $this->registerRoute('GET', $uri, $controller, $middleware);
    }

    //添加POST路由
    public function addPost($uri, $controller,$middleware = [])
    {
        $this->registerRoute('POST', $uri, $controller, $middleware);
    }

    //添加PUT路由
    public function addPut($uri, $controller,$middleware = [])
    {
        $this->registerRoute('PUT', $uri, $controller, $middleware);
    }

    //添加DELETE路由
    public function addDelete($uri, $controller,$middleware = [])
    {
        $this->registerRoute('DELETE', $uri, $controller, $middleware);
    }

    public function route($uri)
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        // var_dump($requestMethod);
        //检查POST中的特殊字段 _method

        if ($requestMethod === 'POST' && isset($_POST['_method'])){
            //重写方法
        // var_dump($requestMethod);

            $requestMethod = strtoupper($_POST['_method']);
        // var_dump($requestMethod);
        // return;

        };

        //拆分当前URI

        $uriSegments = explode('/', trim($uri, '/'));





        foreach ($this->routes as $route) {
            //拆分路由URI
            $routeSegments = explode('/', trim($route['uri'], '/'));

            $match = false;

            //检查拆分后字符串片段数是否匹配
            if (count($uriSegments) === count($routeSegments) && strtoupper($route['method'] === $requestMethod)) {
                $params = [];
                $match = true;

                for ($i = 0; $i < count($uriSegments); $i++) {
                    //如果有uri不匹配或参数不存在
                    if ($routeSegments[$i] !== $uriSegments[$i] && !preg_match('/\{(.+?)\}/', $routeSegments[$i])) {
                        $match = false;
                        break;
                    }

                    //检查并提取数字
                    if (preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)) {
                        $params[$matches[1]] = $uriSegments[$i];
                    }
                }
            }

            if ($match) {

                foreach($route['middleware'] as $middleware){
                    (new Authorise())->handle($middleware);
                }

                //获取控制器和控制器方法
                $controller = 'App\\Controllers\\' . $route['controller'];
                $controllerMethod = $route['controllerMethod'];

                //实例化控制器和控制器方法
                $controllerInstance = new $controller();
                $controllerInstance->$controllerMethod($params);
                return;
            }
            // http_response_code(404);
            // loadView('error/404');
            // $this->error();
        }
        ErrorController::notFound();
    }
    //接收HTTP状态码参数
    // public function error($httpCode = 404)
    // {
    //     http_response_code($httpCode);
    //     loadView("error/{$httpCode}");
    //     exit;
    // }
}
