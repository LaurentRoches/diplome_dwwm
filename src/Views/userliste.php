<?php

include_once __DIR__ . '/includes/header.php';

use src\Repositories\UserRepository;
use src\Repositories\ProfilImageRepository;

$UserRepository = UserRepository::getInstance($database);
$ProfilImageRepository = ProfilImageRepository::getInstance($database);

$user_liste = $UserRepository->getAllUser();
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