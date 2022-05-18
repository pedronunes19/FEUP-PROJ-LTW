<?php
  declare(strict_types = 1);

  class Dish {
    public int $id;
    public string $name;
    public float $price;
    public string $category;
    public int $restaurant;

    public function __construct(int $id, string $name, float $price, $category, int $restaurant)
    {
      if (!is_string($category)) {
        $category = 'Unspecified';
      }
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

    static function getRestaurantDishes(PDO $db, int $restaurant) : array {
      $stmt = $db->prepare('SELECT DishId, Name, Price, Category, RestaurantId FROM Dish WHERE RestaurantId = ?');
      $stmt-> execute(array($restaurant));

      $dishes = array();
      while ($dish = $stmt->fetch()) {
        $dishes[] = new Dish($dish['DishId'], $dish['Name'], $dish['Price'], $dish['Category'], $dish['RestaurantId']);

      }
      return $dishes;
    }

  
  }
?>