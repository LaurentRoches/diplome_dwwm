<?php

use src\Repositories\ArticleRepository;

include_once __DIR__ . '/includes/header.php';

$ArticleRepository = ArticleRepository::getInstance($database);
$tab_categorie = $ArticleRepository->getAllCategorie();

?>
<div class="accueil_center">
    <h2>Pour ajouter une catégorie pour article :</h2>
    <a href="<?= HOME_URL ?>admin/categorieArticle/create" class="btn_gd_article">Ajouter</a>

    <h2>Liste des catégories pour article:</h2>
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
                            <td><a href="<?= HOME_URL ?>admin/categorieArticle/update/<?= intval($categorie['id_categorie_article']) ?>"><?= htmlspecialchars($categorie['str_nom'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></a></td>
                            <td><a href="<?= HOME_URL ?>admin/categorieArticle/update/<?= intval($categorie['id_categorie_article']) ?>">Cliquez ici</a></td>
                            <td><a href="<?= HOME_URL ?>admin/categorieArticle/delete/<?= intval($categorie['id_categorie_article']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie pour article ?');"> X </a></td>
                        </tr>
                    <?php }
                }
                else { ?>
                    <p class="erreur_texte">Aucune catégorie pour article enregistrée</p>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php

include_once __DIR__ . '/includes/footer.php';