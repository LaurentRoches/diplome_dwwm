<?php

namespace src\Controllers;

use src\Models\Database;
use src\Repositories\ArticleRepository;
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
            $utilisateur = $UserRepository->getThisUserByPseudo(htmlspecialchars($pseudo, ENT_QUOTES | ENT_HTML401, 'UTF-8', false));
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
            $utilisateur = $UserRepository->getThisUserByPseudo(htmlspecialchars($pseudo, ENT_QUOTES | ENT_HTML401, 'UTF-8', false));
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

    public function pageConnu(?string $pseudo = NULL):void {
        if($pseudo) {
            $database = new Database();
            $UserRepository = UserRepository::getInstance($database);
            $utilisateur = $UserRepository->getThisUserByPseudo(htmlspecialchars($pseudo, ENT_QUOTES | ENT_HTML401, 'UTF-8', false));
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
        $this->render("connu", [
            "utilisateur" => $utilisateur,
            "error" => $error
        ]);
    }

    public function pageVoulu(?string $pseudo = NULL):void {
        if($pseudo) {
            $database = new Database();
            $UserRepository = UserRepository::getInstance($database);
            $utilisateur = $UserRepository->getThisUserByPseudo(htmlspecialchars($pseudo, ENT_QUOTES | ENT_HTML401, 'UTF-8', false));
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
        $this->render("voulu", [
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

    public function pageUserListe():void {
        $this->render('userliste');
    }

    public function pageMessage(?string $pseudo = NULL):void {
        if($pseudo) {
            $database = new Database();
            $UserRepository = UserRepository::getInstance($database);
            $utilisateur = $UserRepository->getThisUserByPseudo(htmlspecialchars($pseudo, ENT_QUOTES | ENT_HTML401, 'UTF-8', false));
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
        $this->render("message", [
            "utilisateur" => $utilisateur,
            "error" => $error
        ]);
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

    public function pageValidation() {
        $this->render("validation");
    }

    public function pageConverstation(?string $pseudo_destinataire = NULL, ?string $pseudo_expediteur = NULL):void {
        if($pseudo_destinataire) {
            $database = new Database();
            $UserRepository = UserRepository::getInstance($database);
            $destinataire = $UserRepository->getThisUserByPseudo(htmlspecialchars($pseudo_destinataire, ENT_QUOTES | ENT_HTML401, 'UTF-8', false));
            if(!$destinataire) {
                $_SESSION['erreur'] = "destinataire non trouvé.";
                $this->render("accueil");
                return;
            }
        }
        else {
            $_SESSION['erreur'] = "Erreur : Aucun destinataire trouvé.";
            $this->render("accueil");
            return;
        }
        if($pseudo_expediteur) {
            $expediteur = $UserRepository->getThisUserByPseudo(htmlspecialchars($pseudo_expediteur, ENT_QUOTES | ENT_HTML401, 'UTF-8', false));
            if(!$expediteur) {
                $_SESSION['erreur'] = "expediteur non trouvé.";
                $this->render("accueil");
                return;
            }
        }
        else {
            $_SESSION['erreur'] = "Erreur : Aucun expediteur trouvé.";
            $this->render("accueil");
            return;
        }
        $this->render('conversation', [
            'destinataire' => $destinataire,
            'expediteur' => $expediteur
        ]);
    }

    public function pageUpdateProfil(?string $pseudo = NULL):void {
        if($pseudo) {
            $database = new Database();
            $UserRepository = UserRepository::getInstance($database);
            $utilisateur = $UserRepository->getThisUserByPseudo(htmlspecialchars($pseudo, ENT_QUOTES | ENT_HTML401, 'UTF-8', false));
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
        $this->render("updateProfil", [
            "utilisateur" => $utilisateur
        ]);
    }

    public function pageAdmin() {
        $this->render("dashboard");
    }

    public function pageArticleListe() {
        $this->render("articleliste");
    }

    public function pageArticle(int $id_article) {
        if($id_article == 0) {
            $_SESSION['erreur'] = "Une erreur de chargement de l'article est survenue.";
            $this->render("accueil", ["erreur" => $_SESSION['erreur']]);
            return;
        }
        $database = new Database();
        $ArticleRepository = ArticleRepository::getInstance($database);
        $article = $ArticleRepository->getThisArticle($id_article);
        if($article) {
            $this->render("article", ["article" => $article]);
            return;
        }
        else {
            $_SESSION['erreur'] = "Une erreur de chargement de l'article est survenue.";
            $this->render("accueil", ["erreur" => $_SESSION['erreur']]);
            return;
        }
    }

    public function pageMdpOublie() {
        $this->render("mdpoublie");
    }
}