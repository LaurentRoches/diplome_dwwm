<?php

namespace src\Models;

use PDO;
use PDOException;


final class Database {
  private $DB;
  private $Config;

  public function __construct() {
    $this->Config = __DIR__ . '/../../config.php';
    require_once $this->Config;
    $this->ConnexionDB();
  }

  private function ConnexionDB() {
    try {
      $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
      $this->DB = new PDO($dsn, DB_USER, DB_PWD);
    } 
    catch (PDOException $error) {
      echo "Quelque chose s'est mal passé : " . $error->getMessage();
    }
  }

  public function getDB() {
    return $this->DB;
  }

  /**
   * Initialisation de la Base de Données : installation des tables et mise à jour du fichier config.php
   * @return string message d'échec ou de réussite.
   */
  public function initializeDB(): string {
    if ($this->testIfTableResaExists()) {
      return "La base de données semble déjà remplie.";
      die();
    }

    try {
      $sql = file_get_contents(__DIR__ . "/../Migrations/migration_1.sql");

      $this->DB->query($sql);

      if ($this->MiseAJourConfig()) {
        return "installation de la Base de Données terminée !";
        die();
      }
    } 
    catch (PDOException $erreur) {
      return "impossible de remplir la Base de données : " . $erreur->getMessage();
      die();
    }
  }

  /**
   * Vérifie si la table Resa existe déjà dans la BDD
   * @return bool
   */
  private function testIfTableResaExists(): bool {
    $existant = $this->DB->query('SHOW TABLES FROM ' . DB_NAME . ' LIKE \'' . PREFIXE . 'Resa\'')->fetch();
  
    if ($existant !== false && $existant[0] == PREFIXE . "Resa") {
      return true;
    } 
    else {
      return false;
    }
  }

  private function MiseAJourConfig(): bool {

    $fconfig = fopen($this->Config, 'w');

    $contenu = "<?php
    // lors de la mise en open source, remplacer les infos concernant la base de données.
    
    define('DB_HOST', '" . DB_HOST . "');
    define('DB_NAME', '" . DB_NAME . "');
    define('DB_USER', '" . DB_USER . "');
    define('DB_PWD', '" . DB_PWD . "');
    define('PREFIXE', '" . PREFIXE . "');
    define('HOME_URL', '". HOME_URL ."');

    // Ne pas toucher :
    
    define('DB_INITIALIZED', TRUE);";


    if (fwrite($fconfig, $contenu)) {
      fclose($fconfig);
      return true;
    } 
    else {
      fclose($fconfig);
      return false;
    }
  }
}

