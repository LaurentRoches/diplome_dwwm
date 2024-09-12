<?php

namespace src\Controllers;

use DateTime;
use Exception;
use src\Models\AvisUser;
use src\Models\Database;
use src\Models\Message;
use src\Models\User;
use src\Repositories\DisponibiliteRepository;
use src\Repositories\GameRepository;
use src\Repositories\MessageRepository;
use src\Repositories\UserRepository;
use src\Services\Reponse;
use src\Services\Securite;

class UserController {

    use Reponse;
    use Securite;

    public function connexion():void {
        $data = file_get_contents("php://input");
        parse_str($data, $user);

        if(!empty($user)) {
            $user = $this->sanitize($user);
            $email = $user['str_email'];
            $mdp = $user['str_mdp'];
            $DbConnexion = new Database();
            $UserRepository = UserRepository::getInstance($DbConnexion);
            $user = $UserRepository->login($email, $mdp);
            if($user){
                $_SESSION["connecte"] = TRUE;
                $_SESSION["user"] = serialize($user);
                $_SESSION['succes'] = "Vous êtes connecté";
                $this->render("accueil",["succes" => $_SESSION['succes']]);
                die();
            } 
            else{
                $_SESSION["erreur"] = "Echec de connexion";
                $this->render('connexion', ["erreur" => $_SESSION["erreur"]]);
                die();
            }
        }
    }

    public function inscription() {
        parse_str(file_get_contents("php://input"), $data);
        $data = $this->sanitize($data);

        $nullFields = array_diff(array_keys($data), array_filter(array_keys($data)));

        $DbConnexion = new Database();
        $UserRepository = UserRepository::getInstance($DbConnexion);

        if (!isset($data['str_email']) || $data['str_email'] == '') {
            $_SESSION["erreur"] = "Le champs 'addresse email' est obligatoire et n'ai pas remplis.";
            $this->render("inscription", ["erreur" => $_SESSION["erreur"]]);
            return;
        }
        if(filter_var($data['str_email'], FILTER_VALIDATE_EMAIL) == FALSE) {
            $_SESSION["erreur"] = "Le champs 'addresse email' doit être au format mail.";
            $this->render("inscription", ["erreur" => $_SESSION["erreur"]]);
            return;
        }
        if($UserRepository->getThisUserByEmail($data['str_email'])){
            $_SESSION["erreur"] = "Un utilisateur avec cette adresse email existe déjà.";
            $this->render("inscription", ["erreur" => $_SESSION["erreur"]]);
            return;
        }

        if(!isset($data['str_nom']) || $data['str_nom'] == '') {
            $_SESSION["erreur"] = "Le champs 'nom' est obligatoire et n'ai pas remplis.";
            $this->render("inscription", ["erreur" => $_SESSION["erreur"]]);
            return;
        }

        if(!isset($data['str_prenom']) || $data['str_prenom'] == '') {
            $_SESSION["erreur"] = "Le champs 'prénom' est obligatoire et n'ai pas remplis.";
            $this->render("inscription", ["erreur" => $_SESSION["erreur"]]);
            return;
        }

        if(!isset($data['str_pseudo']) || $data['str_pseudo'] == '') {
            $_SESSION["erreur"] = "Le champs 'pseudo' est obligatoire et n'ai pas remplis.";
            $this->render("inscription", ["erreur" => $_SESSION["erreur"]]);
            return;
        }
        if($UserRepository->getThisUserByPseudo($data['str_pseudo'])) {
            $_SESSION["erreur"] = "Ce pseudonyme est déjà utilisé.";
            $this->render("inscription", ["erreur" => $_SESSION["erreur"]]);
            return;
        }

        if (!isset($data['dtm_naissance']) || $data['dtm_naissance'] == '') {
            $_SESSION["erreur"] = "Le champ 'date de naissance' est obligatoire et n'a pas été rempli.";
            $this->render("inscription", ["erreur" => $_SESSION["erreur"]]);
            return;
        }
        $naissances = explode('-', $data['dtm_naissance']);
        if (count($naissances) != 3 || !ctype_digit($naissances[0]) || !ctype_digit($naissances[1]) || !ctype_digit($naissances[2])) {
            $_SESSION["erreur"] = "Le format de la date de naissance est incorrect. Veuillez utiliser JJ-MM-AAAA.";
            $this->render("inscription", ["erreur" => $_SESSION["erreur"]]);
            return;
        }
        try {
            $naissance = new DateTime($data['dtm_naissance']);
            $maintenant = new DateTime();
            if ($naissance >= $maintenant) {
                $_SESSION["erreur"] = "La date de naissance ne peut pas être dans le futur.";
                $this->render("inscription", ["erreur" => $_SESSION["erreur"]]);
                return;
            }
        } 
        catch (Exception $e) {
            $_SESSION["erreur"] = "La date de naissance est invalide. Veuillez vérifier le format.";
            $this->render("inscription", ["erreur" => $_SESSION["erreur"]]);
            return;
        }

        if (!empty($nullFields)) {
            $_SESSION["erreur"] = "Les champs suivants ne peuvent pas être vides : " . implode(", ", $nullFields);
            $this->render("inscription", ["erreur" => $_SESSION["erreur"]]);
            return;
        }

        $obj = new User($data);

        $enregistrement = $UserRepository->createUser($obj);

        if ($enregistrement) {
            $_SESSION['succes'] = "Enregistrement réussi, un email vous a été envoyé.";
            $this->render("accueil", ["user"=>$enregistrement, "succes" => $_SESSION['succes']]);
        } else {
            $_SESSION["erreur"] = "Echec de l'enregistrement";
            $this->render("inscription", ["erreur" => $_SESSION["erreur"]]);
        }
    }

