<?php

include_once __DIR__ . '/Includes/header.php';

use src\Models\Database;
use src\Repositories\UserRepository;
use src\Repositories\ProfilImageRepository;

$erreur = isset($_SESSION['erreur']) ? $_SESSION['erreur'] : '';
$_SESSION['erreur'] = '';
$succes = isset($_SESSION['succes']) ? $_SESSION['succes'] : '';
$_SESSION['succes'] = '';

$database = new Database;
$UserRepository = UserRepository::getInstance($database);
$ProfilImageRepository = ProfilImageRepository::getInstance($database);

$user_liste = $UserRepository->getAllUser();
$user = unserialize($_SESSION['user']);
$role = (int)$user->getIdRole();
$id_image = (int)$user->getIdProfilImage();
$image = $ProfilImageRepository->getThisImage($id_image);

?>

<h2>Page de profil</h2>
<div>
    <img src="/<?= $image->getStrChemin() ?>" alt="Image de profil de l'utilisateur">
    <div>Bonjour <?= htmlspecialchars($user->getStrNom(), ENT_QUOTES, 'UTF-8') ?> <?= htmlspecialchars($user->getStrPrenom(), ENT_QUOTES, 'UTF-8') ?></div>
</div>
<p> <?= $erreur ?> </p>
<p> <?= $succes ?> </p>
<?php
foreach($user_liste as $utilisateur) { ?>
    <p><?= htmlspecialchars($utilisateur['str_nom'], ENT_QUOTES, 'UTF-8') ?></p>
<?php
}
?>


<?php

include_once __DIR__ . '/Includes/footer.php';