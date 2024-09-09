<?php

include_once __DIR__ . '/Includes/header.php';

use src\Repositories\ExperienceRepository;
use src\Repositories\UserRepository;
use src\Repositories\ProfilImageRepository;

$UserRepository = UserRepository::getInstance($database);
$ProfilImageRepository = ProfilImageRepository::getInstance($database);
$ExperienceRepository = ExperienceRepository::getInstance($database);

if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
}
else {
    $user = NULL;
}

if(isset($utilisateur) && !empty($utilisateur)) { 

    $image_utilisateur = $ProfilImageRepository->getThisImage($utilisateur->getIdProfilImage()); 
    $niveau_utilisateur = $ExperienceRepository->getThisExperience($utilisateur->getIdExperience());
    $description = htmlspecialchars($utilisateur->getStrDescription());
    $pseudo = htmlspecialchars($utilisateur->getStrPseudo());
    
    ?>

    <div class="profil_corps">
    <div class="profil_presentation">
        <img src="<?= HOME_URL . $image_utilisateur->getStrChemin() ?>" alt="miniature de l'image de profile" class="profil_image">
        <div class="profil_presentation_texte">
            <h2><?php if(isset($user)) {
                        if($utilisateur->getStrPseudo() === $user->getStrPseudo()){ ?>
                            <span>bonjour </span>
                        <?php }
                        } ?><?= $pseudo ?></h2>
            <h3>
                <?php
                if($utilisateur->isBlnMj() === TRUE) { ?>
                    Maître du Jeu
                <?php }
                else { ?>
                    Joueur
                <?php } ?>
            </h3>
            <p>Créer le <?= $utilisateur->getDtmCreation() ?> ,  niveau de joueur : <?= $niveau_utilisateur->getStrNiveau() ?></p>
        </div>
    </div>
    <h3 class="profil_description">Description</h3>
    <?php
    if(isset($description) && !empty($description)) { ?>
        <p class="profil_description"><?= htmlspecialchars($description) ?></p>
    <?php }
    else {?>
        <p class="profil_description"> Pas de description renseignée.</p>
    <?php } ?>
    <div class="profil_action">
        <div class="profil_btn_action">
            <a href="<?= HOME_URL ?>message/<?= $pseudo ?>" class="btn_gd_utilisateur">Messages</a>
        </div>
        <div class="profil_btn_action">
            <a href="<?= HOME_URL ?>disponibilite/<?= $pseudo ?>" class="btn_gd_utilisateur">Disponibilité</a>
        </div>
        <div class="profil_btn_action">
            <a href="<?= HOME_URL ?>" class="btn_gd_utilisateur">Jeux connus</a>
        </div>
        <div class="profil_btn_action">
            <a href="<?= HOME_URL ?>" class="btn_gd_utilisateur">Jeux voulu</a>
        </div>
        <div class="profil_btn_action">
            <a href="<?= HOME_URL ?>" class="btn_like"><img src="<?= HOME_URL ?>img/Icons/like_icon.svg" alt="bouton j'aime" class="profil_like"></a>
        </div>
        <div class="profil_btn_action">
            <a href="<?= HOME_URL ?>" class="btn_dislike"><img src="<?= HOME_URL ?>img/Icons/like_icon.svg" alt="bouton je n'aime pas" class="profil_dislike"></a>
        </div>
    </div>
    <?php
    if(isset($user)) {
        if($utilisateur->getStrPseudo() === $user->getStrPseudo()){ ?>
            <a href="<?= HOME_URL ?>" class="btn_gd_utilisateur">Modifier</a>
        <?php }
    } ?>
</div>
<?php
}
else {
    // Renvoyer à l'accueil avec message erreur;
}
include_once __DIR__ . '/Includes/footer.php';










