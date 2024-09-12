<?php

use src\Models\Database;

session_start();

require __DIR__ . "/../config.php";
require __DIR__ . "/autoload.php";


if(DB_INITIALIZED == FALSE){
  $db = new Database();

  $db->initializeDB();
}
require_once __DIR__."/router.php";