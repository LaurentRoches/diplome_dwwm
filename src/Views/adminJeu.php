<?php

use src\Repositories\GameRepository;

include_once __DIR__ . '/includes/header.php';

$GameRepository = GameRepository::getInstance($database);
$tab_categorie = $GameRepository->getAllCategorie();

if(isset($game)) {
    $id_game = intval($game['id_game']);
    $str_nom = htmlspecialchars($game['str_nom']);
    $str_resume = htmlspecialchars($game['str_resume']);
    $txt_description = htmlspecialchars($game['txt_description']);
    $str_categorie = htmlspecialchars($game['categorie']);
}
else {
    $game = NULL;
    $str_categorie = '';
}

?>

<div class="form_bg">
    <div class="form_post_texte">
        <h2 class="connexion_titre"><?= $game ? 'Mettre à jour' : 'Ajouter' ?> :</h2>
        <?php
        if($erreur !== '') { ?>
        <p class="erreur_texte"> <?= $erreur ?> </p>
        <?php } ?>
        <form class="connexion_form" action="<?=HOME_URL?>admin/jeu/<?= $game ? 'update' : 'create' ?>" method="POST">
            <?php
            if($game) { ?>
                <input type="hidden" name="dtm_maj" value="<?= date('Y-m-d H:i:s'); ?>">
                <input type="hidden" name="id_game" value="<?= $id_game ?>">
            <?php } ?>
            <div class="connexion_champs">
                <label for="str_nom" class="">Titre du jeu :</label>
                <input id="str_nom" name="str_nom" type="text" required value="<?= $game ? $str_nom : '' ?>">
            </div>
            <div class="connexion_champs">
                <label for="str_resume" class="">Résumé du jeu :</label>
                <input id="str_resume" name="str_resume" type="text" required value="<?= $game ? $str_resume : '' ?>">
            </div>
            <div class="connexion_champs">
                <label for="txt_description" class="">Description du jeu :</label>
                <textarea id="txt_description" name="txt_description" maxlength="500" required ><?= $game ? $txt_description : '' ?></textarea>
            </div>
            <div class="connexion_champs">
                <label for="id_categorie_game"> Catégorie du jeu :</label>
                <select name="id_categorie_game" id="id_categorie_game">
                    <option value="">Choisissez une catégorie</option>
                    <?php
                    if(!empty($tab_categorie)) {
                        foreach($tab_categorie as $categorie) { ?>
                            <option value="<?= intval($categorie['id_categorie_game']) ?>" <?= ($categorie['str_nom'] == $str_categorie) ? 'selected' : '' ?>><?= htmlspecialchars($categorie['str_nom']) ?></option>
                        <?php } 
                    }?>
                </select>
            </div>
            <button type="submit" class="btn_gd_utilisateur">Enregistrer</button>
        </form>
    </div>
</div>


<?php

include_once __DIR__ . '/includes/footer.php';