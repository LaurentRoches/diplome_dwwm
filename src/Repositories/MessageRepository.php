<?php

namespace src\Repositories;

use PDO;
use PDOException;
use src\Models\Database;
use src\Models\Message;

class MessageRepository {

    private $DB;

    private function __construct() {
        $database = new Database();
        $this->DB = $database->getDB();
        require_once __DIR__.'/../../config.php';
    }

    public static function getInstance(Database $db): self {
        return new self($db);
    }

    public function createMessage(Message $message):bool {
        try {
            $sql = "INSERT INTO message (id_expediteur, id_destinataire, str_message)
                    VALUES (:id_expediteur, :id_destinataire, :str_message);";
            $Statement = $this->DB->prepare($sql);
            $retour = $Statement->execute([
                ':id_expediteur'    => $message->getIdExpediteur(),
                ':id_destinataire'  => $message->getIdDestinataire(),
                ':str_message'      => $message->getStrMessage()
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

    public function deleteThisMessage(int $id_message):bool {
        try {
            $sql = "DELETE FROM message WHERE id_message = :id_message;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ':id_message' => $id_message
            ]);
            return true;
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function getAllExpediteur(int $id_destinataire):array {
        try {
            $sql = "SELECT user.str_pseudo, profil_image.str_chemin, MIN(message.bln_lu) AS bln_lu, MAX(message.dtm_envoi) AS last_message_date
                    FROM message
                    LEFT JOIN user ON message.id_expediteur = user.id_user
                    LEFT JOIN profil_image ON profil_image.id_profil_image = user.id_profil_image
                    WHERE message.id_destinataire = :id_destinataire
                    GROUP BY message.id_expediteur
                    ORDER BY last_message_date DESC, bln_lu ASC;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ':id_destinataire' => $id_destinataire
            ]);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function getDiscution(int $id_destinataire, int $id_expediteur): array {
        try {
            $sql = "SELECT 
                        message.*, 
                        expediteur.str_pseudo AS expediteur_pseudo, 
                        destinataire.str_pseudo AS destinataire_pseudo, 
                        profil_image.str_chemin
                    FROM message
                    LEFT JOIN user AS expediteur ON message.id_expediteur = expediteur.id_user
                    LEFT JOIN user AS destinataire ON message.id_destinataire = destinataire.id_user
                    LEFT JOIN profil_image ON profil_image.id_profil_image = expediteur.id_profil_image
                    WHERE (message.id_expediteur = :id_expediteur AND message.id_destinataire = :id_destinataire)
                    OR (message.id_expediteur = :id_destinataire AND message.id_destinataire = :id_expediteur)
                    ORDER BY dtm_envoi DESC;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ':id_destinataire' => $id_destinataire,
                ':id_expediteur' => $id_expediteur
            ]);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

    public function marquerCommeLu(int $id_destinataire, int $id_expediteur):void {
        try {
            $sql = "UPDATE message SET bln_lu = 1
                    WHERE id_expediteur = :id_expediteur 
                    AND id_destinataire = :id_destinataire
                    AND bln_lu = 0;";
            $statement = $this->DB->prepare($sql);
            $statement->execute([
                ':id_destinataire' => $id_destinataire,
                ':id_expediteur' => $id_expediteur
            ]);
        }
        catch (PDOException $error) {
            throw new \Exception("Database error: " . $error->getMessage());
        }
    }

}