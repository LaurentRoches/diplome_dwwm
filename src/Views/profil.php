<?php

include_once __DIR__ . '/includes/header.php';

use src\Repositories\ExperienceRepository;
use src\Repositories\UserRepository;
use src\Repositories\ProfilImageRepository;

$UserRepository = UserRepository::getInstance($database);
$ProfilImageRepository = ProfilImageRepository::getInstance($database);
$ExperienceRepository = ExperienceRepository::getInstance($database);

$temoin = FALSE;
if(isset($user)) {
    if($utilisateur->getStrPseudo() === $user->getStrPseudo()){
        $temoin = TRUE;
    }
}

if(isset($utilisateur) && !empty($utilisateur)) { 

    $image_utilisateur = $ProfilImageRepository->getThisImage($utilisateur->getIdProfilImage()); 
    $niveau_utilisateur = $ExperienceRepository->getThisExperience($utilisateur->getIdExperience());
    $description = htmlspecialchars($utilisateur->getStrDescription());
    $pseudo = htmlspecialchars($utilisateur->getStrPseudo());
    $id_utilisateur = intval($utilisateur->getIdUser());
    $tab_avis = $UserRepository->getAvisUser($id_utilisateur);
?>
<div class="profil_corps">
    <div class="profil_presentation">
        <img src="<?= HOME_URL . htmlspecialchars($image_utilisateur->getStrChemin()) ?>" alt="miniature de l'image de profile" class="profil_image">
        <div class="profil_presentation_texte">
            <h2><?php 
            if($temoin) { ?>
                <span>bonjour </span>
            <?php } ?><?= $pseudo ?></h2>
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
        <p class="profil_description"><?= $description ?></p>
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
            <a href="<?= HOME_URL ?>connu/<?= $pseudo ?>" class="btn_gd_utilisateur">Jeux connus</a>
        </div>
        <div class="profil_btn_action">
            <a href="<?= HOME_URL ?>voulu/<?= $pseudo ?>" class="btn_gd_utilisateur">Jeux voulu</a>
        </div>
        <div class="profil_btn_action">
            <?php
            if(isset($user) && $utilisateur->getStrPseudo() !== $user->getStrPseudo()) { ?>
                <form action="<?= HOME_URL ?>vote/<?= $pseudo ?>" method="POST">
                <input type="hidden" name="id_evalue" value="<?= $id_utilisateur ?>">
                <input type="hidden" name="id_observateur" value="<?= intval($user->getIdUser()) ?>">
                <input type="hidden" name="bln_aime" value="1">
            <?php } ?>
                <button type="submit" class="btn_like"><img src="<?= HOME_URL ?>img/Icons/like_icon.svg" alt="bouton j'aime" class="profil_like"></button>
            <?php
            if(isset($user) && $utilisateur->getStrPseudo() !== $user->getStrPseudo()) { ?>
                </form>
            <?php }
            if(!empty($tab_avis)) { ?>
                <p><?= $tab_avis['aime'] ?></p>
            <?php }
            else { ?>
                <p>0</p>
            <?php } ?>
        </div>
        <div class="profil_btn_action">
        <?php
            if(isset($user) && $utilisateur->getStrPseudo() !== $user->getStrPseudo()) { ?>
                <form action="<?= HOME_URL ?>vote/<?= $pseudo ?>" method="POST">
                <input type="hidden" name="id_evalue" value="<?= $id_utilisateur ?>">
                <input type="hidden" name="id_observateur" value="<?= intval($user->getIdUser()) ?>">
                <input type="hidden" name="bln_aime" value="0">
            <?php } ?>
                <button type="submit" class="btn_dislike"><img src="<?= HOME_URL ?>img/Icons/like_icon.svg" alt="bouton je n'aime pas" class="profil_dislike"></button>
            <?php
            if(isset($user) && $utilisateur->getStrPseudo() !== $user->getStrPseudo()) { ?>
                </form>
            <?php }
            if(!empty($tab_avis)) { ?>
                <p><?= ($tab_avis['total'] - $tab_avis['aime']) ?></p>
            <?php }
            else { ?>
                <p>0</p>
            <?php } ?>
        </div>
    </div>
    <?php
    if($temoin) { ?>
        <a href="<?= HOME_URL ?>profil/<?= $pseudo ?>/update" class="btn_gd_utilisateur">Modifier</a>
    <?php } ?>
</div>
<?php
}
else {
    // Renvoyer à l'accueil avec message erreur;
}
include_once __DIR__ . '/includes/footer.php';










