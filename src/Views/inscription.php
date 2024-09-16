<?php

include_once __DIR__ . '/includes/header.php';

?>
<head>
    <meta name="description" content="Inscris-toi sur JDRConnexion pour rejoindre une communauté de passionnés de jeux de rôle. Trouve des partenaires de jeu et participe à des aventures épiques.">
</head>
<div class="form_bg">
    <div class="form_post_texte">
        <h2 class="connexion_titre">Inscription</h2>
        <?php
        if($erreur !== '') { ?>
        <p class="erreur_texte"> <?= $erreur ?> </p>
        <?php } ?>
        <form class="connexion_form" action="<?=HOME_URL?>inscription" method="POST">

            <input type="hidden" name="dtm_creation" value="<?php echo date('Y-m-d H:i:s'); ?>">

            <div class="connexion_champs">
                <label for="str_email" class="">Addresse email :</label>
                <input id="str_email" name="str_email" type="email" autocomplete="email" required class="">
            </div>

            <div class="connexion_champs">
                <label for="str_nom" class="">Votre nom :</label>
                    <input id="str_nom" name="str_nom" type="text" required class="">
            </div>

            <div class="connexion_champs">
                <label for="str_prenom" class="">Votre prénom :</label>
                    <input id="str_prenom" name="str_prenom" type="text" required class="">
            </div>

            <div class="connexion_champs">
                <label for="str_pseudo" class="">Votre pseudo :</label>
                    <input id="str_pseudo" name="str_pseudo" type="text" required class="">
            </div>

            <div class="connexion_champs">
                <label for="dtm_naissance" class="">Votre date de naissance :</label>
                    <input id="dtm_naissance" name="dtm_naissance" type="date" required class="">
            </div>
            <button type="submit" class="btn_gd_utilisateur">S'enregistrer</button>
        </form>
    </div>
</div>

<?php

include_once __DIR__ . '/includes/footer.php';