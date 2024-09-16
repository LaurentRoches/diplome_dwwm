<?php

use src\Repositories\ArticleRepository;
use src\Repositories\GameRepository;
use src\Repositories\UserRepository;

include_once __DIR__ . '/includes/header.php';

$UserRepository = UserRepository::getInstance($database);
$ArticleRepository = ArticleRepository::getInstance($database);
$GameRepository = GameRepository::getInstance($database);

$liste_user = $UserRepository->getAllUserLimit3();
$liste_article = $ArticleRepository->getAllArticlesLimit3();

?>
<head>
    <meta name="description" content="JDRConnexion, le site idéal pour trouver des partenaires et former un groupe pour vos parties de Jeu de Rôle. Rejoignez-nous pour vivre des aventures épiques!">
</head>
<div class="accueil_centrer">
    <?php
    if(!empty($erreur)){ ?>
    <p class="erreur_texte"> <?= $erreur ?> </p>
    <?php
    }
    if(!empty($succes)){ ?>
    <p class="succes_texte"> <?= $succes ?> </p>
    <?php } ?>
    <div class="banner_accueil">
        <p class="texte_banner">Le site de référence pour trouver tes prochains partenaires de jeu!</p>
    </div>
    <div class="accueil_presentation">
        <h2 class="accueil_titre">Bienvenue sur JDRConnexion - Le Portail des Aventuriers</h2>
        <p>Vous êtes un passionné de jeux de rôle, toujours à la recherche de nouvelles aventures et de compagnons pour partager des quêtes épiques? JDRConnexion est là pour vous! Notre plateforme est spécialement conçue pour vous aider à trouver d'autres joueurs qui partagent vos envies, vos horaires, et votre passion pour l'univers du jeu de rôle. Que vous soyez un maître du jeu chevronné ou un novice en quête de votre première campagne, vous trouverez ici une communauté accueillante prête à explorer ensemble les contrées les plus fantastiques.</p>
        <div class="accueil_presentation_2">
            <img src="<?= HOME_URL ?>img/accueil_social.jpg" alt="Image symbolisant la sociabilité du site JDRConnexion" class="accueil_image_social">
            <div class="accueil_texte_social">
                <h3 class="accueil_titre_section">Grâce à JDRConnexion, vous pouvez facilement entrer en contact avec des joueurs partageant vos goûts et votre disponibilité.</h3>
                <p>Que vous préfériez les aventures médiévales fantastiques, les explorations spatiales, ou les intrigues mystérieuses, notre système de recherche vous permet de trouver des partenaires de jeu en quelques clics. Plus besoin de chercher pendant des heures, le groupe parfait est à portée de main.
                Plongez dans l'univers du jeu de rôle</p>
            </div>
        </div>
        <div class="accueil_presentation_2">
            <p>En plus de vous connecter avec d'autres joueurs, JDRConnexion vous propose également une sélection d'articles dédiés à l'univers des jeux de rôle. Des conseils pour les maîtres de jeu, des astuces pour les joueurs, des analyses des meilleurs systèmes de jeu, et des idées pour enrichir vos campagnes vous attendent sur notre blog. Que vous cherchiez à perfectionner vos techniques ou à découvrir de nouvelles idées, notre contenu est là pour nourrir votre imagination.</p>
            <div class="accueil_liste_jeu">
                <img src="<?= HOME_URL ?>img/cyberpunk_logo.png" alt="Logo du jeu Cyberpunk77 pour le site JDRConnexion" class="accueil_miniature_jeu">
                <img src="<?= HOME_URL ?>img/dnd_logo.png" alt="Logo du jeu Donjon & Dragon pour le site JDRConnexion">
                <img src="<?= HOME_URL ?>img/wh40k_logo" alt="Logo du jeu Warhammer 40k Dark Heresy pour le site JDRConnexion">
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
                    <img src="<?= HOME_URL ?>" alt="">
                    <p></p>
                </div>
                <div>
                    <img src="<?= HOME_URL ?>" alt="">
                    <p></p>
                </div>
            </div>
        <?php }
        else { ?>
            <p class="erreur_texte">Aucun article enregistré</p>
        <?php } ?>
    </div>
    <a href="<?= HOME_URL ?>articleliste" class="btn_gd_article accueil_droite">En savoir plus</a>
    <h3 class="accueil_titre_section accueil_gauche">Les utilisateurs :</h3>
    <table class="accueil_tableau">
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
            if(!empty($liste_user)){
                foreach($liste_user as $utilisateur) { ?>
                <tr>
                    <td><a href="<?= HOME_URL ?>profil/<?= $utilisateur['str_pseudo'] ?>"><img src="<?= HOME_URL ?><?= $utilisateur['str_chemin'] ?>" alt="miniature de l'image de profile" class="accueil_miniature_profil"></a></td>
                    <td><a href="<?= HOME_URL ?>profil/<?= $utilisateur['str_pseudo'] ?>"><?= $utilisateur['str_pseudo'] ?></a></td>
                    <td>
                    <?php if($utilisateur['bln_mj'] == 1) { ?>
                        <img src="<?= HOME_URL ?>img/icons/valider_icon.png" alt="Validé" class="accueil_icon_mj">
                    <?php } else { ?>
                        <img src="<?= HOME_URL ?>img/icons/croix_icon.png" alt="Non validé" class="accueil_icon_mj">
                    <?php } ?>
                    </td>
                    <td><?= $utilisateur['aime'] ?></td>
                    <td><?= ($utilisateur['total_avis'] - $utilisateur['aime'])?></td>
                    <td>
                        <?php
                        $tab_game = $GameRepository->getAllGameVoulu($utilisateur['id_user']);
                        $int_game_voulu = count($tab_game);
                        if($int_game_voulu === 0) {
                            echo "Non renseigné.";
                        }
                        elseif($int_game_voulu >= 2) {
                            echo "Plusieurs jeux souhaités.";
                        }
                        else {
                            echo $tab_game[0]['str_nom'];
                        }
                        ?>
                    </td>
                </tr>
                <?php
                } 
            }
            else { ?>
                <p class="erreur_texte">Aucun Utilisateur enregistré</p>
            <?php } ?>
        </tbody>
    </table>
    <a href="<?= HOME_URL ?>userliste" class="btn_gd_utilisateur accueil_droite">En voir plus</a>
</div>


<?php

include_once __DIR__ . '/includes/footer.php';