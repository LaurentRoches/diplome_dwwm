<?php

use src\Repositories\MessageRepository;
use src\Repositories\UserRepository;

include_once __DIR__ . '/includes/header.php';

$UserRepository = UserRepository::getInstance($database);
$MessageRepository = MessageRepository::getInstance($database);

if(isset($destinataire) && !empty($destinataire) && isset($expediteur) && !empty($expediteur)) { ?>
    <h2>Conversation entre <?= htmlspecialchars($destinataire->getStrPseudo()) ?> & <?= htmlspecialchars($expediteur->getStrPseudo()) ?></h2>
    <?php
    $conversation = $MessageRepository->getDiscution(intval($destinataire->getIdUser()), intval($expediteur->getIdUser()));
    if(empty($conversation)) { ?>
        <p class="erreur_texte">Aucuns messages trouvés!</p>
    <?php }
    // Mettre ici le code pour la conversation
}
else {
    // Renvoyer à l'accueil avec message erreur;
}
include_once __DIR__ . '/includes/footer.php';