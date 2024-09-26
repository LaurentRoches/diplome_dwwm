<?php

include_once __DIR__ . '/includes/header.php';

?>
<head>
    <meta name="robots" content="noindex">
</head>
<div class="main_404">
    <h1 class="titre_404">Page introuvable...</h1>
    <img class="image_404" src="<?= HOME_URL ?>img/page404.jpg" alt="Image pour la page 404 de JDRConnexion">
    <button class="btn_gd_article" onclick="location.href='<?=HOME_URL?>'">Accueil</button>
</div>
<?php

include_once __DIR__ . '/includes/footer.php';