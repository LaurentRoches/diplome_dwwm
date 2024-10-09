<?php

use src\Repositories\ArticleRepository;

include_once __DIR__ . '/includes/header.php';

$ArticleRepository = ArticleRepository::getInstance($database);
$tab_avis = $ArticleRepository->getAllAvisOfThisArticle(intval($article['id_article']));
$tab_categorie = $ArticleRepository->getAllCategorieOfThisArticle(intval($article['id_article']));

?>

<div class="accueil_centrer">
    <?php
    if(!empty($erreur)){ ?>
    <p class="erreur_texte"> <?= $erreur ?> </p>
    <?php
    }
    if(!empty($succes)){ ?>
    <p class="succes_texte"> <?= $succes ?> </p>
    <?php } ?>
    <h2 class="accueil_titre"><?= htmlspecialchars($article['str_titre'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></h2>
    <?php
    if($tab_categorie) { ?>
        <div class="article_categorie">
            <?php
            foreach($tab_categorie as $categorie) { ?>
                <p><?= htmlspecialchars($categorie["str_nom"], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></p>
            <?php }
            ?>
        </div>
    <?php }
    ?>
    <img src="<?= HOME_URL ?><?= htmlspecialchars($article['str_chemin_img_1'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?>" alt="image principale illustrant l'article du site JDRConnexion" class="article_main_image">
    <h3 class="article_titre_section"><?= htmlspecialchars($article['str_titre_section_1'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></h3>
    <p class="article_paragraphe"><?= htmlspecialchars($article['txt_section_1'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></p>
    <img src="<?= HOME_URL ?><?= htmlspecialchars($article['str_chemin_img_2'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?>" alt="image secondaire illustrant l'article du site JDRConnexion" class="article_main_image">
    <h3 class="article_titre_section"><?= htmlspecialchars($article['str_titre_section_2'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></h3>
    <p class="article_paragraphe"><?= htmlspecialchars($article['txt_section_2'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></p>
    <a href="<?= HOME_URL ?>article" class="btn_pt_article">Retour</a>
    <h2 class="accueil_titre">Commentaires :</h2>
    <?php
    if($tab_avis) {
        foreach($tab_avis as $avis) { ?>
            <div class="article_avis_bloc">
                <p class="article_avis_titre"><?= htmlspecialchars($avis['str_titre'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></p>
                <p class="article_avis_texte"><?= htmlspecialchars($avis['str_avis'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></p>
                <p class="article_avis_auteur">Par <?= htmlspecialchars($avis['str_pseudo'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?>, le <?= isset($avis['dtm_maj']) ? htmlspecialchars($avis['dtm_maj'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) : htmlspecialchars($avis['dtm_creation'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></p>
            </div>
        <?php }
    }
    else{ ?>
        <p class="erreur_texte">Aucun avis enregistré</p>
    <?php }

    if(isset($user)) { ?>
    <p class="article_form">Laissez nous votre avis !</p>
        <form class="connexion_form" action="<?=HOME_URL?>article/<?= intval($article['id_article']) ?>" method="POST">
            <input type="hidden" name="id_user" value="<?= intval($user->getIdUser()) ?>">
            <input type="hidden" name="id_article" value="<?= intval($article['id_article']) ?>">
            <div class="connexion_champs">
                <label for="str_titre" class="">Titre :</label>
                <input id="str_titre" name="str_titre" type="text" required class="">
            </div>
            <div class="connexion_champs">
                <label for="str_avis" class="">Votre avis :</label>
                <input id="str_avis" name="str_avis" type="text" required class="">
            </div>
            <button type="submit" class="btn_gd_article">Envoyer</button>
        </form>
    <?php
    }
    ?>
</div>

<?php

include_once __DIR__ . '/includes/footer.php';