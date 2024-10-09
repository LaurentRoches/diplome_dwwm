<?php

namespace src\Repositories;

use PDO;
use PDOException;
use src\Models\Article;
use src\Models\CategorieArticle;
use src\Models\Database;

class ArticleRepository {

    private $DB;

    private function __construct() {
        $database = new Database();
        $this->DB = $database->getDB();
        require_once __DIR__.'/../../config.php';
    }

    public static function getInstance(Database $db): self {
        return new self($db);
    }

    public function createArticle (Article $article, array $tab_categorie_article):bool {
        try {
            $this->DB->beginTransaction();
            $sql = "INSERT INTO article (str_titre, id_user, str_resume, str_chemin_img_1, str_titre_section_1, txt_section_1, str_chemin_img_2, str_titre_section_2, txt_section_2) 
                    VALUES (:str_titre, :id_user, :str_resume, :str_chemin_img_1, :str_titre_section_1, :txt_section_1, :str_chemin_img_2, :str_titre_section_2, :txt_section_2);";
            $statement = $this->DB->prepare($sql);
            $retour = $statement->execute([
                ":str_titre"            => $article->getStrTitre(),
                ":id_user"              => $article->getIdUser(),
                ":str_resume"           => $article->getStrResume(),
                ":str_chemin_img_1"     => $article->getStrCheminImg1(),
                ":str_titre_section_1"  => $article->getStrTitreSection1(),
                ":txt_section_1"        => $article->getTxtSection1(),
                ":str_chemin_img_2"     => $article->getStrCheminImg2(),
                ":str_titre_section_2"  => $article->getStrTitreSection2(),
                ":txt_section_2"        => $article->getTxtSection2()
            ]);
            if (!$retour) {
                $this->DB->rollBack();
                return FALSE;
            }
            $id_article = $this->DB->lastInsertId();
            foreach($tab_categorie_article as $id_categorie_article) {
                $sql2 = "INSERT INTO liste_categorie_article (id_categorie_article, id_article)
                         VALUES (:id_categorie_article, :id_article);";
                $statement2 = $this->DB->prepare($sql2);
                $retour2 = $statement2->execute([
                    ":id_categorie_article" => $id_categorie_article,
                    ":id_article" => $id_article
                ]);
                if (!$retour2) {
                    $this->DB->rollBack();
                    return FALSE;
                }
            }
            $this->DB->commit();
            return TRUE;
        }
        catch (PDOException $error) {
            $this->DB->rollBack();
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function updateArticle (Article $article, array $tab_categorie_article):bool | array {
        try {
            $this->DB->beginTransaction();
            $sql = "UPDATE article SET
                    str_titre = :str_titre,
                    id_user = :id_user,
                    str_resume = :str_resume,
                    str_chemin_img_1 = :str_chemin_img_1,
                    str_titre_section_1 = :str_titre_section_1,
                    txt_section_1 = :txt_section_1,
                    str_chemin_img_2 = :str_chemin_img_2,
                    str_titre_section_2 = :str_titre_section_2,
                    txt_section_2 = :txt_section_2,
                    dtm_maj = :dtm_maj
                    WHERE id_article = :id_article;";
            $statement = $this->DB->prepare($sql);
            $retour = $statement->execute([
                ":str_titre"            => $article->getStrTitre(),
                ":id_user"              => $article->getIdUser(),
                ":str_resume"           => $article->getStrResume(),
                ":str_chemin_img_1"     => $article->getStrCheminImg1(),
                ":str_titre_section_1"  => $article->getStrTitreSection1(),
                ":txt_section_1"        => $article->getTxtSection1(),
                ":str_chemin_img_2"     => $article->getStrCheminImg2(),
                ":str_titre_section_2"  => $article->getStrTitreSection2(),
                ":txt_section_2"        => $article->getTxtSection2(),
                ":dtm_maj"              => $article->getDtmMaj(),
                ":id_article"           => $article->getIdArticle()
            ]);
            if(!$retour) {
                $this->DB->rollBack();
                return FALSE;
            }
            $sql_clear = "DELETE FROM liste_categorie_article WHERE id_article = :id_article;";
            $statement_clear = $this->DB->prepare($sql_clear);
            $retour_clear = $statement_clear->execute([":id_article" => $article->getIdArticle()]);
            if(!$retour_clear) {
                $this->DB->rollBack();
                return FALSE;
            }
            foreach($tab_categorie_article as $id_categorie_article) {
                $sql2 = "INSERT INTO liste_categorie_article (id_categorie_article, id_article)
                         VALUES (:id_categorie_article, :id_article);";
                $statement2 = $this->DB->prepare($sql2);
                $retour2 = $statement2->execute([
                    ":id_categorie_article" => $id_categorie_article,
                    ":id_article" => $article->getIdArticle()
                ]);
                if (!$retour2) {
                    $this->DB->rollBack();
                    return FALSE;
                }
            }
            $this->DB->commit();
            return $this->getThisArticle($article->getIdArticle());
        }
        catch (PDOException $error) {
            $this->DB->rollBack();
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function deleteThisArticle(int $id_article):bool {
        try {
            $sql = "DELETE FROM article WHERE id_article = :id_article;";
            $statement = $this->DB->prepare($sql);
            $retour = $statement->execute([":id_article" => $id_article]);
            if($retour) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function getAllArticles(): array {
        try {
            $sqlRecent = "SELECT id_article 
                          FROM article 
                          ORDER BY COALESCE(dtm_maj, dtm_creation) DESC 
                          LIMIT 3";
    
            $statementRecent = $this->DB->prepare($sqlRecent);
            $statementRecent->execute();
            $recentArticles = $statementRecent->fetchAll(PDO::FETCH_COLUMN);

            $placeholders = implode(',', array_fill(0, count($recentArticles), '?'));

            $sql = "SELECT article.str_titre, article.id_article, article.str_chemin_img_1, user.str_pseudo 
                    FROM article
                    LEFT JOIN user ON user.id_user = article.id_user
                    WHERE article.id_article NOT IN ($placeholders)
                    ORDER BY RAND();";
    
            $statement = $this->DB->prepare($sql);
            $statement->execute($recentArticles);
            $retour = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $retour;
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }
    

    public function getAllArticlesLimit3 (): array {
        try {
            $sql = "SELECT article.*, user.str_pseudo 
                    FROM article
                    LEFT JOIN user ON user.id_user = article.id_user
                    ORDER BY COALESCE(article.dtm_maj, article.dtm_creation) DESC
                    LIMIT 3;";
            $statement = $this->DB->prepare($sql);
            $statement->execute();
            $retour = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $retour;
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function getThisArticle(int $id_article):array|bool {
        try {
            $sql = "SELECT article.*, user.str_pseudo
                    FROM article
                    LEFT JOIN user ON user.id_user = article.id_user
                    WHERE id_article = :id_article
                    LIMIT 1;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([":id_article" => $id_article]);
            $retour = $statement->fetch(PDO::FETCH_ASSOC);
            if($retour){
                return $retour;
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function getAllCategorieOfThisArticle(int $id_article):array | bool {
        try {
            $sql = "SELECT categorie_article.*
                    FROM liste_categorie_article
                    LEFT JOIN categorie_article ON categorie_article.id_categorie_article = liste_categorie_article.id_categorie_article
                    WHERE id_article = :id_article;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([":id_article" => $id_article]);
            $retour = $statement->fetchAll(PDO::FETCH_ASSOC);
            if($retour){
                return $retour;
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function getAllAvisOfThisArticle(int $id_article):array | bool {
        try {
            $sql = "SELECT avis_article.*, user.str_pseudo
                    FROM avis_article
                    LEFT JOIN user ON user.id_user = avis_article.id_user
                    WHERE id_article = :id_article;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([":id_article" => $id_article]);
            $retour = $statement->fetch(PDO::FETCH_ASSOC);
            if($retour){
                return $retour;
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function getThisCategorie(int $id_categorie_article):array | bool {
        try {
            $sql = "SELECT * FROM categorie_article WHERE id_categorie_article = :id_categorie_article LIMIT 1;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ":id_categorie_article" => $id_categorie_article
            ]);
            $retour = $statement->fetch(PDO::FETCH_ASSOC);
            if ($retour) {
                return $retour;
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function createCategorie(CategorieArticle $categorieArticle):bool {
        try {
            $sql = "INSERT INTO categorie_article (str_nom) VALUES (:str_nom);";
            $statement = $this->DB->prepare($sql);
            $retour = $statement->execute([":str_nom" => $categorieArticle->getStrNom()]);
            if ($retour) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function updateCategorieArticle(CategorieArticle $categorieArticle):bool {
        try {
            $sql = "UPDATE categorie_article SET str_nom = :str_nom WHERE id_categorie_article = :id_categorie_article;";
            $statement = $this->DB->prepare($sql);
            $retour = $statement->execute([
                ":str_nom" => $categorieArticle->getStrNom(),
                ":id_categorie_article" => $categorieArticle->getIdCategorieArticle()
            ]);
            if ($retour) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function deleteThisCategorie(int $id_categorie_article):bool {
        try {
            $sql = "DELETE FROM categorie_article WHERE id_categorie_article = :id_categorie_article;";
            $statement = $this->DB->prepare($sql);
            $retour = $statement->execute([":id_categorie_article" => $id_categorie_article]);
            if ($retour) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function getAllCategorie():array {
        try {
            $sql = "SELECT * FROM categorie_article;";
            $statement = $this->DB->prepare($sql);
            $statement->execute();
            $retour = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $retour;
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

}