<?php

namespace src\Models;

use src\Services\Hydratation;

class Experience {

    private int $id_experience;
    private string $str_niveau;

    use Hydratation;

    /**
     * Get the value of id_experience
     */
    public function getIdExperience(): int
    {
        return $this->id_experience;
    }

    /**
     * Set the value of id_experience
     */
    public function setIdExperience(int $id_experience): self
    {
        $this->id_experience = $id_experience;

        return $this;
    }

    /**
     * Get the value of str_niveau
     */
    public function getStrNiveau(): string
    {
        return $this->str_niveau;
    }

    /**
     * Set the value of str_niveau
     */
    public function setStrNiveau(string $str_niveau): self
    {
        $this->str_niveau = $str_niveau;

        return $this;
    }
}