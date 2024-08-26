<?php

include_once __DIR__ . '/Includes/header.php';

?>

<p>Page pour l'inscription</p>
<form class="space-y-6" action="<?=HOME_URL?>inscription" method="POST">

    <input type="hidden" name="dtm_creation" value="<?php echo date('Y-m-d H:i:s'); ?>">

    <div>
        <label for="str_email" class="block text-sm font-medium leading-6 text-gray-900">Addresse email :</label>
        <div class="mt-2">
          <input id="str_email" name="str_email" type="email" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
    </div>

    <div>
        <label for="str_nom" class="block text-sm font-medium leading-6 text-gray-900">Votre nom :</label>
        <div class="mt-2">
            <input id="str_nom" name="str_nom" type="text" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
    </div>

    <div>
        <label for="str_prenom" class="block text-sm font-medium leading-6 text-gray-900">Votre prénom :</label>
        <div class="mt-2">
            <input id="str_prenom" name="str_prenom" type="text" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
    </div>

    <div>
        <label for="str_pseudo" class="block text-sm font-medium leading-6 text-gray-900">Votre pseudo :</label>
        <div class="mt-2">
            <input id="str_pseudo" name="str_pseudo" type="text" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
    </div>

    <div>
        <label for="dtm_naissance" class="block text-sm font-medium leading-6 text-gray-900">Votre date de naissance :</label>
        <div class="mt-2">
            <input id="dtm_naissance" name="dtm_naissance" type="date" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
    </div>

    <div>
        <label for="str_mdp" class="block text-sm font-medium leading-6 text-gray-900">Votre mot de passe :</label>
        <div class="mt-2">
            <input id="str_mdp" name="str_mdp" type="password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
    </div>

    <div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">S'enregistrer</button>
    </div>
</form>
<?php

include_once __DIR__ . '/Includes/footer.php';