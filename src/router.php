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
        break;
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
        break;
    case $routeComposee[0] == 'mdpoublie':
        if($methode == 'POST') {
            $UserController->mdpOublie();
            break;
        }
        $HomeController->pageMdpOublie();
        break;
    case $routeComposee[0] == 'profil' :
        if(isset($routeComposee[2]) && $routeComposee[2] == 'update'){
            if($methode == 'GET') {
                $HomeController->pageUpdateProfil($routeComposee[1]);
                break;
            }
            elseif($methode == 'POST') {
                $UserController->updateUser($routeComposee[1]);
                break;
            }
            break;
        }
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
        break;
    case $routeComposee[0] == 'article':
        if(isset($routeComposee[1])) {
            if($methode == 'POST') {
                $UserController->addAvisArticle();
                break;
            }
            $HomeController->pageArticle(intval($routeComposee[1]));
            break;
        }
        $HomeController->pageArticleListe();
        break;
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
            break;
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
        break;
    case $routeComposee[0] == 'connu':
        if(isset($routeComposee[2]) && !empty($routeComposee[2])) {
            if($routeComposee[2] == 'add' && $methode == 'POST') {
                $UserController->ajoutGameConnu($routeComposee[1], $routeComposee[3]);
                break;
            }
            if($routeComposee[2] == 'delete') {
                if(isset($routeComposee[3]) && !empty($routeComposee[3])) {
                    $UserController->deleteThisGameConnu($routeComposee[3], $routeComposee[1]);
                    break;
                }
                else {
                    $_SESSION['erreur'] = "Une erreur est survenue lors de la suppression.";
                    $HomeController->pageConnu($routeComposee[1]);
                    break;
                }
            }
            break;
        }
        if(isset($routeComposee[1]) && !empty($routeComposee[1])){
            $HomeController->pageConnu($routeComposee[1]);
            break;
        }
        else {
            $_SESSION['erreur'] = "Erreur dans le chargement de la liste des jeux connus.";
            $HomeController->index();
            break;
        }
        break;
    case $routeComposee[0] == 'voulu':
        if(isset($routeComposee[2]) && !empty($routeComposee[2])) {
            if($routeComposee[2] == 'add' && $methode == 'POST') {
                $UserController->ajoutGameVoulu($routeComposee[1], $routeComposee[3]);
                break;
            }
            if($routeComposee[2] == 'delete') {
                if(isset($routeComposee[3]) && !empty($routeComposee[3])) {
                    $UserController->deleteThisGameVoulu($routeComposee[3], $routeComposee[1]);
                    break;
                }
                else {
                    $_SESSION['erreur'] = "Une erreur est survenue lors de la suppression.";
                    $HomeController->pageVoulu($routeComposee[1]);
                    break;
                }
            }
            break;
        }
        if(isset($routeComposee[1]) && !empty($routeComposee[1])){
            $HomeController->pageVoulu($routeComposee[1]);
            break;
        }
        else {
            $_SESSION['erreur'] = "Erreur dans le chargement de la liste des jeux voulus.";
            $HomeController->index();
            break;
        }
        break;
    case $routeComposee[0] == 'message':
        if(isset($routeComposee[2]) && !empty($routeComposee[2])) {
            if($routeComposee[2] == 'delete') {
                $UserController->supprimerMessage($routeComposee[3], $routeComposee[1]);
                break;
            }
            elseif( $routeComposee[2] == 'conversation') {
                if($methode == 'POST') {
                    $UserController->envoyerMessageConversation();
                    break;
                }
                $HomeController->pageConverstation($routeComposee[1], $routeComposee[3]);
                break;
            }
            break;
        }
        if(isset($routeComposee[1]) && !empty($routeComposee[1])){
            switch ($methode) {
                case 'GET':
                    $HomeController->pageMessage($routeComposee[1]);
                    break;
                case 'POST':
                    $UserController->envoyerMessage($routeComposee[1]);
                    break;
                default:
                    $HomeController->pageMessage($routeComposee[1]);
                    break;
            }
        }
        else {
            $_SESSION['erreur'] = "Erreur dans le chargement de la liste des messages.";
            $HomeController->index();
            break;
        }
        break;
    case $routeComposee[0] == 'userliste':
        $HomeController->pageUserListe();
        break;
    case $routeComposee[0] == 'vote':
        if(!isset($routeComposee[1])) {
            $_SESSION['erreur'] = "Utilisateur non trouvé.";
            $HomeController->index();
            break;
        }
        $UserController->addVote($routeComposee[1]);
        break;
    case $routeComposee[0] == 'deconnexion' :
        $HomeController->deconnexion();
        break;
    case $routeComposee[0] == 'cgu' :
        $HomeController->pageCgu();
        break;
    case $routeComposee[0] == 'validation':
        if($methode == 'GET') {
            $HomeController->pageValidation();
            break;
        }
        else {
            $UserController->validation();
            break;
        }
    case $routeComposee[0] == 'deleteProfil':
        if(isset($routeComposee[1]) && !empty($routeComposee[1])){
            $UserController->deleteProfil($routeComposee[1]);
            break;
        }
        else {
            $_SESSION['erreur'] = 'Une erreur lors de la suppression est survenue.';
            $HomeController->index();
            break;
        }
    case $routeComposee[0] == 'admin':
        if(isset($_SESSION['connecte'])) {
            $user = unserialize($_SESSION['user']);
            if($user->getIdRole() == 2 || $user->getIdRole() == 2) {
                include __DIR__.'/routerAdmin.php';
                break;
            }
            else {
                $_SESSION['erreur'] = "Vous n'avez pas les droits suffisant.";
                $HomeController->index();
                break;
            }
        }
        else {
            $_SESSION['erreur'] = "Vous devez être connecté.";
            $HomeController->index();
            break;
        }
    default :
        $HomeController->page404();
        break;
}
