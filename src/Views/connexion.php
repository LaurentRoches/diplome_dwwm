<?php

include_once __DIR__ . '/Includes/header.php';

$erreur = isset($_SESSION['erreur']) ? $_SESSION['erreur'] : '';
$_SESSION['erreur'] = '';
$succes = isset($_SESSION['succes']) ? $_SESSION['succes'] : '';
$_SESSION['succes'] = '';


?>
<div class="form_bg">
  <div class="form_post_texte">
    <h2 class="connexion_titre">Connectez-vous</h2>
    <?php
    if($erreur !== '') { ?>
      <p> <?= $erreur ?> </p>
    <?php } 
    if($succes !== '') { ?>
      <p> <?= $succes ?> </p>
    <?php } ?>
    <form class="" action="<?=HOME_URL?>connexion" method="POST">
        <div>
            <label for="email" class="">Addresse email :</label>
            <div class="mt-2">
              <input id="str_email" name="str_email" type="email" autocomplete="email" required class="">
            </div>
        </div>

          <div>
            <div class="">
              <label for="str_mdp" class="">Mot de passe :</label>
              <div class="text-sm">
                <a href="#" class="">Mot de passe oublié?</a>
              </div>
            </div>
            <div class="mt-2">
              <input id="str_mdp" name="str_mdp" type="password" required class="">
            </div>
          </div>

          <div>
            <button type="submit" class="">Se connecter</button>
          </div>
    </form>
  </div>
</div>

<?php

include_once __DIR__ . '/Includes/footer.php';