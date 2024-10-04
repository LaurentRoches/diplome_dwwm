<?php

namespace src\Controllers;

use src\Models\Article;
use src\Models\CategorieArticle;
use src\Models\CategorieGame;
use src\Models\Database;
use src\Models\Game;
use src\Models\Tabou;
use src\Repositories\ArticleRepository;
use src\Repositories\GameRepository;
use src\Repositories\TabouRepository;
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
            if(empty($entree)) {
                $_SESSION['erreur'] = "Toutes les entrées de cet article sont importantes.";
                $this->render("adminArticle", ["erreur" => $_SESSION['erreur']]);
                return;
            }
        }
        $database = new Database();
        $ArticleRepository = ArticleRepository::getInstance($database);
        $tab_categorie_article = $data['id_categorie_article'];
        unset($data['id_categorie_article']);
        $article = new Article($data);

        $reussis = $ArticleRepository->createArticle($article, $tab_categorie_article);
    
        if($reussis) {
            $_SESSION['succes'] = "Article créer avec succès!";
            $this->render("adminArticleListe", ["succes" => $_SESSION['succes']]);
            return;
        }
        else {
            $_SESSION["erreur"] = "Echec de l'enregistrment.";
            $this->render("adminArticle", ["erreur" => $_SESSION["erreur"]]);
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
        $tab_categorie_article = $data['id_categorie_article'];
        unset($data['id_categorie_article']);
        $article = new Article($data);

        $maj = $ArticleRepository->updateArticle($article, $tab_categorie_article);
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

    public function updateThisJeu() {
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

    public function pageAdminCategorieJeu() {
        $this->render("adminCategorieJeuListe");
    }

    public function pageAjouterCategorieJeu(?int $id_categorie_game = 0) {
        if($id_categorie_game != 0) {
            $id_categorie_game = intval($id_categorie_game);
            $database = new Database();
            $GameRepository = GameRepository::getInstance($database);
            $categorie = $GameRepository->getThisCategorie($id_categorie_game);
            $categorie = $this->sanitize($categorie);
        }
        else {
            $categorie = NULL;
        }
        $this->render("adminCategorieJeu", ["categorie" => $categorie]);
    }

    public function ajouterCategorieJeu() {
        $data = $_POST;
        $data = $this->sanitize($data);

        foreach($data as $entree) {
            if(!isset($entree) || $entree == '') {
                $_SESSION['erreur'] = "Toutes les entrées pour cette catégorie sont importantes.";
                $this->render("adminCategorieJeu", ["erreur" => $_SESSION['erreur']]);
                return;
            }
        }
        $database = new Database();
        $GameRepository = GameRepository::getInstance($database);
        $categorie = new CategorieGame($data);

        $creer = $GameRepository->createCategorie($categorie);
        if($creer) {
            $_SESSION['succes'] = "Catégorie créer avec succès!";
            $this->render("adminCategorieJeuListe", ["succes" => $_SESSION['succes']]);
            return;
        }
        else {
            $_SESSION["erreur"] = "Echec de l'enregistrment.";
            $this->render("adminCategorieJeu", ["erruer" => $_SESSION["erreur"]]);
            return;
        }
    }

    public function updateThisCategorieJeu() {
        $data = $_POST;
        $data = $this->sanitize($data);

        foreach($data as $entree) {
            if(!isset($entree) || $entree == '') {
                $_SESSION['erreur'] = "Toutes les entrées pour cette catégorie sont importantes.";
                $this->render("adminCategorieJeu", ["erreur" => $_SESSION['erreur']]);
                return;
            }
        }
        $database = new Database();
        $GameRepository = GameRepository::getInstance($database);
        $categorie = new CategorieGame($data);

        $maj = $GameRepository->updateCategorieGame($categorie);
        if($maj) {
            $_SESSION['succes'] = "Catégorie mise à jour avec succès.";
        } 
        else {
            $_SESSION['erreur'] = "Erreur lors de la mise à jour de la catégorie.";
        }
        $this->render("adminCategorieJeuListe");
    }

    public function deleteThisCategorieJeu(int $id_categorie_game) {
        $id_categorie_game = intval($id_categorie_game);
        $database = new Database();
        $GameRepository = GameRepository::getInstance($database);
        $suppression = $GameRepository->deleteThisCategorie($id_categorie_game);
        if($suppression) {
            $_SESSION['succes'] = "Catégorie éffacée avec succès de la liste.";
            $this->render("adminCategorieJeuListe", ['succes' => $_SESSION['succes']]);
            return;
        }
        else {
            $_SESSION['erreur'] = "Une erreur est survenue lors de la suppression.";
            $this->render("adminCategorieJeuListe", ['erreur' => $_SESSION['erreur']]);
            return;
        }
    }

    public function pageAdminTabou() {
        $this->render("adminTabouListe");
    }

    public function pageAjouterTabou(?int $id_tabou = 0) {
        if($id_tabou != 0) {
            $id_tabou = intval($id_tabou);
            $database = new Database();
            $TabouRepository = TabouRepository::getInstance($database);
            $tabou = $TabouRepository->getThisTabou($id_tabou);
            $tabou = $this->sanitize($tabou);
        }
        else {
            $tabou = NULL;
        }
        $this->render("adminTabou", ["tabou" => $tabou]);
    }

    public function ajouterTabou() {
        $data = $_POST;
        $data = $this->sanitize($data);

        foreach($data as $entree) {
            if(!isset($entree) || $entree == '') {
                $_SESSION['erreur'] = "Toutes les entrées pour cette censure sont importantes.";
                $this->render("adminTabou", ["erreur" => $_SESSION['erreur']]);
                return;
            }
        }
        $database = new Database();
        $TabouRepository = TabouRepository::getInstance($database);
        $tabou = new Tabou($data);

        $creer = $TabouRepository->addTabou($tabou->getStrMot());
        if($creer) {
            $_SESSION['succes'] = "Tabou créer avec succès!";
            $this->render("adminTabouListe", ["succes" => $_SESSION['succes']]);
            return;
        }
        else {
            $_SESSION["erreur"] = "Echec de l'enregistrment.";
            $this->render("adminTabou", ["erruer" => $_SESSION["erreur"]]);
            return;
        }
    }

    public function updateThisTabou() {
        $data = $_POST;
        $data = $this->sanitize($data);

        foreach($data as $entree) {
            if(!isset($entree) || $entree == '') {
                $_SESSION['erreur'] = "Toutes les entrées pour cette censure sont importantes.";
                $this->render("adminTabou", ["erreur" => $_SESSION['erreur']]);
                return;
            }
        }
        $database = new Database();
        $TabouRepository = TabouRepository::getInstance($database);
        $tabou = new Tabou($data);
        
        $maj = $TabouRepository->updateTabou($tabou);
        if($maj) {
            $_SESSION['succes'] = "Censure mise à jour avec succès.";
        } 
        else {
            $_SESSION['erreur'] = "Erreur lors de la mise à jour de la censure.";
        }
        $this->render("adminTabouListe");
    }

    public function deleteThisTabou(int $id_tabou) {
        $id_tabou = intval($id_tabou);
        $database = new Database();
        $TabouRepository = TabouRepository::getInstance($database);

        $suppression = $TabouRepository->deleteThisTabou($id_tabou);
        if($suppression) {
            $_SESSION['succes'] = "Censure éffacée avec succès de la liste.";
            $this->render("adminTabouListe", ['succes' => $_SESSION['succes']]);
            return;
        }
        else {
            $_SESSION['erreur'] = "Une erreur est survenue lors de la suppression.";
            $this->render("adminTabouListe", ['erreur' => $_SESSION['erreur']]);
            return;
        }
    }

    public function pageAdminCategorieArticle() {
        $this->render("adminCategorieArticleListe");
    }

    public function pageAjouterCategorieArticle(?int $id_categorie_article = 0) {
        if($id_categorie_article != 0) {
            $id_categorie_article = intval($id_categorie_article);
            $database = new Database();
            $ArticleRepository = ArticleRepository::getInstance($database);
            $categorie = $ArticleRepository->getThisCategorie($id_categorie_article);
            $categorie = $this->sanitize($categorie);
        }
        else {
            $categorie = NULL;
        }
        $this->render("adminCategorieArticle", ["categorie" => $categorie]);
    }

    public function ajouterCategorieArticle() {
        $data = $_POST;
        $data = $this->sanitize($data);

        foreach($data as $entree) {
            if(!isset($entree) || $entree == '') {
                $_SESSION['erreur'] = "Toutes les entrées pour cette catégorie sont importantes.";
                $this->render("adminCategorieArticle", ["erreur" => $_SESSION['erreur']]);
                return;
            }
        }
        $database = new Database();
        $ArticleRepository = ArticleRepository::getInstance($database);
        $categorie = new CategorieArticle($data);

        $creer = $ArticleRepository->createCategorie($categorie);
        if($creer) {
            $_SESSION['succes'] = "Catégorie créer avec succès!";
            $this->render("adminCategorieArticleListe", ["succes" => $_SESSION['succes']]);
            return;
        }
        else {
            $_SESSION["erreur"] = "Echec de l'enregistrment.";
            $this->render("adminCategorieArticle", ["erruer" => $_SESSION["erreur"]]);
            return;
        }
    }

    public function updateThisCategorieArticle() {
        $data = $_POST;
        $data = $this->sanitize($data);

        foreach($data as $entree) {
            if(!isset($entree) || $entree == '') {
                $_SESSION['erreur'] = "Toutes les entrées pour cette catégorie sont importantes.";
                $this->render("adminCategorieArticle", ["erreur" => $_SESSION['erreur']]);
                return;
            }
        }
        $database = new Database();
        $ArticleRepository = ArticleRepository::getInstance($database);
        $categorie = new CategorieArticle($data);

        $maj = $ArticleRepository->updateCategorieArticle($categorie);
        if($maj) {
            $_SESSION['succes'] = "Catégorie mise à jour avec succès.";
        } 
        else {
            $_SESSION['erreur'] = "Erreur lors de la mise à jour de la catégorie.";
        }
        $this->render("adminCategorieArticleListe");
    }

    public function deleteThisCategorieArticle(int $id_categorie_article) {
        $id_categorie_article = intval($id_categorie_article);
        $database = new Database();
        $ArticleRepository = ArticleRepository::getInstance($database);
        $suppression = $ArticleRepository->deleteThisCategorie($id_categorie_article);
        if($suppression) {
            $_SESSION['succes'] = "Catégorie éffacée avec succès de la liste.";
            $this->render("adminCategorieArticleListe", ['succes' => $_SESSION['succes']]);
            return;
        }
        else {
            $_SESSION['erreur'] = "Une erreur est survenue lors de la suppression.";
            $this->render("adminCategorieArticleListe", ['erreur' => $_SESSION['erreur']]);
            return;
        }
    }


}