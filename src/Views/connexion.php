<?php

include_once __DIR__ . '/Includes/header.php';

?>

<p>Page de connexion</p>
<form class="space-y-6" action="<?=HOME_URL?>connexion" method="POST">
    <div>
        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Addresse email :</label>
        <div class="mt-2">
          <input id="str_email" name="str_email" type="email" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
    </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="str_mdp" class="block text-sm font-medium leading-6 text-gray-900">Mot de passe :</label>
          <div class="text-sm">
            <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Mot de passe oublié?</a>
          </div>
        </div>
        <div class="mt-2">
          <input id="str_mdp" name="str_mdp" type="password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
      </div>

      <div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Se connecter</button>
      </div>
</form>
<?php

include_once __DIR__ . '/Includes/footer.php';