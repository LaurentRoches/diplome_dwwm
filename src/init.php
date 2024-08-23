<?php

use src\Models\Database;

require __DIR__ . "/../config.php";
require __DIR__ . "/autoload.php";
session_start();

if(DB_INITIALIZED == FALSE){
  $db = new Database();

  $db->initializeDB();
}
require_once __DIR__."/router.php";