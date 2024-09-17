<?php

namespace src\Models;

use src\Services\Hydratation;

class Tabou {

    private int $id_tabou;
    private string $str_mot;

    use Hydratation;

        /**
     * Get the value of id_tabou
     */
    public function getIdTabou(): int
    {
        return $this->id_tabou;
    }

    /**
     * Set the value of id_tabou
     */
    public function setIdTabou(int $id_tabou): self
    {
        $this->id_tabou = $id_tabou;

        return $this;
    }

    /**
     * Get the value of str_mot
     */
    public function getStrMot(): string
    {
        return $this->str_mot;
    }

    /**
     * Set the value of str_mot
     */
    public function setStrMot(string $str_mot): self
    {
        $this->str_mot = $str_mot;

        return $this;
    }
}