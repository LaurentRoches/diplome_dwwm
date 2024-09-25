<?php

namespace src\Repositories;

use PDO;
use PDOException;
use src\Models\Database;
use src\Models\Game;

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

    public function createGame(Game $game):bool {
        try {
            $sql = "INSERT INTO game (str_nom, str_resume, txt_description, id_categorie_game)
                    VALUES (:str_nom, :str_resume, :txt_description, :id_categorie_game);";
            $statement = $this->DB->prepare($sql);
            $retour = $statement->execute([
                ":str_nom"          => $game->getStrNom(),
                ":str_resume"       => $game->getStrResume(),
                "txt_description"   => $game->getTxtDescription(),
                ":id_categorie_game"=> $game->getIdCategorieGame()
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

    public function getThisGame(int $id_game):array | bool {
        try {
            $sql = "SELECT game.str_nom, game.str_resume, game.txt_description, game.id_game, categorie_game.str_nom AS categorie
                    FROM game
                    LEFT JOIN categorie_game ON game.id_categorie_game = categorie_game.id_categorie_game
                    WHERE id_game = :id_game
                    LIMIT 1;";
            $statement = $this->DB->prepare($sql);
            $statement->execute(["id_game" => $id_game]);
            $retour = $statement->fetch(PDO::FETCH_ASSOC);
            if($retour) {
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

    public function updateGame(Game $game):bool | array {
        try {
            $sql = "UPDATE game SET
                    str_nom = :str_nom,
                    str_resume = :str_resume,
                    txt_description = :txt_description,
                    id_categorie_game = :id_categorie_game,
                    dtm_maj = :dtm_maj
                    WHERE id_game = :id_game;";
            $statement = $this->DB->prepare($sql);
            $retour = $statement->execute([
                ":str_nom"          => $game->getStrNom(),
                ":str_resume"       => $game->getStrResume(),
                "txt_description"   => $game->getTxtDescription(),
                ":id_categorie_game"=> $game->getIdCategorieGame(),
                ":dtm_maj"          => $game->getDtmMaj(),
                ":id_game"          => $game->getIdGame()
            ]);
            if($retour) {
                return $this->getThisGame($game->getIdGame());
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function deleteThisGame(int $id_game):bool {
        try {
            $sql = "DELETE FROM game WHERE id_game = :id_game;";
            $statement = $this->DB->prepare($sql);
            $retour = $statement->execute([":id_game" => $id_game]);
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

    public function getAllGame():array {
        try {
            $sql = "SELECT game.str_nom, game.str_resume, game.txt_description, game.id_game, categorie_game.str_nom AS categorie
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
            $sql = "SELECT game.str_nom, game.str_resume, game.txt_description, game.id_game, categorie_game.str_nom AS categorie
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
            $sql = "SELECT game.str_nom, game.str_resume, game.txt_description, game.id_game, categorie_game.str_nom AS categorie
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
            $statement = $this->DB->prepare($sql);
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
            $statement = $this->DB->prepare($sql);
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

    public function getAllCategorie():array {
        try {
            $sql = "SELECT *
                    FROM categorie_game";
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