    public function ajoutDisponibilite(?string $pseudo = NULL) {
        if($pseudo) {
            $database = new Database();
            $UserRepository = UserRepository::getInstance($database);
            $utilisateur = $UserRepository->getThisUserByPseudo(htmlspecialchars($pseudo));
            if(!$utilisateur) {
                $_SESSION['erreur'] = "Utilisateur non trouvé.";
                $this->render("accueil");
                return;
            }
        }
        else {
            $_SESSION['erreur'] = "Erreur : Aucun utilisateur trouvé.";
            $this->render("accueil");
            return;
        }

        parse_str(file_get_contents("php://input"), $data);
        $data = $this->sanitize($data);

        $tab_dispos = [];

        foreach($data['str_jour'] as $key => $jour) {
            if($data['time_debut'][$key] >= $data['time_fin'][$key]) {
                $_SESSION['erreur'] = "L'heure de début ne peut pas être plus grande que l'heure de fin.";
                $this->render("disponibilite", ["utilisateur" => $utilisateur]);
                return;
            }
            $tab_dispos[] = [
                'id_user'       => $data['id_user'],
                'str_jour'      => $jour,
                'time_debut'    => $data['time_debut'][$key],
                'time_fin'      => $data['time_fin'][$key]
            ];
        }

        $DisponibiliteRepository = DisponibiliteRepository::getInstance($database);
        $resultat = $DisponibiliteRepository->createDisponibilite($tab_dispos);

        if ($resultat) {
            $_SESSION['succes'] = "Disponibilités ajoutées avec succès.";
        } else {
            $_SESSION['erreur'] = "Erreur lors de l'ajout des disponibilités.";
        }

        $this->render("profil", ["utilisateur" => $utilisateur]);
    }

    public function deleteThisDispo(?int $id_disponibilite, ?string $pseudo = NULL) {
        if($pseudo) {
            $database = new Database();
            $UserRepository = UserRepository::getInstance($database);
            $utilisateur = $UserRepository->getThisUserByPseudo(htmlspecialchars($pseudo));
            if(!$utilisateur) {
                $_SESSION['erreur'] = "Utilisateur non trouvé.";
                $this->render("accueil");
                return;
            }
        }
        else {
            $_SESSION['erreur'] = "Erreur : Aucun utilisateur trouvé.";
            $this->render("accueil");
            return;
        }
        $DisponibiliteRepository = DisponibiliteRepository::getInstance($database);
        $id_disponibilite = intval($id_disponibilite);
        $delete = $DisponibiliteRepository->deleteThisDispo($id_disponibilite);
        if ($delete) {
            $_SESSION['succes'] = "Disponibilité éffacé avec succès.";
            $this->render("disponibilite", ['utilisateur' => $utilisateur]);
            return;
        }
        else {
            $_SESSION['erreur'] = "Une erreur est survenue lors de la suppression.";
            $this->render("disponibilite", ['utilisateur' => $utilisateur]);
            return;
        }
    }

