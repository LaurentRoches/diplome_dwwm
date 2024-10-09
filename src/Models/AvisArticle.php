<?php

namespace src\Models;

use DateTime;
use src\Services\Hydratation;

class AvisArticle {

    private int $id_avis_article;
    private int $id_article;
    private int $id_user;
    private string $str_titre;
    private string $str_avis;
    private DateTime $dtm_creation;
    private ?DateTime $dtm_maj = null;

    use Hydratation;

    /**
     * Get the value of id_avis_article
     */
    public function getIdAvisArticle(): int
    {
        return $this->id_avis_article;
    }

    /**
     * Set the value of id_avis_article
     */
    public function setIdAvisArticle(int $id_avis_article): self
    {
        $this->id_avis_article = $id_avis_article;

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

    /**
     * Get the value of id_user
     */
    public function getIdUser(): int
    {
        return $this->id_user;
    }

    /**
     * Set the value of id_user
     */
    public function setIdUser(int $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    /**
     * Get the value of str_titre
     */
    public function getStrTitre(): string
    {
        return $this->str_titre;
    }

    /**
     * Set the value of str_titre
     */
    public function setStrTitre(string $str_titre): self
    {
        $this->str_titre = $str_titre;

        return $this;
    }

    /**
     * Get the value of str_avis
     */
    public function getStrAvis(): string
    {
        return $this->str_avis;
    }

    /**
     * Set the value of str_avis
     */
    public function setStrAvis(string $str_avis): self
    {
        $this->str_avis = $str_avis;

        return $this;
    }

    /**
     * Get the value of dtm_creation
     */
    public function getDtmCreation(): string
    {
        return $this->dtm_creation->format('d-m-Y');
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
    public function getDtmMaj(): ?string
    {
        if ($this->dtm_maj !== null) {
            return $this->dtm_maj->format('d-m-Y');
        }
        return null;
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