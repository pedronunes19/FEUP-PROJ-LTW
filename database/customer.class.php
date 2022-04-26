<?php
  declare(strict_types = 1);

  class Costumer {
    public int $id;
    public string $first_name;
    public string $last_name;
    public string $adress;
    public string $city;
    public string $country;
    public string $postal_code;
    public string $phone;
    public string $email;

    public function __construct(int $id, string $first_name, string $last_name, string $adress, string $city, string $country, string $postal_code, string $phone, string $email)
    {
      $this->id = $id;
      $this->first_name = $first_name;
      $this->last_name = $last_name;
      $this->adress = $adress;
      $this->city = $city;
      $this->country = $country;
      $this->postal_code = $postal_code;
      $this->phone = $phone;
      $this->email = $email;
    }

  
  }
?>