    public function ajoutGameConnu(?string $pseudo = NULL) {
        if($pseudo) {
            $database = new Database();
            $UserRepository = UserRepository::getInstance($database);
            $utilisateur = $UserRepository->getThisUserByPseudo(htmlspecialchars($pseudo));
            if(!$utilisateur) {
                $_SESSION['erreur'] = "Utilisateur non trouvé.";
                $this->render("accueil");
                return;
            }
        }
        else {
            $_SESSION['erreur'] = "Erreur : Aucun utilisateur trouvé.";
            $this->render("accueil");
            return;
        }

        parse_str(file_get_contents("php:://input"), $data);
        $data = $this->sanitize($data);
        $id_user = $data['id_user'];
        $id_game = $data['id_game'];

        $GameRepository = GameRepository::getInstance($database);
        $resultat = $GameRepository->createGameConnu($id_user, $id_game);

        if ($resultat) {
            $_SESSION['succes'] = "Disponibilités ajoutées avec succès.";
        } 
        else {
            $_SESSION['erreur'] = "Erreur lors de l'ajout des disponibilités.";
        }

        $this->render("connu", ["utilisateur" => $utilisateur]);
    }

    public function ajoutGameVoulu(?string $pseudo = NULL) {
        if($pseudo) {
            $database = new Database();
            $UserRepository = UserRepository::getInstance($database);
            $utilisateur = $UserRepository->getThisUserByPseudo(htmlspecialchars($pseudo));
            if(!$utilisateur) {
                $_SESSION['erreur'] = "Utilisateur non trouvé.";
                $this->render("accueil");
                return;
            }
        }
        else {
            $_SESSION['erreur'] = "Erreur : Aucun utilisateur trouvé.";
            $this->render("accueil");
            return;
        }

        parse_str(file_get_contents("php:://input"), $data);
        $data = $this->sanitize($data);
        $id_user = $data['id_user'];
        $id_game = $data['id_game'];

        $GameRepository = GameRepository::getInstance($database);
        $resultat = $GameRepository->createGameVoulu($id_user, $id_game);

        if ($resultat) {
            $_SESSION['succes'] = "Disponibilités ajoutées avec succès.";
        } else {
            $_SESSION['erreur'] = "Erreur lors de l'ajout des disponibilités.";
        }

        $this->render("voulu", ["utilisateur" => $utilisateur]);
    }

    public function deleteThisGameConnu(?int $id_game, ?string $pseudo = NULL) {
        if($pseudo) {
            $database = new Database();
            $UserRepository = UserRepository::getInstance($database);
            $utilisateur = $UserRepository->getThisUserByPseudo(htmlspecialchars($pseudo));
            if(!$utilisateur) {
                $_SESSION['erreur'] = "Utilisateur non trouvé.";
                $this->render("accueil");
                return;
            }
        }
        else {
            $_SESSION['erreur'] = "Erreur : Aucun utilisateur trouvé.";
            $this->render("accueil");
            return;
        }
        $GameRepository = GameRepository::getInstance($database);
        $id_game = intval($id_game);
        $delete = $GameRepository->deleteThisGameConnu($id_game, $utilisateur->getIdUser());
        if($delete) {
            $_SESSION['succes'] = "Jeu éffacé avec succès de la liste.";
            $this->render("connu", ['utilisateur' => $utilisateur]);
            return;
        }
        else {
            $_SESSION['erreur'] = "Une erreur est survenue lors de la suppression.";
            $this->render("connu", ['utilisateur' => $utilisateur]);
            return;
        }
    }

