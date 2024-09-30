<?php

include_once __DIR__ . '/includes/header.php';

?>
<head>
    <meta name="robots" content="noindex">
</head>
<div class="accueil_centrer">
    <?php
    if(!empty($erreur)){ ?>
    <p class="erreur_texte"> <?= $erreur ?> </p>
    <?php
    }
    if(!empty($succes)){ ?>
    <p class="succes_texte"> <?= $succes ?> </p>
    <?php } ?>
    <h2>Bonjour <?= htmlspecialchars($user->getStrPseudo(), ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></h2>
    <h3>Qu'allons nous faire aujourd'hui ?</h3>
    <div class="profil_action">
        <div class="profil_btn_action">
            <a href="<?= HOME_URL ?>admin/article" class="btn_gd_article">Articles</a>
        </div>
        <div class="profil_btn_action">
            <a href="<?= HOME_URL ?>admin/jeu" class="btn_gd_article">Jeux</a>
        </div>
        <div class="profil_btn_action">
            <a href="<?= HOME_URL ?>admin/categorieArticle" class="btn_gd_article" style="font-size: 0.95em;">Catégories article</a>
        </div>
        <div class="profil_btn_action">
            <a href="<?= HOME_URL ?>admin/categorieJeu" class="btn_gd_article">Catégories jeu</a>
        </div>
        <div class="profil_btn_action">
            <a href="<?= HOME_URL ?>admin/user" class="btn_gd_utilisateur">Utilisateurs</a>
        </div>
        <div class="profil_btn_action">
            <a href="<?= HOME_URL ?>admin/tabou" class="btn_gd_utilisateur">Censure</a>
        </div>
        <div class="profil_btn_action">
            <a href="<?= HOME_URL ?>admin/message" class="btn_gd_utilisateur">Message</a>
        </div>
    </div>
</div>
<?php

include_once __DIR__ . '/includes/footer.php';