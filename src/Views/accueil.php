<?php

include_once __DIR__ . '/Includes/header.php';

$erreur = isset($_GET['erreur']) ? $_GET['erreur'] : '';

?>
<h1>C'est la page d'accueil !!!</h1>

<p> <?= $erreur ?> </p>

<?php

include_once __DIR__ . '/Includes/footer.php';