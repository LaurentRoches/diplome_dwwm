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
     * Récupère tous les utilisateur en fonction du trie, paginer et classer selon leur ratio de like
     *
     * @param   int     $id_game     identifiant du jeu souhaité
     * @param   string  $str_pseudo  pseudonyme du joueur rechecher
     * @param   int     $bln_mj      booléen de Maître du Jeu
     * @param   string  $str_jour    jour disponible
     * @param   string  $time_debut  heure de debut
     * @param   string  $time_fin    heure de fin
     * @param   int     $page        numéro de la page souhaité
     * @param   int     $perPage     nombre de résultat par page
     *
     * @return  array                Un tableau contenant la liste des utilisateurs trouvés
     */
    public function getAllUser(int $id_game = null, string $str_pseudo = '', int $bln_mj = null, string $str_jour = '', string $time_debut = '', string $time_fin = '', int $page = 1, int $perPage = 10): array {
        try {
            $offset = ($page - 1) * $perPage;
            $sql = "SELECT 
                        user.*, profil_image.str_chemin,
                        COALESCE(SUM(CASE WHEN avis_user.bln_aime = 1 THEN 1 ELSE 0 END),0) AS aime,
                        COUNT(avis_user.id_avis_user) AS total_avis,
                        COALESCE(SUM(CASE WHEN avis_user.bln_aime = 1 THEN 1 ELSE 0 END) / NULLIF(COUNT(avis_user.id_avis_user), 0), 0) AS ratio
                    FROM user
                    LEFT JOIN avis_user ON user.id_user = avis_user.id_evalue
                    LEFT JOIN profil_image ON user.id_profil_image = profil_image.id_profil_image
                    LEFT JOIN game_voulu ON game_voulu.id_user = user.id_user
                    LEFT JOIN disponibilite ON user.id_user = disponibilite.id_user
                    WHERE 1=1";
    
            $params = [];
    
            if($id_game !== null) {
                $sql .= " AND user.id_user IN (SELECT id_user FROM game_connu WHERE id_game = :id_game)";
                $params[':id_game'] = $id_game;
            }
    
            if(!empty($str_pseudo)) {
                $sql .= " AND str_pseudo LIKE :str_pseudo";
                $params[':str_pseudo'] = '%' . $str_pseudo . '%';
            }
    
            if($bln_mj !== null) {
                $sql .= " AND bln_mj = :bln_mj";
                $params[':bln_mj'] = $bln_mj;
            }

            if(!empty($str_jour)) {
                $sql .= " AND disponibilite.str_jour LIKE :str_jour";
                $params[':str_jour'] = '%' . $str_jour . '%';
            }

            if(!empty($time_debut)) {
                $sql .= " AND time_fin > :time_debut";
                $params[':time_debut'] = $time_debut;
            }

            if(!empty($time_fin)) {
                $sql .= " AND time_debut < :time_fin";
                $params[':time_fin'] = $time_fin;
            }

            $sql .= " GROUP BY user.id_user ORDER BY ratio DESC LIMIT $perPage OFFSET $offset";
    
            $statement = $this->DB->prepare($sql);
            $statement->execute($params);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }
    


    /**
     * Décompte de tous les utilisateurs trouvé selon les critères de recherche
     *
     * @param   int     $id_game     identifiant de jeu souhaité
     * @param   string  $str_pseudo  pseudonyme du joueur rechercher
     * @param   int     $bln_mj      booléen de Maître du Jeu
     * @param   string  $str_jour    jour disponible
     * @param   string  $time_debut  heure de debut
     * @param   string  $time_fin    heure de fin
     *
     * @return  int                  La valeur numérique récupérer
     */
    public function countAllUser(int $id_game = null, string $str_pseudo = '', int $bln_mj = null, string $str_jour = '', string $time_debut = '', string $time_fin = ''): int {
        try {
            $sql = "SELECT COUNT(*) 
                    FROM user 
                    LEFT JOIN game_voulu ON game_voulu.id_user = user.id_user
                    LEFT JOIN disponibilite ON user.id_user = disponibilite.id_user
                    WHERE 1=1";
            $params = [];
    
            if($id_game !== null) {
                $sql .= " AND user.id_user IN (SELECT id_user FROM game_connu WHERE id_game = :id_game)";
                $params[':id_game'] = $id_game;
            }
    
            if(!empty($str_pseudo)) {
                $sql .= " AND str_pseudo LIKE :str_pseudo";
                $params[':str_pseudo'] = '%' . $str_pseudo . '%';
            }
    
            if($bln_mj !== null) {
                $sql .= " AND bln_mj = :bln_mj";
                $params[':bln_mj'] = $bln_mj;
            }

            if(!empty($str_jour)) {
                $sql .= " AND disponibilite.str_jour LIKE :str_jour";
                $params[':str_jour'] = '%' . $str_jour . '%';
            }

            if(!empty($time_debut)) {
                $sql .= " AND time_debut <= :time_debut AND time_fin > :time_debut";
                $params[':time_debut'] = $time_debut;
            }

            if(!empty($time_fin)) {
                $sql .= " AND time_debut < :time_fin AND time_fin >= :time_fin";
                $params[':time_fin'] = $time_fin;
            }

            $statement = $this->DB->prepare($sql);
            $statement->execute($params);
            return $statement->fetchColumn();
        } catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }


    /**
     * Récupère trois utilisateurs, trier par note descendante
     *
     * @return  array   Un tableau listant tout les utilisateur
     */
    public function getAllUserLimit3 (): array {
        try {
            $sql = "SELECT 
                        user.*, profil_image.str_chemin,
                        COALESCE(SUM(CASE WHEN avis_user.bln_aime = 1 THEN 1 ELSE 0 END),0) AS aime,
                        COUNT(avis_user.id_avis_user) AS total_avis,
                        COALESCE(SUM(CASE WHEN avis_user.bln_aime = 1 THEN 1 ELSE 0 END) / NULLIF(COUNT(avis_user.id_avis_user), 0), 0) AS ratio
                    FROM user
                    LEFT JOIN avis_user ON user.id_user = avis_user.id_evalue
                    LEFT JOIN profil_image ON user.id_profil_image = profil_image.id_profil_image
                    GROUP BY user.id_user
                    ORDER BY ratio DESC
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