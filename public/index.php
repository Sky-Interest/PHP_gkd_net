<?php 
    require '../helpers.php';
    require basePath('Router.php');
    // loadView('home');
    // $routes = [
    //     '/' => 'controllers/home.php',
    //     '/listings' => 'controllers/listings/index.php',
    //     '/listings/create' => 'controllers/listings/create.php',
    //     '404' => 'controllers/error/404.php',
    // ];

    $router = new Router();
    $routes = require basePath('routes.php');


    $uri = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];


    
//这里uri获取到的是public/index，而在$routes中不存在这段，所以错误
//使用phpserver插件启动项目时，第14步重置根路径时请在设置的relative path中修改路径

    $router->route($uri, $method);