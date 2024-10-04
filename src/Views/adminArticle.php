<?php

use src\Repositories\ArticleRepository;

include_once __DIR__ . '/includes/header.php';

$ArticleRepository = ArticleRepository::getInstance($database);
$tab_categorie = $ArticleRepository->getAllCategorie();

if(isset($article)) {
    $id_article = intval($article['id_article']);
    $str_titre = htmlspecialchars($article['str_titre'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false);
    $str_resume = htmlspecialchars($article['str_resume'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false);
    $str_chemin_img_1 = htmlspecialchars($article['str_chemin_img_1'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false);
    $str_titre_section_1 = htmlspecialchars($article['str_titre_section_1'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false);
    $txt_section_1 = htmlspecialchars($article['txt_section_1'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false);
    $str_chemin_img_2 = htmlspecialchars($article['str_chemin_img_2'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false);
    $str_titre_section_2 = htmlspecialchars($article['str_titre_section_2'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false);
    $txt_section_2 = htmlspecialchars($article['txt_section_2'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false);
    $str_pseudo = htmlspecialchars($article['str_pseudo'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false);

    $tab_categorie_article = $ArticleRepository->getAllCategorieOfThisArticle($id_article);
}
else {
    $article = NULL;
}

?>

<div class="form_bg">
    <div class="form_post_texte">
        <h2 class="connexion_titre"><?= $article ? 'Mettre à jour' : 'Ajouter' ?> :</h2>
        <?php
        if($erreur !== '') { ?>
        <p class="erreur_texte"> <?= $erreur ?> </p>
        <?php } ?>
        <form class="connexion_form" action="<?=HOME_URL?>admin/article/<?= $article ? 'update' : 'create' ?>" method="POST">
            <?php
            if($article) { ?>
                <input type="hidden" name="dtm_maj" value="<?= date('Y-m-d H:i:s'); ?>">
                <input type="hidden" name="id_article" value="<?= $id_article ?>">
            <?php } ?>
                <input type="hidden" name="id_user" value="<?= intval($user->getIdUser()) ?>">
            <div class="connexion_champs">
                <label for="str_titre" class="">Titre de l'article :</label>
                <input id="str_titre" name="str_titre" type="text" required value="<?= $article ? $str_titre : '' ?>">
            </div>
            <div class="connexion_champs">
                <label for="str_resume" class="">Résumé de l'article :</label>
                <input id="str_resume" name="str_resume" type="text" required value="<?= $article ? $str_resume : '' ?>">
            </div>
            <div class="connexion_champs">
                <label for="str_chemin_img_1" class="">Première image :</label>
                <textarea id="str_chemin_img_1" name="str_chemin_img_1" maxlength="500" required ><?= $article ? $str_chemin_img_1 : '' ?></textarea>
            </div>
            <div class="connexion_champs">
                <label for="str_titre_section_1" class="">Titre de la première section :</label>
                <input id="str_titre_section_1" name="str_titre_section_1" type="text" required value="<?= $article ? $str_titre_section_1 : '' ?>">
            </div>
            <div class="connexion_champs">
                <label for="txt_section_1" class="">Texte de la première section :</label>
                <textarea id="txt_section_1" name="txt_section_1" required><?= $article ? $txt_section_1 : '' ?></textarea>
            </div>
            <div class="connexion_champs">
                <label for="str_chemin_img_2" class="">Deuxième image :</label>
                <textarea id="str_chemin_img_2" name="str_chemin_img_2" maxlength="500" required ><?= $article ? $str_chemin_img_2 : '' ?></textarea>
            </div>
            <div class="connexion_champs">
                <label for="str_titre_section_2" class="">Titre de la deuxième section :</label>
                <input id="str_titre_section_2" name="str_titre_section_2" type="text" required value="<?= $article ? $str_titre_section_2 : '' ?>">
            </div>
            <div class="connexion_champs">
                <label for="txt_section_2" class="">Texte de la deuxième section :</label>
                <textarea id="txt_section_2" name="txt_section_2" required><?= $article ? $txt_section_2 : '' ?></textarea>
            </div>
            <div class="connexion_champs">
                <label for="id_categorie_article">Catégorie de l'article :</label>
                <select name="id_categorie_article[]" id="id_categorie_article" multiple>
                    <option value="">Choisissez une ou plusieurs catégories</option>
                    <?php
                    if(!empty($tab_categorie)) {
                        foreach($tab_categorie as $categorie) { 
                            $selected = '';
                            if (!empty($tab_categorie_article)) {
                                foreach ($tab_categorie_article as $categorie_article) {
                                    if ($categorie_article['id_categorie_article'] == $categorie['id_categorie_article']) {
                                        $selected = 'selected';
                                        break;
                                    }
                                }
                            } ?>
                            <option value="<?= intval($categorie['id_categorie_article']) ?>" <?= $selected ?>>
                                <?= htmlspecialchars($categorie['str_nom'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?>
                            </option>
                        <?php }
                    } ?>
                </select>
            </div>
            <button type="submit" class="btn_gd_article">Enregistrer</button>
        </form>
    </div>
</div>

<?php

include_once __DIR__ . '/includes/footer.php';