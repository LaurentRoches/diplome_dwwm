<?php

use src\Repositories\GameRepository;
use src\Repositories\UserRepository;

include_once __DIR__ . '/includes/header.php';

$UserRepository = UserRepository::getInstance($database);
$GameRepository = GameRepository::getInstance($database);

if(isset($utilisateur) && !empty($utilisateur)) {
    $id_utilisateur = intval($utilisateur->getIdUser());
    $tab_connu = $GameRepository->getAllGameConnu($id_utilisateur);









}
else {
    // Renvoyer à l'accueil avec message erreur;
}
include_once __DIR__ . '/includes/footer.php';