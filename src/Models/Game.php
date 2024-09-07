<?php

namespace src\Models;

use DateTime;
use src\Services\Hydratation;

class Game {

    private int $id_game;
    private string $str_nom;
    private string $str_resume;
    private string $txt_description;
    private int $id_categorie_game;
    private DateTime $dtm_creation;
    private ?DateTime $dtm_maj = null;

    use Hydratation;

    /**
     * Get the value of id_game
     */
    public function getIdGame(): int
    {
        return $this->id_game;
    }

    /**
     * Set the value of id_game
     */
    public function setIdGame(int $id_game): self
    {
        $this->id_game = $id_game;

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

    /**
     * Get the value of str_resume
     */
    public function getStrResume(): string
    {
        return $this->str_resume;
    }

    /**
     * Set the value of str_resume
     */
    public function setStrResume(string $str_resume): self
    {
        $this->str_resume = $str_resume;

        return $this;
    }

    /**
     * Get the value of txt_description
     */
    public function getTxtDescription(): string
    {
        return $this->txt_description;
    }

    /**
     * Set the value of txt_description
     */
    public function setTxtDescription(string $txt_description): self
    {
        $this->txt_description = $txt_description;

        return $this;
    }

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
     * Get the value of dtm_creation
     */
    public function getDtmCreation(): string
    {
        return $this->dtm_creation->format('Y-m-d');
    }

    /**
     * Set the value of dtm_creation
     */
    public function setDtmCreation(string|DateTime $dtm_creation): void
    {
        if($dtm_creation instanceof DateTime) {
            $this->dtm_creation = $dtm_creation;
        }
        else {
            $this->dtm_creation = new DateTime($dtm_creation);
        }
    }

    /**
     * Get the value of dtm_maj
     */
    public function getDtmMaj(): string
    {
        return $this->dtm_maj->format('Y-m-d');
    }

    /**
     * Set the value of dtm_maj
     */
    public function setDtmMaj(null|string|DateTime $dtm_maj): void
    {
        if (is_null($dtm_maj)) {
            $this->dtm_maj = null;
        } elseif ($dtm_maj instanceof DateTime) {
            $this->dtm_maj = $dtm_maj;
        } else {
            $this->dtm_maj = new DateTime($dtm_maj);
        }
    }
}