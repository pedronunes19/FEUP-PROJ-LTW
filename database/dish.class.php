<?php
  declare(strict_types = 1);

  class Dish {
    public int $id;
    public string $name;
    public double $price;
    public string $category;
    public int $restaurant;

    public function __construct(int $id, string $name, double $price, string $category, int $menu)
    {
      $this->id = $id;
      $this->name = $name;
      $this->price = $price;
      $this->category = $category;
      $this->restaurant = $restaurant;
    }

    static function getDishes(PDO $db, int $size) : array {
      $stmt = $db->prepare('SELECT DishId, Name, Price, Category, RestaurantId FROM Dish LIMIT ?');
      $stmt-> execute(array($size));

      $dishes = array();
      while ($dish = $stmt->fetch()) {
        $dishes[] = new Dish($dish['DishId'], $dish['Name'], $dish['Price'], $dish['Category'], $dish['RestaurantId']);

      }
      return $dishes;
    }

  
  }
?>