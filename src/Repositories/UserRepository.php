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

    public static function getInstance(Database $db): self {
        return new self($db);
    }

    /**
     * Créer un utilisateur
     *
     * @param   User  $user  les données sous forme de l'objet User
     *
     * @return  User         Retourne vrai si l'enregistrement s'est bien apssé
     */
    public function createUser(User $user): bool {
        try {
            $sql = "INSERT INTO user (str_email, str_nom, str_prenom, dtm_naissance, str_pseudo) 
                    VALUES (:str_email, :str_nom, :str_prenom, :dtm_naissance, :str_pseudo)";
            $statement = $this->DB->prepare($sql);
             $retour = $statement->execute([
                ":str_email"     => $user->getStrEmail(),
                ":str_nom"       => $user->getStrNom(),
                ":str_prenom"    => $user->getStrPrenom(),
                ":dtm_naissance" => $user->getDtmNaissance(),
                ":str_pseudo"    => $user->getStrPseudo()
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

    /**
     * Récupère tout les utilisateur, trier par note descendante
     *
     * @return  array   Un tableau listant tout les utilisateur
     */
    public function getAllUser () :array {
        try {
            $sql = "SELECT user.*, AVG(avis_user.int_note) AS avg_score
                    FROM user
                    LEFT JOIN avis_user ON user.id_user = avis_user.id_evalue
                    GROUP BY user.id_user
                    ORDER BY avg_score DESC;";
            $statement = $this->DB->prepare($sql);
            $statement->execute();
            $retour = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $retour;
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    /**
     * Récupérer un utilisateur spécifique
     *
     * @param   int   $id_user  identifiant unique de l'utilisateur
     *
     * @return  User            Retourne l'utilisateur trouver
     */
    public function getThisUserById(int $id_user): ?User {
        try {
            $sql = "SELECT * FROM user WHERE user.id_user = :id_user LIMIT 1;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ":id_user" => $id_user
            ]);
            $user = $statement->fetch(PDO::FETCH_CLASS, User::class);
            return $user;
        } 
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    /**
     * Récupérer un utilisateur spécifique
     *
     * @param   string  $str_email  Email de l'utilisateur
     *
     * @return  User                Retourne l'utilisateur trouver
     */
    public function getThisUserByEmail(string $str_email): ?User {
        try {
            $sql = "SELECT * FROM user WHERE str_email = :str_email LIMIT 1;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ":str_email" => $str_email
            ]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            if($user) {
                return new User($user);
            }
            return null;
        } catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    /**
     * Récupérer un utilisateur spécifique
     *
     * @param   string  $str_pseudo  Pseudo unique de l'utilisateur
     *
     * @return  User                 Retourne l'utilisateur trouver
     */
    public function getThisUserByPseudo (string $str_pseudo): ?User {
        try {
            $sql = "SELECT * FROM user WHERE str_pseudo = :str_pseudo LIMIT 1;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ":str_pseudo" => $str_pseudo
            ]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            if($user) {
                return new User($user);
            }
            return null;
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    /**
     * Permet le trie des utilisateurs ayant déjà joué à ce jeu, trier par note descendante
     *
     * @param   int    $id_game  Identifiant unique du jeu sélectionné
     *
     * @return  array            Un tableau listant tout les utilisateurs trouver
     */
    public function trierByGameConnu (int $id_game) :array {
        try {
            $sql = "SELECT user.*, game_connu.id_game, AVG(avis_user.int_note) AS avg_score
                    FROM user
                    INNER JOIN game_connu ON user.id_user = game_connu.id_user
                    LEFT JOIN avis_user ON user.id_user = avis_user.id_evalue
                    WHERE game_connu.id_game = :id_game
                    GROUP BY user.id_user
                    ORDER BY avg_score DESC;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ":id_game" => $id_game
            ]);
            $retour = $statement->fetchAll(PDO::FETCH_CLASS, User::class);
            return $retour;
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    /**
     * Permet le trie des utilisateurs voulant joué à ce jeu, trier par note descendante
     *
     * @param   int    $id_game  Identifiant unique du jeu selectionné
     *
     * @return  array            Un tableau listant tous les utilisateurs trouver
     */
    public function trierByGameVoulu (int $id_game) :array {
        try {
            $sql = "SELECT user.*, game_voulu.id_game, AVG(avis_user.int_note) AS avg_score
                    FROM user
                    INNER JOIN game_voulu ON user.id_user = game_voulu.id_user
                    LEFT JOIN avis_user ON user.id_user = avis_user.id_evalue
                    WHERE game_voulu.id_game = :id_game
                    GROUP BY user.id_user
                    ORDER BY avg_score DESC;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ":id_game" => $id_game
            ]);
            $retour = $statement->fetchAll(PDO::FETCH_CLASS, User::class);
            return $retour;
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    /**
     * Mettre à jour un utilisateur
     *
     * @param   User  $user  Objet user avec toutes les données nécessaire
     *
     * @return  User         Retourne l'utilisateur actualisé
     */
    public function updateThisUser(User $user): User {
        try {
            $sql = "UPDATE user SET 
                      str_email = :str_email, 
                      str_nom = :str_nom, 
                      str_prenom = :str_prenom, 
                      dtm_naissance = :dtm_naissance, 
                      str_mdp = :str_mdp, 
                      str_mdp = :str_mdp, 
                      bln_notif = :bln_notif, 
                      str_pseudo = :str_pseudo, 
                      str_description = :str_description, 
                      id_experience = :id_experience, 
                      id_role = :id_role, 
                      id_profil_image = :id_profil_image, 
                      dtm_maj = :dtm_maj
                      WHERE id_user = :id_user;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ":str_email" => $user->getStrEmail(),
                ":str_nom" => $user->getStrNom(),
                ":str_prenom" => $user->getStrPrenom(),
                ":dtm_naissance" => $user->getDtmNaissance(),
                ":str_mdp" => $user->getStrMdp(),
                ":str_mdp" => $user->getStrMdp(),
                ":bln_notif" => $user->isBlnNotif(),
                ":str_pseudo" => $user->getStrPseudo(),
                ":str_description" => $user->getStrDescription(),
                ":id_experience" => $user->getIdExperience(),
                ":id_role" => $user->getIdRole(),
                ":id_profil_image" => $user->getIdProfilImage(),
                ":dtm_maj" => $user->getDtmMaj(),
                ":id_user" => $user->getIdUser(),
            ]);
            return $this->getThisUserById($user->getIdUser());
        } 
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }
    /**
     * Supprime un utilisateur selectionné
     *
     * @param   int   $id_user  Identifiant unique de l'utilisateur
     *
     * @return  bool            True si la suppression est réussite
     */
    public function deleteThisUser(int $id_user): bool {
        try {
            $sql = "DELETE FROM user WHERE id_user = :id_user;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ":id_user" => $id_user
            ]);
            return true;
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    /**
     * Permet de trouver un utilisateur depuis son email et de vérifier son mdp
     *
     * @param   string  $str_email  Email donné par l'utilisateur
     * @param   string  $mdp   Mdp donné par l'utilisateur
     *
     * @return  User                Retourne l'utilisateur si les données sont correctes
     */
    public function login(string $str_email, string $mdp): ?User {
        try {
            $sql = "SELECT * FROM user WHERE str_email = :str_email LIMIT 1;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ":str_email" => $str_email,
            ]);

            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $user = new User();
                $user->setStrEmail($result['str_email']);
                $user->setStrNom($result['str_nom']);
                $user->setStrPrenom($result['str_prenom']);
                $user->setDtmNaissance($result['dtm_naissance']);
                $user->setIdUser($result['id_user']);
                $user->isBlnActive($result['bln_active']);
                $user->setStrMdp($result['str_mdp']);
                $user->isBlnNotif($result['bln_notif']);
                $user->setStrPseudo($result['str_pseudo']);
                $user->setStrDescription($result['str_description'] ?? '');
                $user->setIdExperience($result['id_experience']);
                $user->setIdRole($result['id_role']);
                $user->setIdProfilImage($result['id_profil_image']);
                $user->setDtmCreation($result['dtm_creation']);
                $user->setDtmMaj($result['dtm_maj'] ?? '');

                if (password_verify($mdp, $result['str_mdp'])) {
                    return $user;
                } else {
                    return null;
                }
            } else {
                return null;
            }
        } catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    /**
     * Fonction pour l'activation d'un compte
     *
     * @param   int     $id_user  identifiant unique de l'utilisateru
     * @param   string  $str_mdp  Nouveau mot de passe donné par l'utilisateur
     *
     * @return  bool              Retourne vrai si tout s'est bien passé
     */
    public function activateThisUser(int $id_user, string $str_mdp):bool {
        try {
            $sql = "UPDATE user SET
                    str_mdp = :str_mdp,
                    bln_active = :bln_active
                    WHERE id_user = :id_user;";
            $statement = $this->DB->prepare($sql);
            $retour = $statement->execute([
                ":str_mdp" => $str_mdp,
                ":bln_active" => 1,
                ":id_user" => $id_user
            ]);
            if($retour){
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