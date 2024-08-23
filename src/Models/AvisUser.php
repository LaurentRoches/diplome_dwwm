<?php

namespace src\Models;

use DateTime;
use src\Services\Hydratation;

class AvisUser {

    private int $id_avis_user;
    private int $id_observateur;
    private int $id_evalue;
    private string $str_avis;
    private int $int_note;
    private DateTime $dtm_envoi;

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
     * Get the value of int_note
     */
    public function getIntNote(): int
    {
        return $this->int_note;
    }

    /**
     * Set the value of int_note
     */
    public function setIntNote(int $int_note): self
    {
        $this->int_note = $int_note;

        return $this;
    }

    /**
     * Get the value of dtm_envoi
     */
    public function getDtmEnvoi(): string
    {
        return $this->dtm_envoi->format('Y-m-d');
    }

    /**
     * Set the value of dtm_envoi
     */
    public function setDtmEnvoi(string|DateTime $dtm_envoi): void
    {
        if($dtm_envoi instanceof DateTime) {
            $this->dtm_envoi = $dtm_envoi;
        }
        else {
            $this->dtm_envoi = new DateTime($dtm_envoi);
        }
    }
}