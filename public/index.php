<?php 




    require './../vendor/autoload.php';
    require '../helpers.php';

    use Framework\Router;

    // require basePath('Framework/Database.php');
    // $config = require basePath('config/db.php');

    // $db = new Database($config);

    // require basePath('Framework/Router.php');

    $router = new Router();
    $routes = require basePath('routes.php');


    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    // $method = $_SERVER['REQUEST_METHOD'];

    $router->route($uri);


//使用phpserver插件启动项目时，第2.14步重置根路径时请在设置的relative path中修改路径

    