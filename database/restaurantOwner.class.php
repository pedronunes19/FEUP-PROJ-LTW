<?php
  declare(strict_types = 1);

  class RestaurantOwner {
    public int $id;
    public string $first_name;
    public string $last_name;
    public string $adress;
    public string $phone;

    public function __construct(int $id, string $first_name, string $last_name, string $adress, string $phone)
    {
      $this->id = $id;
      $this->first_name = $first_name;
      $this->last_name = $last_name;
      $this->adress = $adress;
      $this->phone = $phone;
    }

  
  }
?>