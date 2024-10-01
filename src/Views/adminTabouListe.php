<?php

use src\Repositories\TabouRepository;

include_once __DIR__ . '/includes/header.php';

$TabouRepository = TabouRepository::getInstance($database);
$tab_tabou = $TabouRepository->getAllTabou();

?>

<div class="accueil_center">
    <h2>Pour ajouter une censure :</h2>
    <a href="<?= HOME_URL ?>admin/tabou/create" class="btn_gd_article">Ajouter</a>

    <h2>Liste des catégories de jeu:</h2>
    <div class="tableau_containeur">
        <table class="accueil_tableau">
            <thead>
                <tr>
                    <th>Mot</th>
                    <th>Mettre à jour</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(!empty($tab_tabou)) {
                    foreach($tab_tabou as $tabou) { ?>
                        <tr>
                            <td><a href="<?= HOME_URL ?>admin/tabou/update/<?= intval($tabou['id_tabou']) ?>"><?= htmlspecialchars($tabou['str_mot'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></a></td>
                            <td><a href="<?= HOME_URL ?>admin/tabou/update/<?= intval($tabou['id_tabou']) ?>">Cliquez ici</a></td>
                            <td><a href="<?= HOME_URL ?>admin/tabou/delete/<?= intval($tabou['id_tabou']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette censure ?');"> X </a></td>
                        </tr>
                    <?php }
                }
                else { ?>
                    <p class="erreur_texte">Aucun mot tabou enregistré</p>
                <?php } ?>

            </tbody>
        </table>
    </div>
</div>

<?php

include_once __DIR__ . '/includes/footer.php';