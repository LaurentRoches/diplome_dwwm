<?php

use src\Repositories\UserRepository;

include_once __DIR__ . '/includes/header.php';

$UserRepository = UserRepository::getInstance($database);

if(isset($utilisateur) && !empty($utilisateur)) {
    $id_utilisateur = intval($utilisateur->getIdUser());
    $pseudo = htmlspecialchars($utilisateur->getStrPseudo());

?>

    <h2>VOUS ETES DANS LES MESSAGES</h2>
    <?php
    if($erreur !== '') { ?>
        <p class="erreur_texte"> <?= $erreur ?> </p>
    <?php } 
    if($succes !== '') { ?>
        <p class="succes_texte"> <?= $succes ?> </p>
    <?php } 
    if(isset($user)) {
        if($pseudo === $user->getStrPseudo()) { ?>
            Ici la liste des messages, trie a voir !
        <?php }
        else { ?>
            <form action="<?= HOME_URL ?>connu/<?= $pseudo ?>" method="POST" class="connexion_form">
                <input type="hidden" name="id_expediteur" value="<?= intval($user->getIdUser()) ?>">
                <input type="hidden" name="id_destinataire" value="<?= $id_utilisateur ?>">
                <label for="str_message">Votre message: <em>(255 caractères maximum)</em></label>
                <textarea name="str_message" id="str_message" maxlength="255"></textarea>
                <button type="submit" class="btn_gd_utilisateur">Envoyer</button>
            </form>
        <?php }
    } ?>

<?php }
else {
    // Renvoyer à l'accueil avec message erreur;
}
include_once __DIR__ . '/includes/footer.php';
