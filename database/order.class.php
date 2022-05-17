<?php
  declare(strict_types = 1);

  class Order {
    public int $id;
    public int $customer;
    public int $restaurant;
    public string $status

    public function __construct(int $id, int $customer, int $restaurant, string $status)
    {
      $this->id = $id;
      $this->customer = $customer;
      $this->restaurant = $restaurant;
      $this->status = $status
      
    }

  
  }
?>