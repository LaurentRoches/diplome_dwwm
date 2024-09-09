<?php

namespace src\Repositories;

use PDOException;
use src\Models\Database;
use src\Models\Experience;

class ExperienceRepository {

    private $DB;

    private function __construct() {
        $database = new Database();
        $this->DB = $database->getDB();
        require_once __DIR__.'/../../config.php';
    }

    public static function getInstance(Database $db): self {
        return new self($db);
    }

    public function getThisExperience(int $id_experience):?Experience {
        try {
            $sql = "SELECT * FROM experience WHERE id_experience = :id_experience LIMIT 1;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ":id_experience" => $id_experience
            ]);
            $image = $statement->fetchObject(Experience::class);
            return $image ?: null;
        } 
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }
}