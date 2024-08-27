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
$id_image = (int)$user->getIdProfilImage();
$image = $ProfilImageRepository->getThisImage($id_image);

?>
<p>liste de articles</p>