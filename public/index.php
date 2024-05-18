<?php


require './../vendor/autoload.php';
require '../helpers.php';

use Framework\Router;
use Framework\Session;

Session::start();

$router = new Router();
$routes = require basePath('routes.php');


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->route($uri);


//使用phpserver插件启动项目时，第2.14步重置根路径时请在设置的relative path中修改路径
