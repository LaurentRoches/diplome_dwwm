<?php

include_once __DIR__ . '/includes/header.php';

use src\Repositories\GameRepository;
use src\Repositories\UserRepository;
use src\Repositories\ProfilImageRepository;

$UserRepository = UserRepository::getInstance($database);
$ProfilImageRepository = ProfilImageRepository::getInstance($database);
$GameRepository = GameRepository::getInstance($database);

$id_game = isset($_GET['id_game']) && $_GET['id_game'] !== '' ? intval($_GET['id_game']) : null;
$str_pseudo = isset($_GET['str_pseudo']) ? htmlspecialchars($_GET['str_pseudo'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) : '';
$bln_mj = isset($_GET['bln_mj']) && $_GET['bln_mj'] !== '' ? intval($_GET['bln_mj']) : null;
$str_jour = isset($_GET['str_jour']) ? htmlspecialchars($_GET['str_jour'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) : '';
$time_debut = isset($_GET['time_debut']) ? htmlspecialchars($_GET['time_debut'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) : '';
$time_fin = isset($_GET['time_fin']) ? htmlspecialchars($_GET['time_fin'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) : '';

$total_utilisateur = $UserRepository->countAllUser($id_game, $str_pseudo, $bln_mj, $str_jour, $time_debut, $time_fin);
$parPage = 10;
$total_pages = ceil($total_utilisateur/$parPage);

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

if($page < 1 || $page > $total_pages) {
    $page = 1;
}

$liste_user = $UserRepository->getAllUser($id_game, $str_pseudo, $bln_mj, $str_jour, $time_debut, $time_fin, $page, $parPage);
$liste_game = $GameRepository->getAllGame();

?>
<head>
    <meta name="description" content="Trouvez des joueurs et maîtres de jeu sur JDRConnexion. Explorez la liste des utilisateurs, triez selon vos préférences, vos disponibilités, et formez le groupe parfait pour vos prochaines aventures de Jeu de Rôle.">
</head>
<h2 class="accueil_titre_section">Les utilisateurs :</h2>

    <div class="form_bg user_liste_filter">
        <div class="form_post_texte">
            <h3 class="connexion_titre">Filtre de tri</h3>
            <?php
            if($erreur !== '') { ?>
            <p class="erreur_texte"> <?= $erreur ?> </p>
            <?php } 
            if($succes !== '') { ?>
            <p class="succes_texte"> <?= $succes ?> </p>
            <?php } ?>
            <form class="connexion_form" action="<?=HOME_URL?>userliste" method="GET">
                <div class="connexion_champs">
                    <label for="id_game" class="">Jeu souhaité :</label>
                    <select name="id_game" id="id_game">
                        <option value="">Choisir un jeu</option>
                        <?php
                        if(!empty($liste_game)) {
                            foreach($liste_game as $game) { ?>
                                <option value="<?= intval($game['id_game']) ?>"><?= htmlspecialchars($game['str_nom'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></option>
                            <?php }
                        } ?>
                    </select>
                </div>
                <div class="connexion_champs">
                    <label for="str_pseudo" class="">Pseudonyme :</label>
                    <input id="str_pseudo" name="str_pseudo" type="text" class="">
                </div>
                <div class="connexion_champs">
                    <label for="bln_mj" class="">Maître du Jeu :</label>
                    <select name="bln_mj" id="bln_mj">
                        <option value="">Choisir une option</option>
                        <option value="0">Joueur</option>
                        <option value="1">Maître du Jeu</option>
                    </select>
                </div>
                <div class="connexion_champs">
                    <label for="str_jour"> Jour disponible :</label>
                    <select name="str_jour" id="str_jour">
                        <option value="">Choisir un jour</option>
                        <option value="lundi">Lundi</option>
                        <option value="mardi">Mardi</option>
                        <option value="mercredi">Mercredi</option>
                        <option value="jeudi">Jeudi</option>
                        <option value="vendredi">Vendredi</option>
                        <option value="samedi">Samedi</option>
                        <option value="dimanche">Dimanche</option>
                    </select>
                </div>
                <div class="connexion_champs max_haut">
                    <label for="time_debut">Heure de début :</label>
                    <input id="time_debut" name="time_debut" type="time">
                </div>
                <div class="connexion_champs max_haut">
                    <label for="time_fin">Heure de fin :</label>
                    <input id="time_fin" name="time_fin" type="time">
                </div>
                <button type="submit" class="btn_gd_utilisateur">Trier</button>
            </form>
        </div>
    </div>


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
                    foreach($liste_user as $utilisateur) { ?>
                    <tr>
                        <td><a href="<?= HOME_URL ?>profil/<?= $utilisateur['str_pseudo'] ?>"><img src="<?= HOME_URL ?><?= $utilisateur['str_chemin'] ?>" alt="miniature de l'image de profile" class="accueil_miniature_profil"></a></td>
                        <td><a href="<?= HOME_URL ?>profil/<?= $utilisateur['str_pseudo'] ?>"><?= $utilisateur['str_pseudo'] ?></a></td>
                        <td>
                        <?php if($utilisateur['bln_mj'] == 1) { ?>
                            <img src="<?= HOME_URL ?>img/Icons/valider_icon.png" alt="Validé" class="accueil_icon_mj">
                        <?php } else { ?>
                            <img src="<?= HOME_URL ?>img/Icons/croix_icon.png" alt="Non validé" class="accueil_icon_mj">
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
    <div class="pagination">
        <div class="user_liste_tier">
        <?php if ($page > 1) { ?>
            <a href="?<?= http_build_query($_GET) ?>&page=<?= $page - 1 ?>" class="btn_pt_utilisateur">Précédente</a>
            <?php }; ?>
        </div>

        <div class="user_liste_tier">
        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
            <span class="pagination-number <?= ($i == $page) ? 'active' : '' ?>">Page <?= $i ?></span>
            <?php }; ?>
        </div>

        <div class="user_liste_tier">
        <?php if ($page < $total_pages) { ?>
            <a href="?<?= http_build_query($_GET) ?>&page=<?= $page + 1 ?>" class="btn_pt_utilisateur">Suivante</a>
            <?php }; ?>
        </div>
    </div>
</div>



<?php

include_once __DIR__ . '/includes/footer.php';