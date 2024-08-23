<?php

namespace src\Models;

use src\Services\Hydratation;

class GameConnu {

    private int $id_game;
    private int $id_user;

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
}