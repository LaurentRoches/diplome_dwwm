<?php

namespace src\Services;

use stdClass;

trait Securite {
    public static function sanitize(array|stdClass $data): array {
        if ($data instanceof stdClass) {
            $data = (array) $data;
        }

        $dataSanitized = [];

        foreach($data as $key => $value) {
            $dataSanitized[$key] = htmlspecialchars($value);
        }
        return $dataSanitized;
    }
}