<?php
  declare(strict_types = 1);

  class Dish {
    public int $id;
    public string $name;
    public double $price;
    public string $category;

    public function __construct(int $id, string $name, double $price, string $category, int $menu)
    {
      $this->id = $id;
      $this->name = $name;
      $this->price = $price;
      $this->category = $category;
    }

  
  }
?>