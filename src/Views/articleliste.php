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
<p>liste de articles</p>