<?php

namespace src\Models;

use src\Services\Hydratation;

class ListeCategorieArticle {

    private int $id_categorie_article;
    private int $id_article;

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
     * Get the value of id_article
     */
    public function getIdArticle(): int
    {
        return $this->id_article;
    }

    /**
     * Set the value of id_article
     */
    public function setIdArticle(int $id_article): self
    {
        $this->id_article = $id_article;

        return $this;
    }
}