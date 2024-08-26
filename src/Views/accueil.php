<?php

include_once __DIR__ . '/Includes/header.php';

$erreur = isset($_SESSION['erreur']) ? $_SESSION['erreur'] : '';
$_SESSION['erreur'] = '';
$succes = isset($_SESSION['succes']) ? $_SESSION['succes'] : '';
$_SESSION['succes'] = '';

?>
<h1>C'est la page d'accueil !!!</h1>

<p> <?= $erreur ?> </p>
<p> <?= $succes ?> </p>

<?php

include_once __DIR__ . '/Includes/footer.php';