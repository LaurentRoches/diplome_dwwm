<?php

include_once __DIR__ . '/includes/header.php';

use src\Repositories\ExperienceRepository;
use src\Repositories\MessageRepository;
use src\Repositories\UserRepository;
use src\Repositories\ProfilImageRepository;

$UserRepository = UserRepository::getInstance($database);
$ProfilImageRepository = ProfilImageRepository::getInstance($database);
$ExperienceRepository = ExperienceRepository::getInstance($database);

$temoin = FALSE;
$non_lu = false;
if(isset($user)) {
    if($utilisateur->getStrPseudo() === $user->getStrPseudo()){
        $temoin = TRUE;
        $MessageRepository = MessageRepository::getInstance($database);
        $tab_expediteur = $MessageRepository->getAllExpediteur($user->getIdUser());
        foreach ($tab_expediteur as $expediteur) {
            if (isset($expediteur['bln_lu']) && $expediteur['bln_lu'] == 0) {
                $non_lu = true;
                break;
            }
        }
    }
}

if(isset($utilisateur) && !empty($utilisateur)) { 

    $image_utilisateur = $ProfilImageRepository->getThisImage($utilisateur->getIdProfilImage()); 
    $niveau_utilisateur = $ExperienceRepository->getThisExperience($utilisateur->getIdExperience());
    $description = htmlspecialchars($utilisateur->getStrDescription(), ENT_QUOTES | ENT_HTML401, 'UTF-8', false);
    $pseudo = htmlspecialchars($utilisateur->getStrPseudo(), ENT_QUOTES | ENT_HTML401, 'UTF-8', false);
    $id_utilisateur = intval($utilisateur->getIdUser());
    $tab_avis = $UserRepository->getAvisUser($id_utilisateur);
    $dtm_naissance = $utilisateur->getDtmNaissance();
    $dtm_naissance = new DateTime($dtm_naissance);
    $dtm_actuelle = new DateTime();
    $age = $dtm_actuelle->diff($dtm_naissance)->y;
?>
<div class="profil_corps">
    <div class="profil_presentation">
        <img src="<?= HOME_URL . htmlspecialchars($image_utilisateur->getStrChemin(), ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?>" alt="miniature de l'image de profile" class="profil_image">
        <div class="profil_presentation_texte">
            <h2><?php 
            if($temoin) { ?>
                <span>bonjour </span><strong>
            <?php } ?><?= $pseudo ?></strong></h2>
            <h3>
                <?php
                if($utilisateur->isBlnMj() === TRUE) { ?>
                    <strong>Maître du Jeu</strong>
                <?php }
                else { ?>
                    <strong>Joueur</strong>
                <?php } ?>
            </h3>
            <p>Niveau de joueur : <strong><?= $niveau_utilisateur->getStrNiveau() ?></strong></p>
            <p><?php
            if($age < 18) {
                echo "Ce joueur est <strong>mineur</strong>";
            }
            else {
                echo "Ce joueur est <strong>majeur</strong>";
            }
            ?></p>
            <p class="conversation_mini_texte">Compte créer le <?= $utilisateur->getDtmCreation() ?></p>
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
            <a href="<?= HOME_URL ?>message/<?= $pseudo ?>" class="btn_gd_utilisateur <?= ($non_lu) ? 'conversation_mini_texte non_lu' : '' ?>"><?= ($non_lu) ? 'Nouveau message' : 'Messages' ?></a>
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
        <a href="<?= HOME_URL ?>deleteProfil/<?= $pseudo ?>" class="btn_gd_utilisateur" onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible!');">Supprimer</a>
    <?php } ?>
</div>
<?php
}
else {
    // Renvoyer à l'accueil avec message erreur;
}
include_once __DIR__ . '/includes/footer.php';










