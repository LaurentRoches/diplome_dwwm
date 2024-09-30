<?php

use src\Controllers\HomeController;
use src\Controllers\AdminController;
use src\Services\Routing;

$methode = $_SERVER['REQUEST_METHOD'];

$HomeController = new HomeController;
$AdminController = new AdminController;

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
                        $AdminController->ajouterArticle();
                        break;
                    }
                    $AdminController->pageAjouterArticle();
                    break;
                case 'update':
                    if($methode == 'POST') {
                        $AdminController->updateThisArticle();
                        break;
                    }
                    $AdminController->pageAjouterArticle($routeComposee[3]);
                    break;
                case 'delete':
                    $AdminController->deleteThisArticle($routeComposee[3]);
                    break;
                default:
                    $HomeController->pageAdmin();
                    break;
            }
            break;
        }
        $AdminController->pageAdminArticle();
        break;
    case 'jeu':
        if(isset($routeComposee[2])) {
            switch($routeComposee[2]) {
                case 'create':
                    if($methode == 'POST') {
                        $AdminController->ajouterJeu();
                        break;
                    }
                    $AdminController->pageAjouterJeu();
                    break;
                case 'update':
                    if($methode == 'POST') {
                        $AdminController->updateThisJeu();
                        break;
                    }
                    $AdminController->pageAjouterJeu($routeComposee[3]);
                    break;
                case 'delete':
                    $AdminController->deleteThisJeu($routeComposee[3]);
                    break;
                default:
                    $HomeController->pageAdmin();
                    break;
            }
            break;
        }
        $AdminController->pageAdminJeu();
        break;
    case 'categorieArticle':
        if(isset($routeComposee[2])) {
            switch($routeComposee[2]) {
                case 'create':
                    if($methode == 'POST') {
                        $AdminController->ajouterCategorieArticle();
                        break;
                    }
                    $AdminController->pageAjouterCategorieArticle();
                    break;
                case 'update':
                    if($methode == 'POST') {
                        $AdminController->updateThisCategorieArticle($routeComposee[3]);
                        break;
                    }
                    $AdminController->pageAjouterCategorieArticle($routeComposee[3]);
                    break;
                case 'delete':
                    $AdminController->deleteThisCategorieArticle($routeComposee[3]);
                    break;
                default:
                    $HomeController->pageAdmin();
                    break;
            }
            break;
        }
        $AdminController->pageAdminCategorieArticle();
        break;
    case 'categorieJeu':
        if(isset($routeComposee[2])) {
            switch($routeComposee[2]) {
                case 'create':
                    if($methode == 'POST') {
                        $AdminController->ajouterCategorieJeu();
                        break;
                    }
                    $AdminController->pageAjouterCategorieJeu();
                    break;
                case 'update':
                    if($methode == 'POST') {
                        $AdminController->updateThisCategorieJeu($routeComposee[3]);
                        break;
                    }
                    $AdminController->pageAjouterCategorieJeu($routeComposee[3]);
                    break;
                case 'delete':
                    $AdminController->deleteThisCategorieJeu($routeComposee[3]);
                    break;
                default:
                    $HomeController->pageAdmin();
                    break;
            }
            break;
        }
        $AdminController->pageAdminCategorieJeu();
        break;
    case 'user':
        if(isset($routeComposee[2])) {
            switch($routeComposee[2]) {
                case 'update':
                    if($methode == 'POST') {
                        $AdminController->updateThisUser($routeComposee[3]);
                        break;
                    }
                    $AdminController->pageAjouterUser($routeComposee[3]);
                    break;
                case 'delete':
                    $AdminController->deleteThisUser($routeComposee[3]);
                    break;
                default:
                    $HomeController->pageAdmin();
                    break;
            }
            break;
        }
        $AdminController->pageAdminUser();
        break;
    case 'tabou':
        if(isset($routeComposee[2])) {
            switch($routeComposee[2]) {
                case 'update':
                    if($methode == 'POST') {
                        $AdminController->updateThisTabou($routeComposee[3]);
                        break;
                    }
                    $AdminController->pageAjouterTabou($routeComposee[3]);
                    break;
                case 'delete':
                    $AdminController->deleteThisTabou($routeComposee[3]);
                    break;
                default:
                    $HomeController->pageAdmin();
                    break;
            }
            break;
        }
        $AdminController->pageAdminTabou();
        break;
    default :
        $HomeController->page404();
        break;
}