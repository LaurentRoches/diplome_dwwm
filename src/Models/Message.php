<?php

namespace src\Models;

use DateTime;
use src\Services\Hydratation;

class Message {

    private int $id_message;
    private int $id_expediteur;
    private int $id_destinataire;
    private string $str_message;
    private DateTime $dtm_envoi;
    private bool $bln_lu = FALSE;

    use Hydratation;

    /**
     * Get the value of id_message
     */
    public function getIdMessage(): int
    {
        return $this->id_message;
    }

    /**
     * Set the value of id_message
     */
    public function setIdMessage(int $id_message): self
    {
        $this->id_message = $id_message;

        return $this;
    }

    /**
     * Get the value of id_expediteur
     */
    public function getIdExpediteur(): int
    {
        return $this->id_expediteur;
    }

    /**
     * Set the value of id_expediteur
     */
    public function setIdExpediteur(int $id_expediteur): self
    {
        $this->id_expediteur = $id_expediteur;

        return $this;
    }

    /**
     * Get the value of id_destinataire
     */
    public function getIdDestinataire(): int
    {
        return $this->id_destinataire;
    }

    /**
     * Set the value of id_destinataire
     */
    public function setIdDestinataire(int $id_destinataire): self
    {
        $this->id_destinataire = $id_destinataire;

        return $this;
    }

    /**
     * Get the value of str_message
     */
    public function getStrMessage(): string
    {
        return $this->str_message;
    }

    /**
     * Set the value of str_message
     */
    public function setStrMessage(string $str_message): self
    {
        $this->str_message = $str_message;

        return $this;
    }

    /**
     * Get the value of dtm_envoi
     */
    public function getDtmEnvoi(): string
    {
        return $this->dtm_envoi->format('d-m-Y H:i:s');
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

    /**
     * Get the value of bln_lu
     */
    public function isBlnLu(): bool
    {
        return $this->bln_lu;
    }

    /**
     * Set the value of bln_lu
     */
    public function setBlnLu(bool $bln_lu): self
    {
        $this->bln_lu = $bln_lu;

        return $this;
    }
}