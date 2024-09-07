<?php

use src\Models\Database;
use src\Repositories\ArticleRepository;
use src\Repositories\UserRepository;

include_once __DIR__ . '/Includes/header.php';

$erreur = isset($_SESSION['erreur']) ? $_SESSION['erreur'] : '';
$_SESSION['erreur'] = '';
$succes = isset($_SESSION['succes']) ? $_SESSION['succes'] : '';
$_SESSION['succes'] = '';

$database = new Database();
$UserRepository = UserRepository::getInstance($database);
$ArticleRepository = ArticleRepository::getInstance($database);

$liste_user = $UserRepository->getAllUser();
$liste_article = $ArticleRepository->getAllArticles();
$limiteur = 0;

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
                <h3 class="accueil_titre_section">Grâce à [Nom du site], vous pouvez facilement entrer en contact avec des joueurs partageant vos goûts et votre disponibilité.</h3>
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
    <h3 class="accueil_titre_section accueil_gauche">Les derniers articles :</h3>
    <div>
        <?php
        if(!empty($liste_article)) { ?>
            <div style="background-image: url(<?= $liste_article[0]['str_chemin_img_1'] ?>);" class="accueil_miniature_article_gd">
                <div class="accueil_miniature_overlay">
                    <h3><?= $liste_article[0]['str_titre'] ?></h3>
                    <p>Ecrit le <?php 
                    if(isset($liste_article[0]['dtm_maj']) && !empty($liste_article[0]['dtm_maj'])) {
                        echo $liste_article[0]['dtm_maj'];
                    }
                    else {
                        echo $liste_article[0]['dtm_creation'];
                    }?> par <?= $liste_article[0]['str_pseudo'] ?></p>
                </div>
            </div>
            <div>
                <div>
                    <img src="" alt="">
                    <p></p>
                </div>
                <div>
                    <img src="" alt="">
                    <p></p>
                </div>
            </div>
        <?php }
        else { ?>
            <p class="erreur_texte">Aucun article enregistré</p>
        <?php } ?>
    </div>
    <h3 class="accueil_titre_section accueil_gauche">Les utilisateurs :</h3>
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Pseudo</th>
                <th>M.J.</th>
                <th>j'aime</th>
                <th>non aimé</th>
                <th>jeux souhaités</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($liste_user as $utilisateur) {
                if($limiteur < 3) { ?>
                <tr>
                    <td><a href="<?= HOME_URL ?>profil/<?= $utilisateur['str_pseudo'] ?>"><img src="" alt="" class="accueil_miniature_profil"></a></td>
                    <td><a href="<?= HOME_URL ?>profil/<?= $utilisateur['str_pseudo'] ?>"><?= $utilisateur['str_pseudo'] ?></a></td>
                    <td>
                    <?php if($utilisateur['bln_mj'] == 1) { ?>
                        <img src="<?= HOME_URL ?>img/icons/valider_icon.png" alt="Validé">
                    <?php } else { ?>
                        <img src="<?= HOME_URL ?>img/icons/croix_icon.jpg" alt="Non validé">
                    <?php } ?>
                    </td>
                    <td><?= $utilisateur['aime'] ?></td>
                    <td><?= ($utilisateur['total_avis'] - $utilisateur['aime'])?></td>
                </tr>
            <?php 
                $limiteur ++;
                }
            } ?>
        </tbody>
    </table>
</div>


<?php

include_once __DIR__ . '/Includes/footer.php';