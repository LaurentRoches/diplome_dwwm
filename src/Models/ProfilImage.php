<?php

namespace src\Models;

use src\Services\Hydratation;

class ProfilImage {

    private int $id_profil_image;
    private string $str_chemin;

    use Hydratation;

    /**
     * Get the value of id_profil_image
     */
    public function getIdProfilImage(): int
    {
        return $this->id_profil_image;
    }

    /**
     * Set the value of id_profil_image
     */
    public function setIdProfilImage(int $id_profil_image): self
    {
        $this->id_profil_image = $id_profil_image;

        return $this;
    }

    /**
     * Get the value of str_chemin
     */
    public function getStrChemin(): string
    {
        return $this->str_chemin;
    }

    /**
     * Set the value of str_chemin
     */
    public function setStrChemin(string $str_chemin): self
    {
        $this->str_chemin = $str_chemin;

        return $this;
    }
}