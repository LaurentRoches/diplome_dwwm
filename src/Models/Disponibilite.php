<?php

namespace src\Models;

use DateTime;
use src\Services\Hydratation;

class Disponibilite {

    private int $id_disponibilite;
    private int $id_user;
    private string $str_jour;
    private DateTime $time_debut;
    private DateTime $time_fin;

    use Hydratation;

    /**
     * Get the value of id_disponibilite
     */
    public function getIdDisponibilite(): int
    {
        return $this->id_disponibilite;
    }

    /**
     * Set the value of id_disponibilite
     */
    public function setIdDisponibilite(int $id_disponibilite): self
    {
        $this->id_disponibilite = $id_disponibilite;
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
     * Get the value of str_jour
     */
    public function getStrJour(): string
    {
        return $this->str_jour;
    }

    /**
     * Set the value of str_jour
     */
    public function setStrJour(string $str_jour): self
    {
        $this->str_jour = $str_jour;
        return $this;
    }

    /**
     * Get the value of time_debut
     */
    public function getTimeDebut(): string
    {
        return $this->time_debut->format('H:i:s');
    }

    /**
     * Set the value of time_debut
     */
    public function setTimeDebut(string|DateTime $time_debut): self
    {
        if ($time_debut instanceof DateTime) {
            $this->time_debut = $time_debut;
        } else {
            $this->time_debut = new DateTime($time_debut);
        }
        return $this;
    }

    /**
     * Get the value of time_fin
     */
    public function getTimeFin(): string
    {
        return $this->time_fin->format('H:i:s');
    }

    /**
     * Set the value of time_fin
     */
    public function setTimeFin(string|DateTime $time_fin): self
    {
        if ($time_fin instanceof DateTime) {
            $this->time_fin = $time_fin;
        } else {
            $this->time_fin = new DateTime($time_fin);
        }
        return $this;
    }
}
