<?php


$router->addGet('/','HomeControllers@index');
$router->addGet('/listings','controllers/listings/index.php');
$router->addGet('/listings/create','controllers/listings/create.php');
$router->addGet('/listing','controllers/listings/show.php');