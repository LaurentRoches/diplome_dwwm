<?php

use src\Repositories\ArticleRepository;

include_once __DIR__ . '/includes/header.php';

$ArticleRepository = ArticleRepository::getInstance($database);
$tab_article = $ArticleRepository->getAllArticles();

?>

<div class="accueil_center">
    <h2>Pour ajouter un nouvel article :</h2>
    <a href="<?= HOME_URL ?>admin/article/create" class="btn_gd_article">Ajouter</a>

    <h2>Liste des articles enregistrés :</h2>
    <div class="tableau_containeur">
        <table class="accueil_tableau">
            <thead>
                <tr>
                    <th>Image miniature</th>
                    <th>Titre</th>
                    <th>Résumé</th>
                    <th>Catégorie</th>
                    <th>Mettre à jour</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if(!empty($tab_article)){
                    foreach($tab_article as $article) { 
                        $tab_categorie = $ArticleRepository->getAllCategorieOfThisArticle($article['id_article']); ?>
                        <tr>
                            <td><img src="<?= HOME_URL ?><?= $article['str_chemin_img_1'] ?>" alt=""></td>
                            <td><a href="<?= HOME_URL ?>admin/article/update/<?= intval($article['id_article']) ?>"><?= htmlspecialchars($article['str_titre'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></a></td>
                            <td><?= htmlspecialchars($article['str_resume'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></td>
                            <td><?php
                            foreach($tab_categorie as $categorie) { 
                                echo htmlspecialchars($categorie['str_nom'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) . "<br>";
                            }
                            ?></td>
                            <td><a href="<?= HOME_URL ?>admin/article/update/<?= intval($article['id_article']) ?>">Cliquez ici</a></td>
                            <td><a href="<?= HOME_URL ?>admin/article/delete/<?= intval($article['id_article']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');"> X </a></td>
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