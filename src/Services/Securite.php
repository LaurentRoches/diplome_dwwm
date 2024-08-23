<?php

namespace src\Services;

use stdClass;

trait Securite {

  public static function sanitize(array|stdClass $data): array {

    if ($data instanceof stdClass) {
      $data = (array) $data;
    }

    $dataSanitazed = [];

    foreach($data as $key => $value) {
      $dataSanitazed[$key] = htmlspecialchars($value);
    }
    return $dataSanitazed;
  }
}