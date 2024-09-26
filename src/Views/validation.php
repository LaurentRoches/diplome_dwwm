<?php

use src\Repositories\UserRepository;

include_once __DIR__ . '/includes/header.php';

if(isset($_GET['token']) && isset($_GET['pseudo'])) {

    $str_token = htmlspecialchars($_GET['token'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false);
    $str_pseudo = htmlspecialchars($_GET['pseudo'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false);

    $UserRepository = UserRepository::getInstance($database);
    $verification = $UserRepository->verificationToken($str_token, $str_pseudo);

    if($verification) { ?>
        <div class="form_bg">
            <div class="form_post_texte">
            <form class="connexion_form" action="<?=HOME_URL?>validation" method="POST">
                <input type="hidden" name="str_pseudo" value="<?= $str_pseudo ?>">
                <div class="connexion_champs">
                    <label for="str_mdp" class="">Votre mot de passe :</label>
                    <input id="str_mdp" name="str_mdp" type="password" required class="">
                </div>
                <div class="connexion_champs">
                    <label for="str_mdp_2" class="">Confirmez votre mot de passe :</label>
                    <input id="str_mdp_2" name="str_mdp_2" type="password" required class="">
                </div>
                <button type="submit" class="btn_gd_utilisateur">Enregistrer</button>
            </form>
            </div>
        </div>
    <?php }
    else { ?>
        <h2>Token invalide ou expiré!</h2>
        <a href="<?= HOME_URL ?>">Retour à l'accueil</a>
    <?php }
}
else { ?>
    <h2>Lien d'activation incorrecte!</h2>
    <a href="<?= HOME_URL ?>">Retour à l'accueil</a>
<?php }


include_once __DIR__ . '/includes/footer.php';