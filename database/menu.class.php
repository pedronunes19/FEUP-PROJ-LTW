<?php
  declare(strict_types = 1);

  class Menu {
    public int $id;
    public string $name;
    public double $price;
    public string $category;
    public int $restaurant;

    public function __construct(int $id, string $name, double $price, string $category, int $restaurant)
    {
      $this->id = $id;
      $this->name = $name;
      $this->price = $price;
      $this->category = $category;
      $this->restaurant = $restaurant;
    }

  
  }
?>