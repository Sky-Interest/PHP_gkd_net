<?php 
    require '../helpers.php';

    require basePath('Database.php');
    // $config = require basePath('config/db.php');

    // $db = new Database($config);

    require basePath('Router.php');

    $router = new Router();
    $routes = require basePath('routes.php');


    $uri = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];


    
//这里uri获取到的是public/index，而在$routes中不存在这段，所以错误
//使用phpserver插件启动项目时，第14步重置根路径时请在设置的relative path中修改路径

    $router->route($uri, $method);