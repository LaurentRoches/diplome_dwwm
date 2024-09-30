<?php

namespace src\Repositories;

use DateTime;
use PDO;
use PDOException;
use src\Models\AvisUser;
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
            $sql = "INSERT INTO user (str_email, str_nom, str_prenom, dtm_naissance, str_pseudo, str_token) 
                    VALUES (:str_email, :str_nom, :str_prenom, :dtm_naissance, :str_pseudo, :str_token)";
            $statement = $this->DB->prepare($sql);
             $retour = $statement->execute([
                ":str_email"     => $user->getStrEmail(),
                ":str_nom"       => $user->getStrNom(),
                ":str_prenom"    => $user->getStrPrenom(),
                ":dtm_naissance" => $user->getDtmNaissance(),
                ":str_pseudo"    => $user->getStrPseudo(),
                ":str_token"     => $user->getStrToken()
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
                    WHERE user.id_user <> 2 AND user.bln_active = 1";
            $params = [];
            if($id_game !== null) {
                $sql .= " AND id_game = :id_game";
                $params[':id_game'] = $id_game;
            }
            if(!empty($str_pseudo)) {
                $sql .= " AND str_pseudo LIKE :str_pseudo";
                $params[':str_pseudo'] = "%" . $str_pseudo . "%";
            }
            if($bln_mj !== null) {
                $sql .= " AND bln_mj = :bln_mj";
                $params[':bln_mj'] = $bln_mj;
            }
            if(!empty($str_jour)) {
                $sql .= " AND disponibilite.str_jour LIKE :str_jour";
                $params[':str_jour'] = "%" . $str_jour . "%";
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
        } 
        catch (PDOException $error) {
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
                    WHERE user.id_user <> 2 AND user.bln_active = 1";
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
        } 
        catch (PDOException $error) {
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
                    WHERE user.id_user <> 2
                    AND user.bln_active = 1
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
                      str_pseudo = :str_pseudo, 
                      bln_mj = :bln_mj,
                      str_description = :str_description, 
                      id_experience = :id_experience, 
                      id_profil_image = :id_profil_image, 
                      dtm_maj = :dtm_maj";

            $params = [
                ":str_email" => $user->getStrEmail(),
                ":str_nom" => $user->getStrNom(),
                ":str_prenom" => $user->getStrPrenom(),
                ":str_pseudo" => $user->getStrPseudo(),
                ":bln_mj" => $user->isBlnMj(),
                ":str_description" => $user->getStrDescription(),
                ":id_experience" => $user->getIdExperience(),
                ":id_profil_image" => $user->getIdProfilImage(),
                ":dtm_maj" => $user->getDtmMaj(),
                ":id_user" => $user->getIdUser()
            ];
    
            if (!empty($user->getStrMdp())) {
                $sql .= ", str_mdp = :str_mdp";
                $params[":str_mdp"] = $user->getStrMdp();
            }
    
            $sql .= " WHERE id_user = :id_user;";
    
            $statement = $this->DB->prepare($sql);
            $statement->execute($params);
    
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
            $this->DB->beginTransaction();

            $sql_message = "UPDATE message SET id_destinataire = 2 WHERE id_destinataire = :id_user;";
            $statement_message = $this->DB->prepare($sql_message);
            $statement_message->execute([":id_user" => $id_user]);

            $sql_message_2 = "UPDATE message SET id_expediteur = 2 WHERE id_expediteur = :id_user;";
            $statement_message_2 = $this->DB->prepare($sql_message_2);
            $statement_message_2->execute([":id_user" => $id_user]);

            $sql_avis = "UPDATE avis_user SET id_observateur = 2 WHERE id_observateur = :id_user;";
            $statement_avis = $this->DB->prepare($sql_avis);
            $statement_avis->execute([":id_user" => $id_user]);

            $sql_avis_2 = "UPDATE avis_user SET id_evalue = 2 WHERE id_evalue = :id_user;";
            $statement_avis_2 = $this->DB->prepare($sql_avis_2);
            $statement_avis_2->execute([":id_user" => $id_user]);

            $sql_avis_article = "UPDATE avis_article SET id_user = 2 WHERE id_user = :id_user;";
            $statement_avis_article = $this->DB->prepare($sql_avis_article);
            $statement_avis_article->execute([":id_user" => $id_user]);

            $sql = "DELETE FROM user WHERE id_user = :id_user;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([":id_user" => $id_user]);

            $this->DB->commit();

            return true;
        } catch (PDOException $error) {
            $this->DB->rollBack();
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    /**
     * Permet de trouver un utilisateur depuis son email et de vérifier son mdp
     *
     * @param   string  $str_email  Email donné par l'utilisateur
     * @param   string  $mdp   Mdp donné par l'utilisateur
     *
     * @return  User    Retourne l'utilisateur si les données sont correctes
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
     * @param   string  $str_pseudo pseudonyme unique de l'utilisateur
     * @param   string  $str_mdp    Nouveau mot de passe donné par l'utilisateur
     *
     * @return  bool              Retourne vrai si tout s'est bien passé
     */
    public function activateThisUser(string $str_pseudo, string $str_mdp):bool {
        try {
            $sql = "UPDATE user SET
                    str_mdp = :str_mdp,
                    bln_active = :bln_active,
                    str_token = :str_token
                    WHERE str_pseudo = :str_pseudo;";
            $statement = $this->DB->prepare($sql);
            $retour = $statement->execute([
                ":str_mdp" => $str_mdp,
                ":bln_active" => 1,
                ":str_token" => "",
                ":str_pseudo" => $str_pseudo
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

    /**
     * permet de connaitre le nombre de j'aime et le nombre total d'avis
     *
     * @param   int    $id_user  identifiant de l'utilisateur concerné
     *
     * @return  array            un table contenant le nombre de j'aime et le nombre d'avis total
     */
    public function getAvisUser(int $id_user):array {
        try {
            $sql = "SELECT 
                        COUNT(*) AS total, 
                        COALESCE(SUM(CASE WHEN avis_user.bln_aime = 1 THEN 1 ELSE 0 END),0) AS aime
                    FROM avis_user
                    WHERE id_evalue = :id_user;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ':id_user' => $id_user
            ]);
            return $statement->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }


    public function addVote(AvisUser $avis_user):bool {
        try {
            $sql = "INSERT INTO avis_user (id_observateur, id_evalue, bln_aime)
                    VALUES (:id_observateur, :id_evalue, :bln_aime)";
            $statement = $this->DB->prepare($sql);
            $retour = $statement->execute([
                ':id_observateur'   => $avis_user->getIdObservateur(),
                ':id_evalue'        => $avis_user->getIdEvalue(),
                ':bln_aime'         => $avis_user->getBlnAime()
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

    public function alreadyVote(int $id_observateur, int $id_evalue):bool {
        try{
            $sql = "SELECT * FROM avis_user 
                    WHERE id_observateur = :id_observateur 
                    AND id_evalue = :id_evalue;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ':id_observateur'   => $id_observateur,
                ':id_evalue'        => $id_evalue
            ]);
            $retour = $statement->fetchAll(PDO::FETCH_ASSOC);
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

    public function UpdateVote(AvisUser $avis_user):bool {
        try {
            $sql = "UPDATE avis_user SET
                        bln_aime = :bln_aime,
                        dtm_maj = NOW()
                    WHERE id_observateur = :id_observateur 
                    AND id_evalue = :id_evalue;";
            $statement = $this->DB->prepare($sql);
            $retour = $statement->execute([
                ':id_observateur'   => $avis_user->getIdObservateur(),
                ':id_evalue'        => $avis_user->getIdEvalue(),
                ':bln_aime'         => $avis_user->getBlnAime()
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

    public function verificationToken(string $str_token, string $str_pseudo):bool {
        try {
            $sql = "SELECT * FROM user WHERE str_token = :str_token AND str_pseudo = :str_pseudo LIMIT 1;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ":str_token" => $str_token,
                "str_pseudo" => $str_pseudo
            ]);
            $retour = $statement->fetch(PDO::FETCH_ASSOC);
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