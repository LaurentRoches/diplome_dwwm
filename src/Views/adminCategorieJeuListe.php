<?php

use src\Repositories\GameRepository;

include_once __DIR__ . '/includes/header.php';

$GameRepository = GameRepository::getInstance($database);
$tab_categorie = $GameRepository->getAllCategorie();

?>
<div class="accueil_center">
    <h2>Pour ajouter une catégorie de jeu :</h2>
    <a href="<?= HOME_URL ?>admin/categorieJeu/create" class="btn_gd_article">Ajouter</a>

    <h2>Liste des catégories de jeu:</h2>
    <div class="tableau_containeur">
        <table class="accueil_tableau">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Mettre à jour</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(!empty($tab_categorie)) {
                    foreach($tab_categorie as $categorie) { ?>
                        <tr>
                            <td><a href="<?= HOME_URL ?>admin/categorieJeu/update/<?= intval($categorie['id_categorie_game']) ?>"><?= htmlspecialchars($categorie['str_nom'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></a></td>
                            <td><a href="<?= HOME_URL ?>admin/categorieJeu/update/<?= intval($categorie['id_categorie_game']) ?>">Cliquez ici</a></td>
                            <td><a href="<?= HOME_URL ?>admin/categorieJeu/delete/<?= intval($categorie['id_categorie_game']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie de jeu ?');"> X </a></td>
                        </tr>
                    <?php }
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