<?php
  declare(strict_types = 1);

  class Dish {
    public int $id;
    public string $name;
    public float $price;
    public int $restaurant;

    public function __construct(int $id, string $name, float $price, int $restaurant)
    {
      $this->id = $id;
      $this->name = $name;
      $this->price = $price;
      $this->restaurant = $restaurant;
    }

    function save($db, string $name, float $price, int $id) {
      $stmt = $db->prepare('
        UPDATE Dish SET Name = ?, Price = ?
        WHERE DishId = ?
      ');

      $stmt->execute(array($name, $price, $id));
    }

    static function create($db, string $name, float $price, int $restaurant) {
      $stmt = $db->prepare('
        INSERT INTO Dish (Name, Price, RestaurantId)  
        VALUES (?, ?, ?)'
      );
      $stmt->execute(array($name, $price, $restaurant));
    }

    static function deleteDish(PDO $db, int $id) {
      $stmt = $db->prepare('
        DELETE FROM Dish WHERE DishId = ?
      ');
      $stmt->execute(array($id));
  
      return;
    }

    static function getDishes(PDO $db, int $size) : array {
      if ($size == 0) {
        $stmt = $db->prepare('SELECT DishId, Name, Price, RestaurantId FROM Dish'); 
        $stmt-> execute(array());
      }
      else {
        $stmt = $db->prepare('SELECT DishId, Name, Price, RestaurantId FROM Dish LIMIT ?');
        $stmt-> execute(array($size));
      }
      $dishes = array();
      while ($dish = $stmt->fetch()) {
        $dishes[] = new Dish($dish['DishId'], $dish['Name'], $dish['Price'], $dish['RestaurantId']);

      }
      return $dishes;
    }

    static function getDish(PDO $db, int $id) : Dish {
      $stmt = $db->prepare('SELECT DishId, Name, Price, RestaurantId FROM Dish WHERE DishId = ?');
      $stmt-> execute(array($id));

      $dish = $stmt->fetch();
      return new Dish($dish['DishId'], $dish['Name'], $dish['Price'], $dish['RestaurantId']);
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

    static function searchDishes(PDO $db, array $get, array $categories, int $count) : array {
      $search = htmlspecialchars($get['search']);
      $score = $get['score'];
      $categories_to_check = array();
      foreach($categories as $category){
        if ($get[$category->id]){
          $categories_to_check[] = $category->id;
        }
      }
      $stmt = $db->prepare('
        SELECT DishId, Name, Price, RestaurantId
        FROM Dish WHERE Name LIKE ? LIMIT ?
      ');
      $stmt->execute(array('%' . $search . '%', $count));
  
      $dishes = array();
      while ($dish = $stmt->fetch()) {
        $skip = false;

        if($score > 0){$skip = true;}

        foreach($categories_to_check as $check){
          if (!Dish::hasCategory($db, $dish['DishId'], $check)){
            $skip = true;
          }
        }
        if(!$skip){
          $dishes[] = new Dish(
            $dish['DishId'], 
            $dish['Name'],
            $dish['Price'],
            $dish['RestaurantId']
          );
        }
      }
  
      return $dishes;
    }

    static function hasCategory(PDO $db, int $dish, int $category): bool{
      $stmt = $db->prepare('
        SELECT CategoryDishId
        FROM CategoryDish WHERE CategoryId = ? AND DishId = ?
      ');
      $stmt->execute(array($category, $dish));
  
      if ($has = $stmt->fetch()) {
        return true;
      }
      return false;
    }

  
  }
?>