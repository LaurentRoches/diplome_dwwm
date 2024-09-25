<?php

use src\Repositories\ExperienceRepository;
use src\Repositories\ProfilImageRepository;
use src\Repositories\UserRepository;

include_once __DIR__.'/includes/header.php';

if(isset($utilisateur) && !empty($utilisateur)) { 

    $UserRepository = UserRepository::getInstance($database);
    $ExperienceRepository = ExperienceRepository::getInstance($database);
    $ProfilImageRepository = ProfilImageRepository::getInstance($database);

    $tab_image = $ProfilImageRepository->getAllImage();
    $tab_experience = $ExperienceRepository->getAllExperience();
    $pseudo = htmlspecialchars($utilisateur->getStrPseudo());

?>
<div class="form_bg">
    <div class="form_post_texte">
        <h2>Mettre à jour votre profil</h2>
        <?php
        if($erreur !== '') { ?>
        <p class="erreur_texte"> <?= $erreur ?> </p>
        <?php } ?>
        <form class="connexion_form" action="<?= HOME_URL ?>profil/<?= $pseudo ?>/update" method="POST">
            <input type="hidden" name="dtm_maj" value="<?= date('Y-m-d H:i:s') ?>">
            <input type="hidden" name="id_user" value="<?= intval($utilisateur->getIdUser()) ?>">
            <div class="connexion_champs">
                <label for="str_nom"> Votre nom :</label>
                <input type="text" name="str_nom" id="str_nom" value="<?= htmlspecialchars($utilisateur->getStrNom()) ?>">
            </div>
            <div class="connexion_champs">
                <label for="str_prenom"> Votre prénom:</label>
                <input type="text" name="str_prenom" id="str_prenom" value="<?= htmlspecialchars($utilisateur->getStrPrenom()) ?>">
            </div>
            <div class="connexion_champs">
                <label for="str_pseudo"> Votre pseudonyme :</label>
                <input type="text" name="str_pseudo" id="str_pseudo" value="<?= $pseudo ?>">
            </div>
            <div class="connexion_champs">
                <label for="str_email"> Votre adresse mail :</label>
                <input type="email" name="str_email" id="str_email" value="<?= htmlspecialchars($utilisateur->getStrEmail()) ?>">
            </div>
            <div class="connexion_champs">
                <label for="str_mdp"> Votre mot de passe :</label>
                <input type="password" name="str_mdp" id="str_mdp">
            </div>
            <div class="connexion_champs">
                <label for="str_mdp_2"> Confirmez votre mot de passe :</label>
                <input type="password" name="str_mdp_2" id="str_mdp_2">
            </div>
            <div class="connexion_champs">
                <label for="id_profil_image">Choisissez votre image de profil :</label>
                    <div class="profile_image_selection">
                        <?php foreach ($tab_image as $image) { ?>
                            <label>
                                <input type="radio" name="id_profil_image" value="<?= $image['id_profil_image'] ?>" <?= $image['id_profil_image'] == intval($utilisateur->getIdProfilImage()) ? 'checked' : '' ?>>
                                <img src="<?=HOME_URL . $image['str_chemin'] ?>" alt="Image de profil" class="profile_image_miniature">
                            </label>
                        <?php } ?>
                </div>
            </div>
            <div class="connexion_champs">
                <label for="bln_mj">Etes-vous un Maître du Jeu ?</label>
                <select name="bln_mj" id="bln_mj">
                    <option value="0" <?php echo ($utilisateur->isBlnMj() == 0) ? "selected" : "" ?>>Joueur</option>
                    <option value="1" <?php echo ($utilisateur->isBlnMj() == 1) ? "selected" : "" ?>>Maître du Jeu</option>
                </select>
            </div>
            <div class="connexion_champs">
                <label for="id_experience">Votre expérience de joueur :</label>
                <select name="id_experience" id="id_experience">
                    <?php
                    foreach($tab_experience as $experience) { ?>
                        <option value="<?= $experience['id_experience'] ?>" <?= ($experience['id_experience'] == $utilisateur->getIdExperience()) ? "selected" : ""?>><?= $experience['str_niveau'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="connexion_champs">
                <label for="str_description">Une courte description de vous ou de votre alter ego: <em>(255 caractères)</em></label>
                <textarea name="str_description" id="str_description" maxlength="255"><?= htmlspecialchars($utilisateur->getStrDescription()) ?></textarea>
            </div>
            <button type="submit" class="btn_gd_utilisateur">Enregistrer</button>
        </form>
    </div>
</div>



<?php }
else {
    //rediriger vers l'accueil;
}

include_once __DIR__.'/includes/footer.php';