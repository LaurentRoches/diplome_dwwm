<?php

namespace src\Repositories;

use PDO;
use PDOException;
use src\Models\Database;
use src\Models\Tabou;

class TabouRepository {

    private $DB;

    private function __construct() {
        $database = new Database();
        $this->DB = $database->getDB();
        require_once __DIR__.'/../../config.php';
    }

    public static function getInstance(Database $db): self {
        return new self($db);
    }

    public function getAllTabou():array {
        try {
            $sql = "SELECT * FROM tabou;";
            $statement = $this->DB->prepare($sql);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function addTabou(string $str_mot):bool {
        try {
            $sql = "INSERT INTO tabou (str_mot) VALUES (:str_mot);";
            $statement = $this->DB->prepare($sql);
            $retour = $statement->execute([
                ':str_mot' => $str_mot
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

    public function getThisTabou(int $id_tabou):array | bool {
        try {
            $sql = "SELECT * 
                    FROM tabou 
                    WHERE id_tabou = :id_tabou
                    LIMIT 1;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ":id_tabou" => $id_tabou
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

    public function updateTabou(Tabou $tabou):bool | array {
        try {
            $sql = "UPDATE tabou SET str_mot = :str_mot WHERE id_tabou = :id_tabou;";
            $statement = $this->DB->prepare($sql);
            $retour = $statement->execute([
                ":str_mot" => $tabou->getStrMot(),
                ":id_tabou" => $tabou->getIdTabou()
            ]);
            if($retour) {
                return $this->getThisTabou($tabou->getIdTabou());
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function deleteThisTabou(int $id_tabou):bool {
        try {
            $sql = "DELETE FROM tabou WHERE id_tabou = :id_tabou;";
            $statement = $this->DB->prepare($sql);
            $retour = $statement->execute([":id_tabou" => $id_tabou]);
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