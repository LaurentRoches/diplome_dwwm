<?php

use src\Repositories\DisponibiliteRepository;
use src\Repositories\UserRepository;

include_once __DIR__ . '/Includes/header.php';

$UserRepository = UserRepository::getInstance($database);
$DisponibiliteRepository = DisponibiliteRepository::getInstance($database);

if(isset($utilisateur) && !empty($utilisateur)) {

    $id_user = htmlspecialchars($utilisateur->getIdUser());
    $tab_disponibilite = $DisponibiliteRepository->getAllDisponibiliteById($id_user);

?>

<div class="form_bg">
    <div class="form_post_texte">
        <h2 class="connexion_titre">Disponibilités</h2>
        <?php
        if($erreur !== '') { ?>
        <p class="erreur_texte"> <?= $erreur ?> </p>
        <?php } 
        if($succes !== '') { ?>
        <p class="succes_texte"> <?= $succes ?> </p>
          <?php } ?>
        <table class="accueil_tableau">
            <thead>
                <tr>
                    <th>Jour</th>
                    <th>Heure de début</th>
                    <th>Heure de fin</th>
                    <?php
                    if(isset($user)) {
                        if($utilisateur->getStrPseudo() === $user->getStrPseudo()){ ?>
                            <th>Supprimer ?</th>
                        <?php }
                    } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                if(!empty($tab_disponibilite)) {
                    foreach($tab_disponibilite as $dispo) { ?>
                        <tr>
                            <td><?= htmlspecialchars($dispo['str_jour']) ?></td>
                            <td><?= htmlspecialchars($dispo['time_debut']) ?></td>
                            <td><?= htmlspecialchars($dispo['time_fin']) ?></td>
                            <?php
                            if(isset($user)) {
                                if($utilisateur->getStrPseudo() === $user->getStrPseudo()){ ?>
                                    <th><a href="<?= HOME_URL ?>disponibilite/<?= htmlspecialchars($utilisateur->getStrPseudo()) ?>/delete"> X </a></th>
                                <?php }
                            } ?>
                        </tr>
                    <?php }
                } ?>
            </tbody>
        </table>

        <?php
        if(isset($user)) {
            if($utilisateur->getStrPseudo() === $user->getStrPseudo()){ ?>
                <form class="connexion_form" action="<?=HOME_URL?>disponibilite/<?= htmlspecialchars($utilisateur->getStrPseudo()) ?>/add" method="POST">
                    <input type="hidden" id="id_user" name="id_user" value="<?= $id_user ?>">
                    <div id="disponibilite_container">
                        <div class="disponibilite_item">
                            <div class="disponibilte_champs">
                                <label for="str_jour_0">Jour disponible :</label>
                                <select name="str_jour[]" id="str_jour_0">
                                    <option value="lundi">Lundi</option>
                                    <option value="mardi">Mardi</option>
                                    <option value="mercredi">Mercredi</option>
                                    <option value="jeudi">Jeudi</option>
                                    <option value="vendredi">Vendredi</option>
                                    <option value="samedi">Samedi</option>
                                    <option value="dimanche">Dimanche</option>
                                </select>
                            </div>
                            <div class="disponibilte_champs">
                                <label for="time_debut_0">Heure de début :</label>
                                <input id="time_debut_0" name="time_debut[]" type="time" required>
                            </div>
                            <div class="disponibilte_champs">
                                <label for="time_fin_0">Heure de fin :</label>
                                <input id="time_fin_0" name="time_fin[]" type="time" required>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="ajouter_dispo" class="btn_pt_utilisateur">Nouvelle dispo</button>
                    <button type="submit" class="btn_gd_utilisateur">Ajouter</button>
                </form>
            <?php }
        } ?>
    </div>
</div>

<script src="<?= HOME_URL ?>js/form_dispo.js"></script>

<?php
}
else {
    // Renvoyer à l'accueil avec message erreur;
}
include_once __DIR__ . '/Includes/footer.php';