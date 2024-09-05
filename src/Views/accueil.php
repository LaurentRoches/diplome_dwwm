<?php

include_once __DIR__ . '/Includes/header.php';

$erreur = isset($_SESSION['erreur']) ? $_SESSION['erreur'] : '';
$_SESSION['erreur'] = '';
$succes = isset($_SESSION['succes']) ? $_SESSION['succes'] : '';
$_SESSION['succes'] = '';

?>
<div class="accueil_centrer">
    <p class="erreur_texte"> <?= $erreur ?> </p>
    <p class="succes_texte"> <?= $succes ?> </p>
    <div class="banner_accueil">
        <p class="texte_banner">Le site de référence pour trouver tes prochains partenaires de jeu!</p>
    </div>
    <div class="accueil_presentation">
        <h2 class="accueil_titre">Bienvenue sur [Nom du site] - Le Portail des Aventuriers</h2>
        <p>Vous êtes un passionné de jeux de rôle, toujours à la recherche de nouvelles aventures et de compagnons pour partager des quêtes épiques? [Nom du site] est là pour vous! Notre plateforme est spécialement conçue pour vous aider à trouver d'autres joueurs qui partagent vos envies, vos horaires, et votre passion pour l'univers du jeu de rôle. Que vous soyez un maître du jeu chevronné ou un novice en quête de votre première campagne, vous trouverez ici une communauté accueillante prête à explorer ensemble les contrées les plus fantastiques.</p>
        <div class="accueil_presentation_2">
            <img src="img/accueil_social.jpg" alt="Image symbolisant la sociabilité du site [Nom du site]" class="accueil_image_social">
            <div class="accueil_texte_social">
                <h3>Grâce à [Nom du site], vous pouvez facilement entrer en contact avec des joueurs partageant vos goûts et votre disponibilité.</h3>
                <p>Que vous préfériez les aventures médiévales fantastiques, les explorations spatiales, ou les intrigues mystérieuses, notre système de recherche vous permet de trouver des partenaires de jeu en quelques clics. Plus besoin de chercher pendant des heures, le groupe parfait est à portée de main.
                Plongez dans l'univers du jeu de rôle</p>
            </div>
        </div>
        <div class="accueil_presentation_2">
            <p>En plus de vous connecter avec d'autres joueurs, [Nom du site] vous propose également une sélection d'articles dédiés à l'univers des jeux de rôle. Des conseils pour les maîtres de jeu, des astuces pour les joueurs, des analyses des meilleurs systèmes de jeu, et des idées pour enrichir vos campagnes vous attendent sur notre blog. Que vous cherchiez à perfectionner vos techniques ou à découvrir de nouvelles idées, notre contenu est là pour nourrir votre imagination.</p>
            <div class="accueil_liste_jeu">
                <img src="img/cyberpunk_logo.png" alt="Logo du jeu Cyberpunk77 pour le site [Nom du site]" class="accueil_miniature_jeu">
                <img src="img/dnd_logo.png" alt="Logo du jeu Donjon & Dragon pour le site [Nom du site]">
                <img src="img/wh40k_logo" alt="Logo du jeu Warhammer 40k Dark Heresy pour le site [Nom du site]">
            </div>
        </div>
    </div>
    
</div>


<?php

include_once __DIR__ . '/Includes/footer.php';