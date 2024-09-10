<?php

namespace src\Controllers;

use src\Models\Database;
use src\Repositories\UserRepository;
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

    public function pageProfil(?string $pseudo = NULL):void {
        if($pseudo) {
            $database = new Database();
            $UserRepository = UserRepository::getInstance($database);
            $utilisateur = $UserRepository->getThisUserByPseudo($pseudo);
            if(!$utilisateur) {
                $_SESSION['erreur'] = "Utilisateur non trouvé.";
                $this->render("accueil");
                return;
            }
        }
        else {
            $_SESSION['erreur'] = "Erreur : Aucun utilisateur trouvé.";
            $this->render("accueil");
            return;
        }

        if(isset($_GET['error'])) {
            $error = htmlspecialchars($_GET['error']);
        } 
        else {
            $error = '';
        }
        $this->render("profil", [
            "utilisateur" => $utilisateur,
            "error" => $error
        ]);
    }

    public function pageDisponibilite(?string $pseudo = NULL):void {
        if($pseudo) {
            $database = new Database();
            $UserRepository = UserRepository::getInstance($database);
            $utilisateur = $UserRepository->getThisUserByPseudo($pseudo);
            if(!$utilisateur) {
                $_SESSION['erreur'] = "Utilisateur non trouvé.";
                $this->render("accueil");
                return;
            }
        }
        else {
            $_SESSION['erreur'] = "Erreur : Aucun utilisateur trouvé.";
            $this->render("accueil");
            return;
        }

        if(isset($_GET['error'])) {
            $error = htmlspecialchars($_GET['error']);
        } 
        else {
            $error = '';
        }
        $this->render("disponibilite", [
            "utilisateur" => $utilisateur,
            "error" => $error
        ]);
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
        $this->render("accueil");
    }

    public function page404():void {
        header("HTTP/1.1 404 Not Found");
        $this->render('404');
    }

    public function pageCgu():void {
        if(isset($_GET['error'])) {
            $error = htmlspecialchars($_GET['error']);
        } 
        else {
            $error = '';
        }
        $this->render("cgu", ["error"=>$error]);
    }
}