<?php

include_once __DIR__ . '/Includes/header.php';

$erreur = isset($_SESSION['erreur']) ? $_SESSION['erreur'] : '';
$_SESSION['erreur'] = '';
$succes = isset($_SESSION['succes']) ? $_SESSION['succes'] : '';
$_SESSION['succes'] = '';

?>
<h2>C'est la page d'accueil !!!</h2>

<p> <?= $erreur ?> </p>
<p> <?= $succes ?> </p>

<div class="banner_accueil">
    <p class="texte_banner">Message d'accueil de la banner</p>
</div>


<?php

include_once __DIR__ . '/Includes/footer.php';