<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet diplome dwwm</title>
    <script src="https://cdn.tailwindcss.com" defer></script>
</head>
<body>

<div class="flex justify-between items-center h-16 bg-gray-200 p-4">
    <p class="text-xl font-medium">SIMPLON</p>
    <?php
    if(isset($_SESSION['connecte'])){ ?>
        <button onclick="location.href='<?= HOME_URL ?>deconnexion'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disconnect">Deconnexion</button>
    <?php
    } else { ?>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded connect">Connexion</button>
    <?php
    }
    ?>
</div>