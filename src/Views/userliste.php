<?php

include_once __DIR__ . '/includes/header.php';

use src\Repositories\GameRepository;
use src\Repositories\UserRepository;
use src\Repositories\ProfilImageRepository;

$UserRepository = UserRepository::getInstance($database);
$ProfilImageRepository = ProfilImageRepository::getInstance($database);
$GameRepository = GameRepository::getInstance($database);

$id_game = isset($_GET['id_game']) ? intval($_GET['id_game']) : null;
$str_pseudo = isset($_GET['str_pseudo']) ? htmlspecialchars($_GET['str_pseudo']) : '';
$bln_mj = isset($_GET['bln_mj']) ? intval($_GET['bln_mj']) : null;

$total_utilisateur = $UserRepository->countAllUser($id_game, $str_pseudo, $bln_mj);
$parPage = 10;
$total_pages = ceil($total_utilisateur/$parPage);

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

if($page < 1 || $page > $total_pages) {
    $page = 1;
}

$liste_user = $UserRepository->getAllUser($id_game, $str_pseudo, $bln_mj, $page, $parPage);
$liste_game = $GameRepository->getAllGame();

?>
<h2 class="accueil_titre_section">Les utilisateurs :</h2>


    <div class="form_bg user_liste_filter">
        <div class="form_post_texte">
            <h3 class="connexion_titre">Filtre de trie</h3>
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
                        <?php
                        if(!empty($liste_game)) {
                            foreach($liste_game as $game) { ?>
                                <option value="<?= intval($game['id_game']) ?>"><?= htmlspecialchars($game['str_nom']) ?></option>
                            <?php }
                        } ?>
                    </select>
                </div>
                <div class="connexion_champs">
                    <label for="str_pseudo" class="">Pseudonyme :</label>
                    <input id="str_pseudo" name="str_pseudo" type="text" required class="">
                </div>
                <div class="connexion_champs">
                    <label for="bln_mj" class="">Maître du Jeu :</label>
                    <select name="bln_mj" id="bln_mj">
                        <option value="">Choisir une option</option>
                        <option value="0">Joueur</option>
                        <option value="1">Maître du Jeu</option>
                    </select>
                </div>
                <button type="submit" class="btn_gd_utilisateur">Trier</button>
            </form>
        </div>
    </div>



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
    <div class="pagination">
        <div class="user_liste_tier">
        <?php if ($page > 1) { ?>
            <a href="?<?= http_build_query($_GET) ?>&page=<?= $page - 1 ?>" class="btn_pt_utilisateur">Page précédente</a>
            <?php }; ?>
        </div>

        <div class="user_liste_tier">
        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
            <span class="pagination-number <?= ($i == $page) ? 'active' : '' ?>">Page <?= $i ?></span>
            <?php }; ?>
        </div>

        <div class="user_liste_tier">
        <?php if ($page < $total_pages) { ?>
            <a href="?<?= http_build_query($_GET) ?>&page=<?= $page + 1 ?>" class="btn_pt_utilisateur">Page suivante</a>
            <?php }; ?>
        </div>
    </div>
</div>



<?php

include_once __DIR__ . '/includes/footer.php';