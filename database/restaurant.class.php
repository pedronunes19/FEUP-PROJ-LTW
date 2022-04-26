<?php
  declare(strict_types = 1);

  class Restaurant {
    public int $id;
    public string $name;
    public string $adress;

    public function __construct(int $id, string $name, string $adress)
    {
      $this->id = $id;
      $this->name = $name;
      $this->adress = $adress;
    }

  
  }
?>