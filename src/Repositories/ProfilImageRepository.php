<?php

namespace src\Repositories;

use PDO;
use PDOException;
use src\Models\Database;
use src\Models\ProfilImage;

class ProfilImageRepository { 

    private $DB;

    private function __construct() {
        $database = new Database();
        $this->DB = $database->getDB();
        require_once __DIR__.'/../../config.php';
    }

    public static function getInstance(Database $db): self {
        return new self($db);
    }

    public function getThisImage(int $id_profil_image):?ProfilImage {
        try {
            $sql = "SELECT * FROM profil_image WHERE id_profil_image = :id_profil_image LIMIT 1;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ":id_profil_image" => $id_profil_image
            ]);
            $image = $statement->fetchObject(ProfilImage::class);
            return $image ?: null;
        } 
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function getAllImage():array {
        try {
            $sql = "SELECT * FROM profil_image;";
            $statement = $this->DB->prepare($sql);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }
}
