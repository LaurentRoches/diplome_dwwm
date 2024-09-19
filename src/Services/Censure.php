<?php

namespace src\Services;

use src\Models\Database;
use src\Repositories\TabouRepository;

trait Censure {
    public function filtrer(string $texte):string {
        $database = new Database();
        $TabouRepository = TabouRepository::getInstance($database);
        $tab_tabou = $TabouRepository->getAllTabou();
        foreach($tab_tabou as $tabou) {
            $texte = str_ireplace($tabou['str_mot'], "***", $texte);
        }
        return $texte;
    }
}