<?php

spl_autoload_register('chargerClasses');

function chargerClasses($classe)
{
  $classe = str_replace('src', '', $classe);
  $classe = str_replace('\\', '/', $classe);
  $fichier = $classe . '.php';
  try {
    if(file_exists(__DIR__ . $fichier)){
      require_once __DIR__ . $fichier;
    }
  } catch (Error $error) {
    echo "Une erreur est survenue : " . $error->getMessage();
  }
}