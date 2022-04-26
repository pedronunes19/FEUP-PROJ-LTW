<?php
  declare(strict_types = 1);

  class Order {
    public int $id;
    public int $customer;
    public int $restaurant;

    public function __construct(int $id, int $customer, int $restaurant)
    {
      $this->id = $id;
      $this->customer = $customer;
      $this->restaurant = $restaurant;
      
    }

  
  }
?>