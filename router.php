<?php

$routes = require basePath('routes.php');
if (array_key_exists($uri, $routes)) {
    
    // inspect($uri);
    require(basePath($routes[$uri]));
} else {
    // inspect($routes);
    http_response_code(404);
    require(basePath($routes['404']));
}