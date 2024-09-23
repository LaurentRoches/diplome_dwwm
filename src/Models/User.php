<?php

namespace src\Models;

use DateTime;
use src\Services\Hydratation;

class User {

    private int $id_user;
    private string $str_email;
    private string $str_nom;
    private string $str_prenom;
    private DateTime $dtm_naissance;
    private bool $bln_active = FALSE;
    private string $str_mdp = '';
    private string $str_token;
    private string $str_pseudo;
    private string $str_description = '';
    private bool $bln_mj = FALSE;
    private int $id_experience = 1;
    private int $id_role = 1;
    private int $id_profil_image = 1;
    private DateTime $dtm_creation;
    private ?DateTime $dtm_maj = null;

    use Hydratation;

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
     * Get the value of str_email
     */
    public function getStrEmail(): string
    {
        return $this->str_email;
    }

    /**
     * Set the value of str_email
     */
    public function setStrEmail(string $str_email): self
    {
        $this->str_email = $str_email;

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
     * Get the value of str_prenom
     */
    public function getStrPrenom(): string
    {
        return $this->str_prenom;
    }

    /**
     * Set the value of str_prenom
     */
    public function setStrPrenom(string $str_prenom): self
    {
        $this->str_prenom = $str_prenom;

        return $this;
    }

    /**
     * Get the value of dtm_naissance
     */
    public function getDtmNaissance(): string
    {
        return $this->dtm_naissance->format('Y-m-d');
    }

    /**
     * Set the value of dtm_naissance
     */
    public function setDtmNaissance(string|DateTime $dtm_naissance): void
    {
        if ($dtm_naissance instanceof DateTime) {
            $this->dtm_naissance = $dtm_naissance;
        } 
        else {
            $this->dtm_naissance = new DateTime($dtm_naissance);
        }
    }

    /**
     * Get the value of bln_active
     */
    public function isBlnActive(): bool
    {
        return $this->bln_active;
    }

    /**
     * Set the value of bln_active
     */
    public function setBlnActive(bool $bln_active): self
    {
        $this->bln_active = $bln_active;

        return $this;
    }

    /**
     * Get the value of str_mdp
     */
    public function getStrMdp(): string
    {
        return $this->str_mdp;
    }

    /**
     * Set the value of str_mdp
     */
    public function setStrMdp(string $str_mdp): self
    {
        $this->str_mdp = $str_mdp;

        return $this;
    }

        /**
     * Get the value of str_token
     */
    public function getStrToken(): string
    {
        return $this->str_token;
    }

    /**
     * Set the value of str_token
     */
    public function setStrToken(string $str_token): self
    {
        $this->str_token = $str_token;

        return $this;
    }

    /**
     * Get the value of str_pseudo
     */
    public function getStrPseudo(): string
    {
        return $this->str_pseudo;
    }

    /**
     * Set the value of str_pseudo
     */
    public function setStrPseudo(string $str_pseudo): self
    {
        $this->str_pseudo = $str_pseudo;

        return $this;
    }

    /**
     * Get the value of str_description
     */
    public function getStrDescription(): string
    {
        return $this->str_description;
    }

    /**
     * Set the value of str_description
     */
    public function setStrDescription(string $str_description): self
    {
        $this->str_description = $str_description;

        return $this;
    }

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
     * Get the value of id_role
     */
    public function getIdRole(): int
    {
        return $this->id_role;
    }

    /**
     * Set the value of id_role
     */
    public function setIdRole(int $id_role): self
    {
        $this->id_role = $id_role;

        return $this;
    }

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
    public function getDtmMaj(): string
    {
        return $this->dtm_maj->format('d-m-Y');
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
     * Get the value of bln_mj
     */
    public function isBlnMj(): bool
    {
        return $this->bln_mj;
    }

    /**
     * Set the value of bln_mj
     */
    public function setBlnMj(bool $bln_mj): self
    {
        $this->bln_mj = $bln_mj;

        return $this;
    }
}