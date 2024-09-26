<?php

use src\Repositories\GameRepository;
use src\Repositories\UserRepository;

include_once __DIR__ . '/includes/header.php';

$UserRepository = UserRepository::getInstance($database);
$GameRepository = GameRepository::getInstance($database);

if(isset($utilisateur) && !empty($utilisateur)) {
    $id_utilisateur = intval($utilisateur->getIdUser());
    $tab_connu = $GameRepository->getAllGameConnu($id_utilisateur);
    $pseudo = htmlspecialchars($utilisateur->getStrPseudo(), ENT_QUOTES | ENT_HTML401, 'UTF-8', false);
    $liste_game = $GameRepository->getAllGame();

?>
    <div class="form_bg">
        <div class="form_post_texte">
            <h2 class="connexion_titre">Jeux connus</h2>
            <?php
            if($erreur !== '') { ?>
                <p class="erreur_texte"> <?= $erreur ?> </p>
            <?php } 
            if($succes !== '') { ?>
                <p class="succes_texte"> <?= $succes ?> </p>
            <?php } ?>
            <div class="tableau_containeur">
                <table class="accueil_tableau dispo_marge_bas">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Catégorie</th>
                            <th>Résumé</th>
                            <?php
                            if(isset($user)) {
                                if($pseudo === $user->getStrPseudo()){ ?>
                                    <th>Supprimer ?</th>
                                <?php }
                            } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(!empty($tab_connu)) {
                            foreach($tab_connu as $jeu) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($jeu['str_nom'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></td>
                                    <td><?= htmlspecialchars($jeu['categorie'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></td>
                                    <td><?= htmlspecialchars($jeu['str_resume'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></td>
                                    <?php
                                    if(isset($user)) {
                                        if($pseudo === $user->getStrPseudo()){ ?>
                                        <th><a href="<?= HOME_URL ?>connu/<?= $pseudo ?>/delete/<?= htmlspecialchars($jeu['id_game'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce jeu de votre liste ?');"> X </a></th>
                                    <?php }
                                } ?>
                                </tr>
                            <?php }
                        }
                        else { ?>
                            <tr><td colspan="4" class="erreur">Aucun jeu renseigné.</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php
            if(isset($user)) {
                if($pseudo === $user->getStrPseudo()) { ?>
                    <h3 class="message_titre">Ajouter un jeu connu :</h3>
                    <form action="<?= HOME_URL ?>connu/<?= $pseudo ?>/add" method="POST" class="connexion_form">
                        <input type="hidden" name="id_user" id="id_user" value="<?= $id_utilisateur ?>">
                        <div class="connexion_champs">
                            <label for="id_game" class="">Jeu souhaité :</label>
                            <select name="id_game" id="id_game">
                                <option value="">Choisissez un jeu que vous connaissez</option>
                            <?php
                            if(!empty($liste_game)) {
                                foreach($liste_game as $game) { ?>
                                    <option value="<?= intval($game['id_game']) ?>"><?= htmlspecialchars($game['str_nom'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></option>
                                <?php }
                            } ?>
                            </select>
                        </div>
                        <button type="submit" class="btn_gd_utilisateur">Ajouter</button>
                    </form>
                <?php }
            } ?>
        </div>
    </div>
<?php }
else {
    // Renvoyer à l'accueil avec message erreur;
}
include_once __DIR__ . '/includes/footer.php';