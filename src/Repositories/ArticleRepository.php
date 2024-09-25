<?php

namespace src\Repositories;

use PDO;
use PDOException;
use src\Models\Article;
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

    public function createArticle (Article $article):bool {
        try {
            $sql = "INSERT INTO article (str_titre, id_user, str_resume, str_chemin_img_1, str_titre_section_1, txt_section_1, str_chemin_img_2, str_titre_section_2, txt_section_2) 
                    VALUES (:str_titre, :id_user, :str_resume, :str_chemin_img_1, :str_titre_section_1, :txt_section_1, :str_chemin_img_2, :str_titre_section_2, :txt_section_2);";
            $statement = $this->DB->prepare($sql);
            $retour = $statement->execute([
                ":str_titre"            => $article->getStrTitre(),
                ":id_user"              => $article->getIdUser(),
                ":str_resume"           => $article->getStrResume(),
                ":str_chemin_1"         => $article->getStrCheminImg1(),
                ":str_titre_section_1"  => $article->getStrTitreSection1(),
                ":txt_section_1"        => $article->getTxtSection1(),
                ":str_chemin_2"         => $article->getStrCheminImg2(),
                ":str_titre_section_2"  => $article->getStrTitreSection2(),
                ":txt_section_2"        => $article->getTxtSection2()
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

    public function updateArticle (Article $article):bool | array {
        try {
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
            if($retour) {
                return $this->getThisArticle($article->getIdArticle());
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $error) {
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

    public function getAllArticles (): array {
        try {
            $sql = "SELECT article.*, user.str_pseudo 
                    FROM article
                    LEFT JOIN user ON user.id_user = article.id_user
                    ORDER BY COALESCE(article.dtm_maj, article.dtm_creation) DESC;";
            $statement = $this->DB->prepare($sql);
            $statement->execute();
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
}