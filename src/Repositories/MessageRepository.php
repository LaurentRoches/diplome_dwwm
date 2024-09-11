<?php

namespace src\Repositories;

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
            $retour = $Statement->eecute([
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
}