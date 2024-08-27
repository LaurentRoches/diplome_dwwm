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

$user_liste = $UserRepository->getAllUser();
$user = unserialize($_SESSION['user']);
$role = (int)$user->getIdRole();
if ($role === 2 || $role === 3) { ?>
        <h2>Liste des users</h2>
        <table>
            <tr></tr>
        </table>
    <?php
    foreach($user_liste as $utilisateur) { ?>
    <p><?= htmlspecialchars($utilisateur['str_nom'], ENT_QUOTES, 'UTF-8') ?></p>

    <?php
    }
}


?>