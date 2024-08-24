<?php

namespace src\Controllers;

use src\Services\Reponse;
use src\Services\Securite;

class HomeController {

    use Reponse;
    use Securite;

    public function index():void {
        if(isset($_GET['error'])) {
            $error = htmlspecialchars($_GET['error']);
        } 
        else {
            $error = '';
        }
        $this->render("accueil", ["error"=>$error]);
    }

    public function pageConnexion():void {
        if(isset($_GET['error'])) {
            $error = htmlspecialchars($_GET['error']);
        } 
        else {
            $error = '';
        }
        $this->render("connexion", ["error"=>$error]);
    }

    public function pageProfile():void {
        if(isset($_GET['error'])) {
            $error = htmlspecialchars($_GET['error']);
        } 
        else {
            $error = '';
        }
        $this->render("profile", ["error"=>$error]);
    }

    public function pageInscription():void {
        if(isset($_GET['error'])) {
            $error = htmlspecialchars($_GET['error']);
        } 
        else {
            $error = '';
        }
        $this->render("inscription", ["error"=>$error]);
    }

    public function deconnexion():void {
        session_unset();
        session_destroy();
        session_regenerate_id(true);
        $this->render("accueil");
    }

    public function page404():void {
        header("HTTP/1.1 404 Not Found");
        $this->render('404');
    }
}