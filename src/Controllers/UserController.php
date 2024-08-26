<?php

namespace src\Controllers;

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
                $this->render("accueil",["user" => $user, "succes" => $_SESSION['succes']]);
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

        if (!isset($data['str_email']) || !isset($data['str_nom']) || !isset($data['str_prenom']) || !isset($data['dtm_naissance']) || !isset($data['str_pseudo'])) {
            $this->render("accueil", ["erreur" => "Tous les champs obligatoires ne sont pas remplis."], 400);
            return;
        }

        $sanitizedData = $this->sanitize($data);

        $nullFields = array_diff(array_keys($sanitizedData), array_filter(array_keys($sanitizedData)));

        if (!empty($nullFields)) {
            $this->render("accueil", ["erreur" => "Les champs suivants ne peuvent pas être vides : " . implode(", ", $nullFields)], 400);
            return;
        }

        $obj = new User($sanitizedData);
        $DbConnexion = new Database();
        $UserRepository = UserRepository::getInstance($DbConnexion);

        $enregistrement = $UserRepository->createUser($obj);

        if ($enregistrement) {
            $this->render("accueil", ["user"=>$enregistrement, "succes"=>"Enregistrement réussi"], 200);
        } else {
            $this->render("accueil", ["erreur" => "Echec de l'enregistrement"]);
        }
    }


}