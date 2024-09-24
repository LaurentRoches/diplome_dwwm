<?php

use src\Controllers\HomeController;
use src\Controllers\UserController;
use src\Services\Routing;

$methode = $_SERVER['REQUEST_METHOD'];

$HomeController = new HomeController;
$UserController = new UserController;

$routeComposee = Routing::routeComposee($route);

switch ($routeComposee[1]) {
    case 'dashboard':
        $HomeController->pageAdmin();
        break;
    case 'article':
        if(isset($routeComposee[2])) {
            switch($routeComposee[2]) {
                case 'create':
                    if($methode == 'POST') {
                        $UserController->ajouterArticle();
                        break;
                    }
                    $HomeController->pageAjouterArticle();
                    break;
                case 'update':
                    if($methode == 'POST') {
                        $UserController->updateThisArticle($routeComposee[3]);
                        break;
                    }
                    $HomeController->pageAjouterArticle($routeComposee[3]);
                    break;
                case 'delete':
                    $UserController->deleteThisArticle($routeComposee[3]);
                    break;
                default:
                    $HomeController->pageAdmin();
                    break;
            }
        }
        $HomeController->pageAdminArticle();
        break;
    case 'jeu':
        if(isset($routeComposee[2])) {
            switch($routeComposee[2]) {
                case 'create':
                    if($methode == 'POST') {
                        $UserController->ajouterJeu();
                        break;
                    }
                    $HomeController->pageAjouterJeu();
                    break;
                case 'update':
                    if($methode == 'POST') {
                        $UserController->updateThisJeu($routeComposee[3]);
                        break;
                    }
                    $HomeController->pageAjouterJeu($routeComposee[3]);
                    break;
                case 'delete':
                    $UserController->deleteThisJeu($routeComposee[3]);
                    break;
                default:
                    $HomeController->pageAdmin();
                    break;
            }
        }
        $HomeController->pageAdminJeu();
        break;
    case 'categorieArticle':
        if(isset($routeComposee[2])) {
            switch($routeComposee[2]) {
                case 'create':
                    if($methode == 'POST') {
                        $UserController->ajouterCategorieArticle();
                        break;
                    }
                    $HomeController->pageAjouterCategorieArticle();
                    break;
                case 'update':
                    if($methode == 'POST') {
                        $UserController->updateThisCategorieArticle($routeComposee[3]);
                        break;
                    }
                    $HomeController->pageAjouterCategorieArticle($routeComposee[3]);
                    break;
                case 'delete':
                    $UserController->deleteThisCategorieArticle($routeComposee[3]);
                    break;
                default:
                    $HomeController->pageAdmin();
                    break;
            }
        }
        $HomeController->pageAdminCategorieArticle();
        break;
    case 'categorieJeu':
        if(isset($routeComposee[2])) {
            switch($routeComposee[2]) {
                case 'create':
                    if($methode == 'POST') {
                        $UserController->ajouterCategorieJeu();
                        break;
                    }
                    $HomeController->pageAjouterCategorieJeu();
                    break;
                case 'update':
                    if($methode == 'POST') {
                        $UserController->updateThisCategorieJeu($routeComposee[3]);
                        break;
                    }
                    $HomeController->pageAjouterCategorieJeu($routeComposee[3]);
                    break;
                default:
                    $HomeController->pageAdmin();
                    break;
            }
        }
        $HomeController->pageAdminCategorieJeu();
        break;
    case 'user':
        if(isset($routeComposee[2])) {
            switch($routeComposee[2]) {
                case 'update':
                    if($methode == 'POST') {
                        $UserController->updateThisUser($routeComposee[3]);
                        break;
                    }
                    $HomeController->pageAjouterUser($routeComposee[3]);
                    break;
                case 'delete':
                    $UserController->deleteThisUser($routeComposee[3]);
                    break;
                default:
                    $HomeController->pageAdmin();
                    break;
            }
        }
        $HomeController->pageAdminUser();
        break;
    default :
        $HomeController->page404();
        break;
}