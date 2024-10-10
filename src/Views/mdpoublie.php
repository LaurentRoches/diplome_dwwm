<?php

include_once __DIR__ . '/includes/header.php';

?>

<div class="form_bg">
    <div class="form_post_texte">
        <?php
        if($erreur !== '') { ?>
            <p class="erreur_texte"> <?= $erreur ?> </p>
        <?php } 
        if($succes !== '') { ?>
            <p class="succes_texte"> <?= $succes ?> </p>
        <?php } ?>
        <form class="connexion_form" action="<?=HOME_URL?>mdpoublie" method="POST">
            <div class="connexion_champs">
                <label for="email">Addresse email :</label>
                <input id="str_email" name="str_email" type="email" autocomplete="email" required>
            </div>
            <button type="submit" class="btn_gd_utilisateur">Envoyer</button>
        </form>
    </div>
</div>

<?php 

include_once __DIR__ . '/includes/footer.php';