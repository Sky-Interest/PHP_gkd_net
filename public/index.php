<?php 
    require '../helpers.php';
    // loadView('home');
    $routes = [
        '/' => 'controller/home.php',
        '/listings' => 'controller/listings/index.php',
        '/listings/create' => 'controller/listings/create.php',
        '404' => 'controller/listings/404.php',
    ];

    $uri = $_SERVER['REQUEST_URI'];
    inspectAndDie($uri);