<?php

namespace src\Controllers;

use src\Models\Article;
use src\Models\Database;
use src\Models\Game;
use src\Repositories\ArticleRepository;
use src\Repositories\GameRepository;
use src\Services\Reponse;
use src\Services\Securite;

class AdminController {

    use Securite;
    use Reponse;

    public function pageAdminArticle() {
        $this->render("adminArticleListe");
    }

    public function pageAjouterArticle(?int $id_article = 0) {
        if($id_article != 0) {
            $id_article = intval($id_article);
            $database = new Database();
            $ArticleRepository = ArticleRepository::getInstance($database);
            $article = $ArticleRepository->getThisArticle($id_article);
            $article = $this->sanitize($article);
        }
        else {
            $article = NULL;
        }
        $this->render("adminArticle", ["article" => $article]);
    }

    public function ajouterArticle() {
        $data = $_POST;
        $data = $this->sanitize($data);

        foreach($data as $entree) {
            if(!isset($entree) || $entree == '') {
                $_SESSION['erreur'] = "Toutes les entrées de cet article sont importantes.";
                $this->render("adminArticle", ["erreur" => $_SESSION['erreur']]);
                return;
            }
        }
        $database = new Database();
        $ArticleRepository = ArticleRepository::getInstance($database);
        $article = new Article($data);

        $creer = $ArticleRepository->createArticle($article);
        if($creer) {
            $_SESSION['succes'] = "Article créer avec succès!";
            $this->render("adminArticleListe", ["succes" => $_SESSION['succes']]);
            return;
        }
        else {
            $_SESSION["erreur"] = "Echec de l'enregistrment.";
            $this->render("adminArticle", ["erruer" => $_SESSION["erreur"]]);
            return;
        }
    }

    public function updateThisArticle() {
        $data = $_POST;
        $data = $this->sanitize($data);

        foreach($data as $entree) {
            if(!isset($entree) || $entree == '') {
                $_SESSION['erreur'] = "Toutes les entrées de cet article sont importantes.";
                $this->render("adminArticle", ["erreur" => $_SESSION['erreur']]);
                return;
            }
        }
        $database = new Database();
        $ArticleRepository = ArticleRepository::getInstance($database);
        $article = new Article($data);

        $maj = $ArticleRepository->updateArticle($article);
        if($maj) {
            $_SESSION['succes'] = "Article mis à jour avec succès.";
        } 
        else {
            $_SESSION['erreur'] = "Erreur lors de la mise à jour de l'article.";
        }
        $this->render("adminArticleListe");
    }

    public function deleteThisArticle(int $id_article) {
        $id_article = intval($id_article);
        $database = new Database();
        $ArticleRepository = ArticleRepository::getInstance($database);

        $suppression = $ArticleRepository->deleteThisArticle($id_article);
        if($suppression) {
            $_SESSION['succes'] = "Article éffacé avec succès de la liste.";
            $this->render("adminArticleListe", ['succes' => $_SESSION['succes']]);
            return;
        }
        else {
            $_SESSION['erreur'] = "Une erreur est survenue lors de la suppression.";
            $this->render("adminArticleListe", ['erreur' => $_SESSION['erreur']]);
            return;
        }
    }

    public function pageAdminJeu() {
        $this->render("adminJeuListe");
    }

    public function pageAjouterJeu(?int $id_game = 0) {
        if($id_game != 0) {
            $id_game = intval($id_game);
            $database = new Database();
            $GameRepository = GameRepository::getInstance($database);
            $game = $GameRepository->getThisGame($id_game);
            $game = $this->sanitize($game);
        }
        else {
            $game = NULL;
        }
        $this->render("adminJeu", ["game" => $game]);
    }

    public function ajouterJeu() {
        $data = $_POST;
        $data = $this->sanitize($data);

        foreach($data as $entree) {
            if(!isset($entree) || $entree == '') {
                $_SESSION['erreur'] = "Toutes les entrées pour ce jeu sont importantes.";
                $this->render("adminJeu", ["erreur" => $_SESSION['erreur']]);
                return;
            }
        }
        $database = new Database();
        $GameRepository = GameRepository::getInstance($database);
        $game = new Game($data);

        $creer = $GameRepository->createGame($game);
        if($creer) {
            $_SESSION['succes'] = "Jeu créer avec succès!";
            $this->render("adminJeuListe", ["succes" => $_SESSION['succes']]);
            return;
        }
        else {
            $_SESSION["erreur"] = "Echec de l'enregistrment.";
            $this->render("adminJeu", ["erruer" => $_SESSION["erreur"]]);
            return;
        }
    }

    public function updateThisJeu() {0
        $data = $_POST;
        $data = $this->sanitize($data);

        foreach($data as $entree) {
            if(!isset($entree) || $entree == '') {
                $_SESSION['erreur'] = "Toutes les entrées pour ce jeu sont importantes.";
                $this->render("adminJeu", ["erreur" => $_SESSION['erreur']]);
                return;
            }
        }
        $database = new Database();
        $GameRepository = GameRepository::getInstance($database);
        $game = new Game($data);
        
        $maj = $GameRepository->updateGame($game);
        if($maj) {
            $_SESSION['succes'] = "Jeu mis à jour avec succès.";
        } 
        else {
            $_SESSION['erreur'] = "Erreur lors de la mise à jour du jeu.";
        }
        $this->render("adminJeuListe");
    }

    public function deleteThisJeu(int $id_game) {
        $id_game = intval($id_game);
        $database = new Database();
        $GameRepository = GameRepository::getInstance($database);

        $suppression = $GameRepository->deleteThisGame($id_game);
        if($suppression) {
            $_SESSION['succes'] = "Jeu éffacé avec succès de la liste.";
            $this->render("adminJeuListe", ['succes' => $_SESSION['succes']]);
            return;
        }
        else {
            $_SESSION['erreur'] = "Une erreur est survenue lors de la suppression.";
            $this->render("adminJeuListe", ['erreur' => $_SESSION['erreur']]);
            return;
        }
    }

}