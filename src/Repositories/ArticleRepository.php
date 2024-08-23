<?php

namespace src\Repositories;

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

    public function createArticle (Article $article):void {
        try {
            $sql = "INSERT INTO article (str_titre, id_user, str_resume, txt_contenu) VALUES (:str_titre, :id_user, :str_resume, :txt_contenu);";
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }
}