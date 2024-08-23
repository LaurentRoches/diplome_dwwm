<?php

namespace src\Models;

use DateTime;
use src\Services\Hydratation;

class ReponseAvisUser {

    private int $id_reponse_avis_user;
    private int $id_user;
    private int $id_avis_user;
    private string $str_message;
    private DateTime $dtm_creation;

    use Hydratation;

    /**
     * Get the value of id_reponse_avis_user
     */
    public function getIdReponseAvisUser(): int
    {
        return $this->id_reponse_avis_user;
    }

    /**
     * Set the value of id_reponse_avis_user
     */
    public function setIdReponseAvisUser(int $id_reponse_avis_user): self
    {
        $this->id_reponse_avis_user = $id_reponse_avis_user;

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
     * Get the value of dtm_creation
     */
    public function getDtmCreation(): string
    {
        return $this->dtm_creation->format('Y-m-d H:i:s');
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
}