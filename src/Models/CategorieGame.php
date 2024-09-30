<?php

namespace src\Models;

use src\Services\Hydratation;

class CategorieGame {

    private int $id_categorie_game;
    private string $str_nom;

    use Hydratation;

    /**
     * Get the value of id_categorie_game
     */
    public function getIdCategorieGame(): int
    {
        return $this->id_categorie_game;
    }

    /**
     * Set the value of id_categorie_game
     */
    public function setIdCategorieGame(int $id_categorie_game): self
    {
        $this->id_categorie_game = $id_categorie_game;

        return $this;
    }

    /**
     * Get the value of str_nom
     */
    public function getStrNom(): string
    {
        return $this->str_nom;
    }

    /**
     * Set the value of str_nom
     */
    public function setStrNom(string $str_nom): self
    {
        $this->str_nom = $str_nom;

        return $this;
    }
}