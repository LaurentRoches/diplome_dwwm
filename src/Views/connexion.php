<?php

include_once __DIR__ . '/includes/header.php';

?>
<head>
    <meta name="description" content="Connecte-toi à JDRConnexion pour accéder à ton compte et profiter des fonctionnalités du site. Trouve facilement des partenaires pour tes parties de jeu de rôle.">
</head>
<div class="form_bg">
    <div class="form_post_texte">
        <h2 class="connexion_titre">Connectez-vous</h2>
        <?php
        if($erreur !== '') { ?>
        <p class="erreur_texte"> <?= $erreur ?> </p>
        <?php } 
        if($succes !== '') { ?>
        <p class="succes_texte"> <?= $succes ?> </p>
          <?php } ?>
        <form class="connexion_form" action="<?=HOME_URL?>connexion" method="POST">
            <div class="connexion_champs">
                <label for="email" class="">Addresse email :</label>
                <input id="str_email" name="str_email" type="email" autocomplete="email" required class="">
            </div>
            <div class="connexion_champs">
                <label for="str_mdp" class="">Mot de passe :</label>
                <input id="str_mdp" name="str_mdp" type="password" required class="">
                <a href="<?=HOME_URL?>mdpoublie" class="">Mot de passe oublié?</a>
            </div>
            <button type="submit" class="btn_gd_utilisateur">Se connecter</button>
        </form>
        <div class="connexion_inscription">
            <p>Pas encore de compte ?</p>
            <button class="btn_pt_utilisateur">Inscription</button>
        </div>
    </div>
</div>

<?php

include_once __DIR__ . '/includes/footer.php';