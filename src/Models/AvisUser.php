<?php

namespace src\Models;

use DateTime;
use src\Services\Hydratation;

class AvisUser {

    private int $id_avis_user;
    private int $id_observateur;
    private int $id_evalue;
    private Bool $bln_aime;
    private DateTime $dtm_creation;
    private ?DateTime $dtm_maj = null;

    use Hydratation;



    /**
     * Get the value of id_avis_user
     */
    public function getIdAvisUser(): int
    {
        return $this->id_avis_user;
    }

    /**
     * Set the value of id_avis_user
     */
    public function setIdAvisUser(int $id_avis_user): self
    {
        $this->id_avis_user = $id_avis_user;

        return $this;
    }

    /**
     * Get the value of id_observateur
     */
    public function getIdObservateur(): int
    {
        return $this->id_observateur;
    }

    /**
     * Set the value of id_observateur
     */
    public function setIdObservateur(int $id_observateur): self
    {
        $this->id_observateur = $id_observateur;

        return $this;
    }

    /**
     * Get the value of id_evalue
     */
    public function getIdEvalue(): int
    {
        return $this->id_evalue;
    }

    /**
     * Set the value of id_evalue
     */
    public function setIdEvalue(int $id_evalue): self
    {
        $this->id_evalue = $id_evalue;

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
     * Get the value of bln_aime
     */
    public function getBlnAime(): Bool
    {
        return $this->bln_aime;
    }

    /**
     * Set the value of bln_aime
     */
    public function setBlnAime(Bool $bln_aime): self
    {
        $this->bln_aime = $bln_aime;

        return $this;
    }
}