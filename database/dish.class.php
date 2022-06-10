<?php
  declare(strict_types = 1);

  class Dish {
    public int $id;
    public string $name;
    public float $price;
    public int $restaurant;

    public function __construct(int $id, string $name, float $price, int $restaurant)
    {
      if (!is_string($category)) {
        $category = 'Unspecified';
      }
      $this->id = $id;
      $this->name = $name;
      $this->price = $price;
      $this->restaurant = $restaurant;
    }

    static function getDishes(PDO $db, int $size) : array {
      $stmt = $db->prepare('SELECT DishId, Name, Price, RestaurantId FROM Dish LIMIT ?');
      $stmt-> execute(array($size));

      $dishes = array();
      while ($dish = $stmt->fetch()) {
        $dishes[] = new Dish($dish['DishId'], $dish['Name'], $dish['Price'], $dish['RestaurantId']);

      }
      return $dishes;
    }

    static function getRestaurantDishes(PDO $db, int $restaurant) : array {
      $stmt = $db->prepare('SELECT DishId, Name, Price, RestaurantId FROM Dish WHERE RestaurantId = ?');
      $stmt-> execute(array($restaurant));

      $dishes = array();
      while ($dish = $stmt->fetch()) {
        $dishes[] = new Dish($dish['DishId'], $dish['Name'], $dish['Price'], $dish['RestaurantId']);

      }
      return $dishes;
    }

    static function searchDishes(PDO $db, string $search, int $count) : array {
      $stmt = $db->prepare('
        SELECT DishId, Name, Price, RestaurantId
        FROM Dish WHERE Name LIKE ? LIMIT ?
      ');
      $stmt->execute(array($search, $count));
  
      $dishes = array();
      while ($dish = $stmt->fetch()) {
        $dishes[] = new Dish(
          $dish['DishId'], 
          $dish['Name'],
          $dish['Price'],
          $dish['RestaurantId']
        );
      }
  
      return $dishes;
    }

  
  }
?>