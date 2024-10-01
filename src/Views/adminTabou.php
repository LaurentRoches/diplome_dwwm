<?php

use src\Repositories\TabouRepository;

include_once __DIR__ . '/includes/header.php';

$TabouRepository = TabouRepository::getInstance($database);
$tab_tabou = $TabouRepository->getAllTabou();

if(isset($tabou)) {
    $id_tabou = intval($tabou['id_tabou']);
    $str_mot = htmlspecialchars($tabou['str_mot'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false);
}
else {
    $tabou = NULL;
}

?>


<div class="form_bg">
    <div class="form_post_texte">
        <h2 class="connexion_titre"><?= $tabou ? 'Mettre à jour' : 'Ajouter' ?> :</h2>
        <?php
        if($erreur !== '') { ?>
        <p class="erreur_texte"> <?= $erreur ?> </p>
        <?php } ?>
        <form class="connexion_form" action="<?=HOME_URL?>admin/tabou/<?= $tabou ? 'update' : 'create' ?>" method="POST">
            <?php
            if($tabou) { ?>
                <input type="hidden" name="id_tabou" value="<?= $id_tabou ?>">
            <?php } ?>
            <div class="connexion_champs">
                <label for="str_mot" class="">Quel mot censuré :</label>
                <input id="str_mot" name="str_mot" type="text" required value="<?= $tabou ? $str_mot : '' ?>">
            </div>
            <button type="submit" class="btn_gd_utilisateur">Enregistrer</button>
        </form>
    </div>
</div>


<?php

include_once __DIR__ . '/includes/footer.php';