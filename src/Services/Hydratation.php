<?php

namespace src\Services;

trait Hydratation
{

  // copier le constructeur
  public function __construct(array $data = array())
  {
    $this->hydrate($data);
  }
  // copier votre méthode d'hydratation
  private function hydrate(array $data): void {
    foreach ($data as $key => $value) {
      $parts = explode('_', $key);
      $setter = 'set';
      foreach ($parts as $part) {
        $setter .= ucfirst($part);
      }
      
      $this->$setter($value);
    }
  }
  // copier votre méthode magique __set
  public function __set($name, $value) {
    $this->hydrate([$name => $value]);
  }

}