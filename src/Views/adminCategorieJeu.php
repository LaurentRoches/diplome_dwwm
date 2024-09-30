<?php

use src\Repositories\GameRepository;

include_once __DIR__ . '/includes/header.php';

$GameRepository = GameRepository::getInstance($database);
$tab_categorie = $GameRepository->getAllCategorie();

if(isset($categorie)) {
    $id_categorie_game = intval($categorie['id_categorie_game']);
    $str_nom = htmlspecialchars($categorie['str_nom'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false);
}
else {
    $categorie = NULL;
}

?>


<div class="form_bg">
    <div class="form_post_texte">
        <h2 class="connexion_titre"><?= $categorie ? 'Mettre à jour' : 'Ajouter' ?> :</h2>
        <?php
        if($erreur !== '') { ?>
        <p class="erreur_texte"> <?= $erreur ?> </p>
        <?php } ?>
        <form class="connexion_form" action="<?=HOME_URL?>admin/categorieJeu/<?= $categorie ? 'update' : 'create' ?>" method="POST">
            <?php
            if($categorie) { ?>
                <input type="hidden" name="id_categorie_game" value="<?= $id_categorie_game ?>">
            <?php } ?>
            <div class="connexion_champs">
                <label for="str_nom" class="">Nom de la catégorie :</label>
                <input id="str_nom" name="str_nom" type="text" required value="<?= $categorie ? $str_nom : '' ?>">
            </div>
            <button type="submit" class="btn_gd_utilisateur">Enregistrer</button>
        </form>
    </div>
</div>


<?php

include_once __DIR__ . '/includes/footer.php';