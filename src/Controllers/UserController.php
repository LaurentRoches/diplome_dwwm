<?php

namespace src\Controllers;

use DateTime;
use Exception;
use src\Models\Database;
use src\Models\User;
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
}