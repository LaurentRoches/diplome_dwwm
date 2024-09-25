<?php

use src\Repositories\MessageRepository;
use src\Repositories\UserRepository;

include_once __DIR__ . '/includes/header.php';

$UserRepository = UserRepository::getInstance($database);
$MessageRepository = MessageRepository::getInstance($database);

if(isset($destinataire) && !empty($destinataire) && isset($expediteur) && !empty($expediteur)) { 
    $MessageRepository->marquerCommeLu(intval($destinataire->getIdUser()), intval($expediteur->getIdUser()));
    ?>
    <h2>Conversation entre <?= htmlspecialchars($destinataire->getStrPseudo()) ?> & <?= htmlspecialchars($expediteur->getStrPseudo()) ?></h2>
    <?php
    $conversation = $MessageRepository->getDiscution(intval($destinataire->getIdUser()), intval($expediteur->getIdUser()));

    if(empty($conversation)) { ?>
        <p class="erreur_texte">Aucuns messages trouvés!</p>
    <?php } ?>
    <div class="conversation_centrer">
        <?php 
        foreach($conversation as $message) {
            if($message['expediteur_pseudo'] == $user->getStrPseudo()) { ?>
                <div class="conversation_gch">
                    <p class="conversation_mini_texte">Message envoyé :</p>
                    <p class="conversation_message"><?= htmlspecialchars($message['str_message'],  ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></p>
                    <p class="conversation_mini_texte">écris le <em><?= DateTime::createFromFormat('Y-m-d H:i:s', $message['dtm_envoi'])->format('d-m-Y H:i') ?></em></p>
                    <p class="conversation_mini_texte">par <strong><?= htmlspecialchars($message['expediteur_pseudo'],  ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></strong></p>
                </div>
            <?php }
            else { ?>
                <div class="conversation_dt">
                <p class="conversation_mini_texte">Message reçut :</p>
                    <p class="conversation_message"><?= htmlspecialchars($message['str_message'], ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></p>
                    <p class="conversation_mini_texte">écris le <em><?= DateTime::createFromFormat('Y-m-d H:i:s', $message['dtm_envoi'])->format('d-m-Y H:i') ?></em></p>
                    <p class="conversation_mini_texte">par <strong><?= htmlspecialchars($message['expediteur_pseudo'],  ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?></strong></p>
                </div>
            <?php }
        }
        ?>
        <h3>Envoyer un message à <?= htmlspecialchars($expediteur->getStrPseudo(),  ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?> :</h3>
        <form action="<?= HOME_URL ?>message/<?= htmlspecialchars($destinataire->getStrPseudo(),  ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?>/conversation/<?= htmlspecialchars($expediteur->getStrPseudo(),  ENT_QUOTES | ENT_HTML401, 'UTF-8', false) ?>" method="POST" class="connexion_form">
            <input type="hidden" name="id_expediteur" value="<?= intval($destinataire->getIdUser()) ?>">
            <input type="hidden" name="id_destinataire" value="<?= intval($expediteur->getIdUser()) ?>">
            <label for="str_message">Votre message: <em>(255 caractères maximum)</em></label>
            <textarea name="str_message" id="str_message" maxlength="255"></textarea>
            <button type="submit" class="btn_gd_utilisateur">Envoyer</button>
        </form>
    </div>
<?php }
else {
    // Renvoyer à l'accueil avec message erreur;
}
include_once __DIR__ . '/includes/footer.php';