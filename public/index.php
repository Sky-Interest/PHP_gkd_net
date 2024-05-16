<?php 
    require '../helpers.php';
    // loadView('home');
    // $routes = [
    //     '/' => 'controllers/home.php',
    //     '/listings' => 'controllers/listings/index.php',
    //     '/listings/create' => 'controllers/listings/create.php',
    //     '404' => 'controllers/error/404.php',
    // ];

    $uri = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];

    inspect($uri);
    inspect($method);
    // inspectAndDie($uri);
//这里uri获取到的是public/index，而在$routes中不存在这段，所以错误
//使用phpserver插件启动项目时，第14步重置根路径时请在设置的relative path中修改路径
// if (array_key_exists($uri, $routes)) {
    
//     // inspect($uri);
//     require(basePath($routes[$uri]));
// } else {
//     // inspect($routes);
//     require(basePath($routes['404']));
// }
    require(basePath('router.php'));