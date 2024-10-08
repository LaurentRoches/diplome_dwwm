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
                <img src="<?= HOME_URL ?>img/wh40k_logo.png" alt="Logo du jeu Warhammer 40k Dark Heresy pour le site JDRConnexion">
            </div>
        </div>
    </div>
    <h3 class="accueil_titre_section accueil_gauche">Les derniers articles :</h3>
    <div class="accueil_container_miniatures">
        <?php
        if(!empty($liste_article)) { ?>
            <div style="background-image: url(<?= HOME_URL ?><?= htmlspecialchars($liste_article[0]['str_chemin_img_1'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?>);" class="accueil_miniature_article_gd">
                <div class="accueil_miniature_overlay">
                    <h3><?= htmlspecialchars($liste_article[0]['str_titre'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></h3>
                    <p class="conversation_mini_texte">Ecrit le <?php 
                    if(isset($liste_article[0]['dtm_maj']) && !empty($liste_article[0]['dtm_maj'])) {
                        echo htmlspecialchars($liste_article[0]['dtm_maj'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false);
                    }
                    else {
                        echo htmlspecialchars($liste_article[0]['dtm_creation'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false);
                    }?> par <?= htmlspecialchars($liste_article[0]['str_pseudo'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></p>
                </div>
            </div>
            <div class="accueil_pc_article_droite">
                <div class="accueil_container_miniature_secondaire">
                    <img class="accueil_miniature_secondaire_article" src="<?= HOME_URL ?><?= htmlspecialchars($liste_article[1]['str_chemin_img_1'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?>" alt="miniature de l'article 2 sur le JDR">
                    <p class="accueil_titre_miniature_secondaire"><?= htmlspecialchars($liste_article[1]['str_titre'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></p>
                </div>
                <div class="accueil_container_miniature_secondaire">
                    <img class="accueil_miniature_secondaire_article" src="<?= HOME_URL ?><?= htmlspecialchars($liste_article[2]['str_chemin_img_1'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?>" alt="miniature de l'article 3 sur le JDR">
                    <p class="accueil_titre_miniature_secondaire"><?= htmlspecialchars($liste_article[2]['str_titre'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></p>
                </div>
            </div>
        <?php }
        else { ?>
            <p class="erreur_texte">Aucun article enregistré</p>
        <?php } ?>
    </div>
    <a href="<?= HOME_URL ?>articleliste" class="btn_gd_article accueil_droite">En savoir plus</a>
    <h3 class="accueil_titre_section accueil_gauche">Les utilisateurs :</h3>
    <div class="tableau_containeur">
        <table class="accueil_tableau">
            <thead>
                <tr>
                    <th></th>
                    <th>Pseudo</th>
                    <th>M.J.</th>
                    <th>Recommandé</th>
                    <th>jeux souhaités</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(!empty($liste_user)){
                    foreach($liste_user as $utilisateur) { 
                        if($utilisateur['id_user'] == 2) {
                            continue;
                        }?>
                    <tr>
                        <td><a href="<?= HOME_URL ?>profil/<?= htmlspecialchars($utilisateur['str_pseudo'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?>"><img src="<?= HOME_URL ?><?= htmlspecialchars($utilisateur['str_chemin'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?>" alt="miniature de l'image de profile" class="accueil_miniature_profil"></a></td>
                        <td><a href="<?= HOME_URL ?>profil/<?= htmlspecialchars($utilisateur['str_pseudo'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?>"><?= htmlspecialchars($utilisateur['str_pseudo'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></a></td>
                        <td>
                        <?php if($utilisateur['bln_mj'] == 1) { ?>
                            <img src="<?= HOME_URL ?>img/Icons/valider_icon.png" alt="Est un Maître du Jeu" class="accueil_icon_mj">
                        <?php } else { ?>
                            <img src="<?= HOME_URL ?>img/Icons/croix_icon.png" alt="N'est pas un Maître du Jeu" class="accueil_icon_mj">
                        <?php } ?>
                        </td>
                        <td><?= round(($utilisateur['ratio']*100), 1) ?> %</td>
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
    </div>
    <a href="<?= HOME_URL ?>userliste" class="btn_gd_utilisateur accueil_droite">En voir plus</a>
</div>


<?php

include_once __DIR__ . '/includes/footer.php';