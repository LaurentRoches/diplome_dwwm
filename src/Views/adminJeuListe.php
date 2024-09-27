<?php

use src\Repositories\GameRepository;

include_once __DIR__ . '/includes/header.php';

$GameRepository = GameRepository::getInstance($database);
$tab_game = $GameRepository->getAllGame();

?>
<div class="accueil_center">
    <h2 class="message_titre">Pour ajouter un nouveau jeu :</h2>
    <a href="<?= HOME_URL ?>admin/jeu/create" class="btn_gd_article">Ajouter</a>

    <h2>Liste des jeux enregistrés :</h2>
    <div class="tableau_containeur">
        <table class="accueil_tableau">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Résumé</th>
                    <th>Catégorie</th>
                    <th>Mettre à jour</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if(!empty($tab_game)){
                    foreach($tab_game as $game) { ?>
                        <tr>
                            <td><a href="<?= HOME_URL ?>admin/jeu/update/<?= intval($game['id_game']) ?>"><?= htmlspecialchars($game['str_nom'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></a></td>
                            <td><?= htmlspecialchars($game['str_resume'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></td>
                            <td><?= htmlspecialchars($game['categorie'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></td>
                            <td><a href="<?= HOME_URL ?>admin/jeu/update/<?= intval($game['id_game']) ?>">Cliquez ici</a></td>
                            <td><a href="<?= HOME_URL ?>admin/jeu/delete/<?= intval($game['id_game']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce jeu ?');"> X </a></td>
                        </tr>
                    <?php
                    } 
                }
                else { ?>
                    <p class="erreur_texte">Aucun jeu enregistré</p>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php

include_once __DIR__ . '/includes/footer.php';