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
            } else {
                $dataSanitized[$key] = htmlspecialchars($value);
            }
        }
        return $dataSanitized;
    }
}
