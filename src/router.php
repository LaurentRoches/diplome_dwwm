<?php

use src\Controllers\HomeController;
use src\Services\Routing;

$route = $_SERVER['REDIRECT_URL'];
$methode = $_SERVER['REQUEST_METHOD'];

$HomeController = new HomeController;

$routeComposee = Routing::routeComposee($route);

switch ($route) {
    case HOME_URL:
        $HomeController->index();
        break;
    case HOME_URL . 'connexion' :
        if($methode = "GET") {
           if(isset($_SESSION['connecte'])) {
                $HomeController->pageProfile();
                break;
            }
            else {
                $HomeController->pageConnexion();
                break;
            } 
        }
        elseif($methode = "POST") {
            $UserController->connexion();
            break;
        }
        
    case HOME_URL . 'inscription' :
        if($methode = "GET") {
            if(isset($_SESSION['connecte'])) {
                $HomeController->pageProfile();
                break;
            }
            else {
                $HomeController->pageInscription();
                break;
            }
        }
        elseif($methode = "POST"){
            $UserController->inscription();
            break;
        }
    case HOME_URL . 'deconnexion' :
        $HomeController->deconnexion();
        break;
    default :
        $HomeController->page404();
        break;
}
