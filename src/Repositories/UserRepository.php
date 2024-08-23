<?php

namespace src\Repositories;

use PDO;
use PDOException;
use src\Models\Database;
use src\Models\User;

class UserRepository {

    private $DB;

    private function __construct() {
        $database = new Database();
        $this->DB = $database->getDB();
        require_once __DIR__.'/../../config.php';
    }

    public function createUser(User $user): User {
        try {
            $sql = "INSERT INTO user (str_email, str_nom, str_prenom, dtm_naissance, str_pseudo) 
                    VALUES (:str_email, :str_nom, :str_prenom, :dtm_naissance, :str_pseudo)";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ":str_email"     => $user->getStrEmail(),
                ":str_nom"       => $user->getStrNom(),
                ":str_prenom"    => $user->getStrPrenom(),
                ":dtm_naissance" => $user->getDtmNaissance(),
                ":str_pseudo"    => $user->getStrPseudo()
            ]);

            $lastInsertId = $this->DB->lastInsertId();
            $user->setIdUser((int)$lastInsertId);

            $sql = "SELECT * FROM user WHERE id_user = :id";
            $statement = $this->DB->prepare($sql);
            $statement->execute([":id" => $lastInsertId]);
            $userData = $statement->fetch(PDO::FETCH_ASSOC);

            if ($userData) {
                $user->actualise($userData);
            }
            return $user;
        } 
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function getAllUser () :array {
        try {
            $sql = "SELECT user.*, AVG(avis_user.int_note) AS avg_score
                    FROM user
                    LEFT JOIN avis_user ON user.id_user = avis_user.id_evalue
                    GROUP BY user.id_user
                    ORDER BY avg_score DESC;";
            $statement = $this->DB->prepare($sql);
            $statement->execute();
            $retour = $statement->fetchAll(PDO::FETCH_CLASS, User::class);
            return $retour;
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function getThisUserById (int $id_user): User {
        try {
            $sql = "SELECT * FROM user WHERE user.id_user = :id_user;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ":id_user" => $id_user
            ]);
            $retour = $statement->fetchAll(PDO::FETCH_CLASS, User::class);
            return $retour;
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function getThisUserByEmail (string $str_email): User {
        try {
            $sql = "SELECT * FROM user WHERE user.str_email = :str_email;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ":str_email" => $str_email
            ]);
            $retour = $statement->fetchAll(PDO::FETCH_CLASS, User::class);
            return $retour;
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function getThisUserByPseudo (int $str_pseudo): User {
        try {
            $sql = "SELECT * FROM user WHERE user.str_pseudo = :str_pseudo;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ":str_pseudo" => $str_pseudo
            ]);
            $retour = $statement->fetchAll(PDO::FETCH_CLASS, User::class);
            return $retour;
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }



    public function login(string $str_email, string $password): ?User {
        try {
            $sql = "SELECT * FROM ".PREFIXE."user WHERE user.str_email = :str_email;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ":str_email" => $str_email,
            ]);

            $statement->setFetchMode(PDO::FETCH_CLASS, User::class);
            $user = $statement->fetch();

            if ($user && password_verify($password, $user->getStrMdp())) {
                return $user;
            } else {
                return null;
            }
        } catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

}