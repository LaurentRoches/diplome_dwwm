<?php

include_once __DIR__ . '/Includes/header.php';

use src\Models\Database;
use src\Repositories\UserRepository;
use src\Repositories\ProfilImageRepository;

$erreur = isset($_SESSION['erreur']) ? $_SESSION['erreur'] : '';
$_SESSION['erreur'] = '';
$succes = isset($_SESSION['succes']) ? $_SESSION['succes'] : '';
$_SESSION['succes'] = '';

$database = new Database;
$UserRepository = UserRepository::getInstance($database);
$ProfilImageRepository = ProfilImageRepository::getInstance($database);
if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
}

if(isset($utilisateur) && !empty($utilisateur)) { ?>
    <h2> PAGE DE PROFIL</h2>
    <p>bonjour <?= $utilisateur->getStrPseudo() ?></p>
<?php
}
else {
    // Renvoyer à l'accueil avec message erreur;
}
include_once __DIR__ . '/Includes/footer.php';










