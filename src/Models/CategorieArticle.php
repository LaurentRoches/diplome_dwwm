<?php

namespace src\Models;

use src\Services\Hydratation;

class CategorieArticle {

    private int $id_categorie_article;
    private string $str_nom;

    use Hydratation;

    /**
     * Get the value of id_categorie_article
     */
    public function getIdCategorieArticle(): int
    {
        return $this->id_categorie_article;
    }

    /**
     * Set the value of id_categorie_article
     */
    public function setIdCategorieArticle(int $id_categorie_article): self
    {
        $this->id_categorie_article = $id_categorie_article;

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