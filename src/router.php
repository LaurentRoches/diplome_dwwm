<?php

use src\Controllers\HomeController;
use src\Services\Routing;

$route = $_SERVER['REDIRECT_URL'];
$methode = $_SERVER['REQUEST_METHOD'];

$HomeController = new HomeController;

$routeComposee = Routing::routeComposee($route);

switch ($route) {
    case HOME_URL:
        if(isset($_SESSION['connected']) && $methode == "POST") {
            header("Location :" .HOME_URL."dashboard");
            die();
        } 
        else {
            $HomeController->index();
        }
        break;
    default :
        $HomeController->page404();
        break;
}
