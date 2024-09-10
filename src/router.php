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
    case $routeComposee[0] == 'connexion' :
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
    case $routeComposee[0] == 'inscription' :
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
    case $routeComposee[0] == 'profil' :
        if(isset($routeComposee[1]) && !empty($routeComposee[1])){
            $HomeController->pageProfil($routeComposee[1]);
            break;
        }
        elseif(isset($_SESSION['user'])) {
            $user = unserialize($_SESSION['user']);
            $HomeController->pageProfil($user->getStrPseudo());
            break;
        }
        else {
            $_SESSION['erreur'] = "Erreur dans le chargement du profil.";
            $HomeController->index();
            break;
        }
    case $routeComposee[0] == 'disponibilite':
        if(isset($routeComposee[2]) && !empty($routeComposee[2])) {
            if($routeComposee [2] == 'add' && $methode == 'POST') {
                $UserController->ajoutDisponibilite($routeComposee[1]);
                break;
            }
            if($routeComposee[2] == 'delete') {
                if(isset($routeComposee[3]) && !empty($routeComposee[3])){
                    $UserController->deleteThisDispo($routeComposee[3], $routeComposee[1]);
                    break;
                }
                else {
                    $_SESSION['erreur'] = "Une erreur est survenue lors de la suppression.";
                    $HomeController->pageDisponibilite($routeComposee[1]);
                    break;
                }
            }
        }
        if(isset($routeComposee[1]) && !empty($routeComposee[1])){
            $HomeController->pageDisponibilite($routeComposee[1]);
            break;
        }
        else {
            $_SESSION['erreur'] = "Erreur dans le chargement des disponibilités.";
            $HomeController->index();
            break;
        }
    case $routeComposee[0] == 'userliste':
        $HomeController->pageUserListe();
        break;
    case $routeComposee[0] == 'deconnexion' :
        $HomeController->deconnexion();
        break;
    case $routeComposee[0] == 'cgu' :
        $HomeController->pageCgu();
        break;
    default :
        $HomeController->page404();
        break;
}
