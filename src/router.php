<?php

use src\Controllers\HomeController;
use src\Controllers\UserController;
use src\Services\Routing;

$route = $_SERVER['REDIRECT_URL'];
$methode = $_SERVER['REQUEST_METHOD'];

$HomeController = new HomeController;
$UserController = new UserController;

$routeComposee = Routing::routeComposee($route);

switch ($route) {
    case HOME_URL:
        $HomeController->index();
        break;
    case HOME_URL . 'connexion' :
        if($methode == "GET") {
           if(isset($_SESSION['connecte'])) {
                $HomeController->pageProfil();
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
        if($methode == "GET") {
            if(isset($_SESSION['connecte'])) {
                $HomeController->pageProfil();
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
    case HOME_URL . 'profil' :
        if(isset($_SESSION['user'])) {
            $HomeController->pageProfil();
            break;
        }
        else {
            $_SESSION['erreur'] = "Erreur dans le chargement du profile.";
            $HomeController->index();
            break;
        }
        
    case HOME_URL . 'deconnexion' :
        $HomeController->deconnexion();
        break;
    case HOME_URL . 'cgu' :
        $HomeController->pageCgu();
        break;
    default :
        $HomeController->page404();
        break;
}
