<?php
$user = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet diplome dwwm</title>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= HOME_URL ?>css/pc.css">
    <link rel="stylesheet" href="<?= HOME_URL ?>css/mobile.css" media="only screen and (max-width: 768px)">
    <script> const HOME_URL = "<?= HOME_URL ?>"; </script>
    <script src="/public/js/burger.js"></script>
</head>
<body>

<nav class="navbar">
    <div class="header_flex">
        <a href="<?= HOME_URL ?>">
            <img src="<?= HOME_URL ?>img/logo_site.png" alt="logo du site [Nom du site]" class="logo_header">
        </a>
        <a href="<?= HOME_URL ?>">
            <h1 class="logo">[Nom du site]</h1>
        </a>
    </div>
    <ul class="nav-links">
        <li><a href="<?= HOME_URL ?>userliste">Utilisateurs</a></li>
        <li><a href="<?= HOME_URL ?>articleliste">Articles</a></li>
        <?php
        if(isset($_SESSION['connecte'])){ ?>
        <li><a href="<?= HOME_URL ?>profil">Mon profil</a></li>
        <li><a href="<?= HOME_URL ?>deconnexion">Déconnexion</a></li>
        <?php
        } 
        else { ?>
        <li><a href="<?= HOME_URL ?>connexion">Se connecter</a></li>
        <li><a href="<?= HOME_URL ?>inscription">Inscription</a></li>
        <?php  } ?>
    </ul>
    <div class="burger">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
    </div>
</nav>