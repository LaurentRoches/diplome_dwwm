<?php

use src\Repositories\ArticleRepository;

include_once __DIR__ . '/includes/header.php';

$ArticleRepository = ArticleRepository::getInstance($database);

$liste_article_recent = $ArticleRepository->getAllArticlesLimit3();
$tab_article = $ArticleRepository->getAllArticles();

?>
<head>
    <meta name="description" content="Explore les articles de JDRConnexion pour découvrir des conseils, astuces et actualités sur le jeu de rôle. Améliore ta pratique du JDR et reste informé des dernières nouveautés.">
</head>
<div class="accueil_centrer">
    <h2 class="accueil_titre_section accueil_gauche">Les derniers articles :</h2>
    <div class="accueil_container_miniatures">
        <?php
        if(!empty($liste_article_recent)) { ?>
            <a href="<?= HOME_URL ?>article/<?= intval($liste_article_recent[0]['id_article']) ?>" style="background-image: url(<?= HOME_URL ?><?= htmlspecialchars($liste_article_recent[0]['str_chemin_img_1'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?>);" class="accueil_miniature_article_gd">
                <div class="accueil_miniature_overlay">
                    <h3><?= htmlspecialchars($liste_article_recent[0]['str_titre'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></h3>
                    <p class="conversation_mini_texte">Ecrit le <?php 
                    if(isset($liste_article_recent[0]['dtm_maj']) && !empty($liste_article_recent[0]['dtm_maj'])) {
                        echo htmlspecialchars($liste_article_recent[0]['dtm_maj'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false);
                    }
                    else {
                        echo htmlspecialchars($liste_article_recent[0]['dtm_creation'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false);
                    }?> par <?= htmlspecialchars($liste_article_recent[0]['str_pseudo'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></p>
                </div>
            </a>
            <div class="accueil_pc_article_droite">
                <a href="<?= HOME_URL ?>article/<?= intval($liste_article_recent[1]['id_article']) ?>" class="accueil_container_miniature_secondaire">
                    <img class="accueil_miniature_secondaire_article" src="<?= HOME_URL ?><?= htmlspecialchars($liste_article_recent[1]['str_chemin_img_1'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?>" alt="miniature de l'article 2 sur le JDR">
                    <p class="accueil_titre_miniature_secondaire"><?= htmlspecialchars($liste_article_recent[1]['str_titre'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></p>
                </a>
                <a href="<?= HOME_URL ?>article/<?= intval($liste_article_recent[2]['id_article']) ?>" class="accueil_container_miniature_secondaire">
                    <img class="accueil_miniature_secondaire_article" src="<?= HOME_URL ?><?= htmlspecialchars($liste_article_recent[2]['str_chemin_img_1'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?>" alt="miniature de l'article 3 sur le JDR">
                    <p class="accueil_titre_miniature_secondaire"><?= htmlspecialchars($liste_article_recent[2]['str_titre'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></p>
                </a>
            </div>
        <?php }
        else { ?>
            <p class="erreur_texte">Aucun article enregistré</p>
        <?php } ?>
    </div>
    <h2 class="accueil_titre_section accueil_gauche">En savoir plus :</h2>
    <div class="liste_vignette_article">
        <?php
        if(empty($tab_article)) { ?>
            <p class="erreur_texte">Aucun article supplémentaire enregistré</p>
        <?php }
        foreach($tab_article as $article) { ?>
            <a href="<?= HOME_URL ?>article/<?= intval($article['id_article']) ?>" class="vignette_article">
                <img class="accueil_miniature_secondaire_article" src="<?= HOME_URL ?><?= htmlspecialchars($article['str_chemin_img_1'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?>" alt="miniature de l'article 3 sur le JDR">
                <p class="accueil_titre_miniature_secondaire"><?= htmlspecialchars($article['str_titre'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></p>
            </a>
        <?php } ?>
    </div>
</div>


<?php

include_once __DIR__ . '/includes/footer.php';