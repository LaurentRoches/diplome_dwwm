<?php

namespace src\Repositories;

use PDO;
use PDOException;
use src\Models\Database;

class GameRepository {

    private $DB;

    private function __construct() {
        $database = new Database();
        $this->DB = $database->getDB();
        require_once __DIR__.'/../../config.php';
    }

    public static function getInstance(Database $db): self {
        return new self($db);
    }

    public function getAllGame():array {
        try {
            $sql = "SELECT game.*, categorie_game.str_nom 
                    FROM game
                    LEFT JOIN categorie_game USING (id_categorie_game);";
            $statement = $this->DB->prepare($sql);
            $statement->execute();
            $retour = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $retour;
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function getAllGameConnu(int $id_user):array {
        try {
            $sql = "SELECT game.*, categorie_game.str_nom
                    FROM game
                    LEFT JOIN categorie_game USING (id_categorie_game)
                    LEFT JOIN game_connu USING (id_game)
                    WHERE game_connu.id_user = :id_user;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ":id_user" => $id_user
            ]);
            $retour = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $retour;
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function getAllGameVoulu(int $id_user):array {
        try {
            $sql = "SELECT game.*, categorie_game.str_nom AS categorie
                    FROM game
                    LEFT JOIN categorie_game USING (id_categorie_game)
                    LEFT JOIN game_voulu USING (id_game)
                    WHERE game_voulu.id_user = :id_user;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ":id_user" => $id_user
            ]);
            $retour = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $retour;
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function createGameConnu(int $id_user, int $id_game):bool {
        try {
            $sql = "INSERT INTO game_connu (id_user, id_game)
                    VALUES (:id_user, :id_game);";
            $statement = $this->DB->preprare($sql);
            $statement->execute([
                ':id_user' => $id_user,
                ':id_game' => $id_game
            ]);
            return TRUE;
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function createGameVoulu(int $id_user, int $id_game):bool {
        try {
            $sql = "INSERT INTO game_voulu (id_user, id_game)
                    VALUES (:id_user, :id_game);";
            $statement = $this->DB->preprare($sql);
            $statement->execute([
                ':id_user' => $id_user,
                ':id_game' => $id_game
            ]);
            return TRUE;
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function deleteThisGameConnu(int $id_game, int $id_user):bool {
        try{
            $sql = "DELETE FROM game_connu WHERE id_game = :id_game AND id_user = :id_user;";
            $statement = $this->DB->prepare($sql);
            $retour = $statement->execute([
                ':id_game' => $id_game,
                ':id_user' => $id_user
            ]);
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

    public function deleteThisGameVoulu(int $id_game, int $id_user):bool {
        try{
            $sql = "DELETE FROM game_voulu WHERE id_game = :id_game AND id_user = :id_user;";
            $statement = $this->DB->prepare($sql);
            $retour = $statement->execute([
                ':id_game' => $id_game,
                ':id_user' => $id_user
            ]);
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
}