    public function deleteThisGameVoulu(?int $id_game, ?string $pseudo = NULL) {
        if($pseudo) {
            $database = new Database();
            $UserRepository = UserRepository::getInstance($database);
            $utilisateur = $UserRepository->getThisUserByPseudo(htmlspecialchars($pseudo));
            if(!$utilisateur) {
                $_SESSION['erreur'] = "Utilisateur non trouvé.";
                $this->render("accueil");
                return;
            }
        }
        else {
            $_SESSION['erreur'] = "Erreur : Aucun utilisateur trouvé.";
            $this->render("accueil");
            return;
        }
        $GameRepository = GameRepository::getInstance($database);
        $id_game = intval($id_game);
        $delete = $GameRepository->deleteThisGameVoulu($id_game, $utilisateur->getIdUser());
        if($delete) {
            $_SESSION['succes'] = "Jeu éffacé avec succès de la liste.";
            $this->render("voulu", ['utilisateur' => $utilisateur]);
            return;
        }
        else {
            $_SESSION['erreur'] = "Une erreur est survenue lors de la suppression.";
            $this->render("voulu", ['utilisateur' => $utilisateur]);
            return;
        }
    }

    public function envoyerMessage(?string $pseudo = NULL) {
        if($pseudo) {
            $database = new Database();
            $UserRepository = UserRepository::getInstance($database);
            $utilisateur = $UserRepository->getThisUserByPseudo(htmlspecialchars($pseudo));
            if(!$utilisateur) {
                $_SESSION['erreur'] = "Utilisateur non trouvé.";
                $this->render("accueil");
                return;
            }
        }
        else {
            $_SESSION['erreur'] = "Erreur : Aucun utilisateur trouvé.";
            $this->render("accueil");
            return;
        }

        parse_str(file_get_contents("php:://input"), $data);
        $data = $this->sanitize($data);

        $message = new Message($data);
        $MessageRepository = MessageRepository::getInstance($database);
        $retour = $MessageRepository->createMessage($message);

        if($retour) {
            $_SESSION['succes'] = "Message envoyé avec succès.";
        } 
        else {
            $_SESSION['erreur'] = "Erreur lors de l'envoi du message.";
        }
        $this->render("message", ["utilisateur" => $utilisateur]);
    }

    public function supprimerMessage(?int $id_message, ?string $pseudo = NULL) {
        if($pseudo) {
            $database = new Database();
            $UserRepository = UserRepository::getInstance($database);
            $utilisateur = $UserRepository->getThisUserByPseudo(htmlspecialchars($pseudo));
            if(!$utilisateur) {
                $_SESSION['erreur'] = "Utilisateur non trouvé.";
                $this->render("accueil");
                return;
            }
        }
        else {
            $_SESSION['erreur'] = "Erreur : Aucun utilisateur trouvé.";
            $this->render("accueil");
            return;
        }

        $MessageRepository = MessageRepository::getInstance($database);
        $id_message = intval($id_message);
        $delete = $MessageRepository->deleteThisMessage($id_message);

        if($delete) {
            $_SESSION['succes'] = "Jeu éffacé avec succès de la liste.";
            $this->render("message", ['utilisateur' => $utilisateur]);
            return;
        }
        else {
            $_SESSION['erreur'] = "Une erreur est survenue lors de la suppression.";
            $this->render("message", ['utilisateur' => $utilisateur]);
            return;
        }
    }

    public function addVote(?string $pseudo = NULL) {
        if($pseudo) {
            $database = new Database();
            $UserRepository = UserRepository::getInstance($database);
            $utilisateur = $UserRepository->getThisUserByPseudo(htmlspecialchars($pseudo));
            if(!$utilisateur) {
                $_SESSION['erreur'] = "Utilisateur non trouvé.";
                $this->render("accueil");
                return;
            }
        }
        else {
            $_SESSION['erreur'] = "Erreur : Aucun utilisateur trouvé.";
            $this->render("accueil");
            return;
        }
        parse_str(file_get_contents("php:://input"), $data);
        $data = $this->sanitize($data);
        $avis = new AvisUser($data);

        $verif = $UserRepository->alreadyVote($avis->getIdObservateur(), $avis->getIdEvalue());
        if($verif) {
            $resultat = $UserRepository->UpdateVote($avis);
        }
        else {
            $resultat = $UserRepository->addVote($avis);
        }

        if ($resultat) {
            $_SESSION['succes'] = "Avis ajouté avec succès.";
        } else {
            $_SESSION['erreur'] = "Erreur lors de l'ajout de l'avis.";
        }

        $this->render("profil", ["utilisateur" => $utilisateur]);
    }

}