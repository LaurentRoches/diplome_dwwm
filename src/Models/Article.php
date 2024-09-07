<?php

namespace src\Models;

use DateTime;
use src\Services\Hydratation;

class Article {

    private int $id_article;
    private string $str_titre;
    private int $id_user;
    private DateTime $dtm_creation;
    private ?DateTime $dtm_maj = null;
    private string $str_resume;
    private string $str_chemin_img_1;
    private string $str_titre_section_1;
    private string $txt_section_1;
    private string $str_chemin_img_2;
    private string $str_titre_section_2;
    private string $txt_section_2;
    private int $id_categorie_article;

    use Hydratation;


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
     * Get the value of str_chemin_img_1
     */
    public function getStrCheminImg1(): string
    {
        return $this->str_chemin_img_1;
    }

    /**
     * Set the value of str_chemin_img_1
     */
    public function setStrCheminImg1(string $str_chemin_img_1): self
    {
        $this->str_chemin_img_1 = $str_chemin_img_1;

        return $this;
    }

    /**
     * Get the value of str_titre_section_1
     */
    public function getStrTitreSection1(): string
    {
        return $this->str_titre_section_1;
    }

    /**
     * Set the value of str_titre_section_1
     */
    public function setStrTitreSection1(string $str_titre_section_1): self
    {
        $this->str_titre_section_1 = $str_titre_section_1;

        return $this;
    }

    /**
     * Get the value of txt_section_1
     */
    public function getTxtSection1(): string
    {
        return $this->txt_section_1;
    }

    /**
     * Set the value of txt_section_1
     */
    public function setTxtSection1(string $txt_section_1): self
    {
        $this->txt_section_1 = $txt_section_1;

        return $this;
    }

    /**
     * Get the value of str_chemin_img_2
     */
    public function getStrCheminImg2(): string
    {
        return $this->str_chemin_img_2;
    }

    /**
     * Set the value of str_chemin_img_2
     */
    public function setStrCheminImg2(string $str_chemin_img_2): self
    {
        $this->str_chemin_img_2 = $str_chemin_img_2;

        return $this;
    }

    /**
     * Get the value of str_titre_section_2
     */
    public function getStrTitreSection2(): string
    {
        return $this->str_titre_section_2;
    }

    /**
     * Set the value of str_titre_section_2
     */
    public function setStrTitreSection2(string $str_titre_section_2): self
    {
        $this->str_titre_section_2 = $str_titre_section_2;

        return $this;
    }

    /**
     * Get the value of txt_section_2
     */
    public function getTxtSection2(): string
    {
        return $this->txt_section_2;
    }

    /**
     * Set the value of txt_section_2
     */
    public function setTxtSection2(string $txt_section_2): self
    {
        $this->txt_section_2 = $txt_section_2;

        return $this;
    }

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
}