<?php

include_once __DIR__ . '/includes/header.php';

use src\Repositories\UserRepository;
use src\Repositories\ProfilImageRepository;

$UserRepository = UserRepository::getInstance($database);
$ProfilImageRepository = ProfilImageRepository::getInstance($database);

$user_liste = $UserRepository->getAllUser();
$role = (int)$user->getIdRole();
$id_image = (int)$user->getIdProfilImage();
$image = $ProfilImageRepository->getThisImage($id_image);

?>
<head>
    <meta name="description" content="Explore les articles de JDRConnexion pour découvrir des conseils, astuces et actualités sur le jeu de rôle. Améliore ta pratique du JDR et reste informé des dernières nouveautés.">
</head>
<p>liste de articles</p>