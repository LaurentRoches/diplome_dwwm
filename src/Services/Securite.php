<?php

namespace src\Services;

use stdClass;

trait Securite {
    public static function sanitize(array|stdClass $data): array {
        if ($data instanceof stdClass) {
            $data = (array) $data;
        }

        $dataSanitized = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $dataSanitized[$key] = self::sanitize($value);
            } 
            elseif (is_int($value)) {
                $dataSanitized[$key] = intval($value);
            }
            else {
                $dataSanitized[$key] = htmlspecialchars($value, ENT_QUOTES | ENT_HTML401, 'UTF-8', false);
            }
        }
        return $dataSanitized;
    }
}
