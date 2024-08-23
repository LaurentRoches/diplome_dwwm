<?php

use src\Controllers\HomeController;
use src\Controllers\ResaController;
use src\Services\Routing;

$route = $_SERVER['REDIRECT_URL'];
$methode = $_SERVER['REQUEST_METHOD'];

$HomeController = new HomeController;
$ResaController = new ResaController;

// ici le :: permet d'appeler la fonction static de la class Routing
$routeComposee = Routing::routeComposee($route);

switch ($route) {
    case HOME_URL:
        if (!$HomeController->login()) {
            $HomeController->index();
        } else {
            header("location:" . HOME_URL . "dashboard");
            die;
        };
        break;
    case HOME_URL . 'login':
        $HomeController->login();
        header("location:" . HOME_URL);
        break;
    case HOME_URL . 'register':
        $HomeController->pageRegister();
        break;
    case HOME_URL . 'addUser':
        $HomeController->addUser();
        header("location:" . HOME_URL);
        break;
    case HOME_URL . 'pageResa':
        $HomeController->pageResaFormulaire();
        break;
    case HOME_URL . 'deconnexion':
        $HomeController->quit();
        break;
    case HOME_URL . 'dashboard':
        $HomeController->pageDashboard();
        break;
    case HOME_URL . 'addResa':
        $ResaController->addResa();
        header("location:" . HOME_URL . "dashboard");
        break;
}
