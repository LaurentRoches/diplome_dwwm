<?php

use src\Repositories\MessageRepository;
use src\Repositories\UserRepository;

include_once __DIR__ . '/includes/header.php';

$UserRepository = UserRepository::getInstance($database);

if(isset($utilisateur) && !empty($utilisateur)) {
    $id_utilisateur = intval($utilisateur->getIdUser());
    $pseudo = htmlspecialchars($utilisateur->getStrPseudo());

    $MessageRepository = MessageRepository::getInstance($database);
    $tab_expediteur = $MessageRepository->getAllExpediteur($id_utilisateur);

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
        if($pseudo === $user->getStrPseudo()) { 
            if(empty($tab_expediteur)){?>
                <p class="erreur_texte">Vous n'avez pas de message.</p>
            <?php }
            else { ?>
                <table class="accueil_tableau">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Pseudo</th>
                            <th>Dernier message le:</th>
                            <th>Nouveau message ?</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($tab_expediteur as $expediteur) { ?>
                            <tr>
                                <td><a href="<?= HOME_URL ?>profil/<?= $expediteur['str_pseudo'] ?>"><img src="<?= HOME_URL ?><?= $expediteur['str_chemin'] ?>" alt="miniature de l'image de profile" class="accueil_miniature_profil"></a></td>
                                <td><a href="<?= HOME_URL ?>profil/<?= $expediteur['str_pseudo'] ?>"><?= $expediteur['str_pseudo'] ?></a></td>
                                <td><a href="<?= HOME_URL ?>message/<?= $pseudo ?>/conversation/<?= $expediteur['str_pseudo'] ?>"><?= $expediteur['last_message_date'] ?></a></td>
                                <td><a href="<?= HOME_URL ?>message/<?= $pseudo ?>/conversation/<?= $expediteur['str_pseudo'] ?>"><?= ($expediteur['bln_lu'] == 0) ? 'Messages non lu' : 'Pas de nouveau message' ?></a></td>
                                <td><a href="<?= HOME_URL ?>message/<?= $pseudo ?>/conversation/<?= $expediteur['str_pseudo'] ?>">Voir la conversation</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php }
        }
        else { ?>
            <form action="<?= HOME_URL ?>message/<?= $pseudo ?>" method="POST" class="connexion_form">
                <input type="hidden" name="id_expediteur" value="<?= intval($user->getIdUser()) ?>">
                <input type="hidden" name="id_destinataire" value="<?= $id_utilisateur ?>">
                <label for="str_message">Votre message: <em>(255 caractères maximum)</em></label>
                <textarea name="str_message" id="str_message" maxlength="255"></textarea>
                <button type="submit" class="btn_gd_utilisateur">Envoyer</button>
            </form>
        <?php }
    }
    else {?>
    <p class="erreur_texte">Vous devez être connecté pour envoyé un message.</p>
<?php }
}
else {
    // Renvoyer à l'accueil avec message erreur;
}
include_once __DIR__ . '/includes/footer.php';
