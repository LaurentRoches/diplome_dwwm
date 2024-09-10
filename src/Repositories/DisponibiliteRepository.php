<?php

namespace src\Repositories;

use PDO;
use PDOException;
use src\Models\Database;

class DisponibiliteRepository {

    private $DB;

    private function __construct() {
        $database = new Database();
        $this->DB = $database->getDB();
        require_once __DIR__.'/../../config.php';
    }

    public static function getInstance(Database $db): self {
        return new self($db);
    }

    public function getAllDisponibiliteById(int $id_user): array {
        try {
            $sql = "SELECT * FROM disponibilite WHERE id_user = :id_user;";
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

    public function createDisponibilite(array $tab_disponibilite):bool {
        try {
            $sql = "INSERT INTO disponibilite (id_user, str_jour, time_debut, time_fin) 
                    VALUES (:id_user, :str_jour, :time_debut, :time_fin)";
            $statement = $this->DB->prepare($sql);
            foreach($tab_disponibilite as $disponibilite) {
                $statement->execute([
                    ':id_user' => $disponibilite['id_user'],
                    ':str_jour' => $disponibilite['str_jour'],
                    ':time_debut' => $disponibilite['time_debut'],
                    ':time_fin' => $disponibilite['time_fin']
                ]);
            }
            return true;
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }
}