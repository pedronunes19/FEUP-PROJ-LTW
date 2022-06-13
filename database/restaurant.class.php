<?php
  declare(strict_types = 1);

  class Restaurant {
    public int $id;
    public string $name;
    public ?string $address;
    public int $owner;

    public function __construct(int $id, string $name, ?string $address, int $owner)
    {
      $this->id = $id;
      $this->name = $name;
      $this->address = $address;
      $this->owner = $owner;
    }

    function save($db, string $name, ?string $address, int $id) {
      $stmt = $db->prepare('
        UPDATE Restaurant SET Name = ?, Address = ?
        WHERE RestaurantId = ?
      ');

      $stmt->execute(array($name, $address, $id));
    }

    static function create($db, string $name, ?string $address, int $owner_id) {
      $stmt = $db->prepare('
        INSERT INTO Restaurant (Name, Address, OwnerId)  
        VALUES (?, ?, ?)'
      );
      $stmt->execute(array($name, $address, $owner_id));
    }

    static function getRestaurants(PDO $db, int $size) : array {
      if ($size == 0) {
        $stmt = $db->prepare('SELECT RestaurantId, Name, Address, OwnerId FROM Restaurant'); 
        $stmt-> execute(array());
      }
      else {
        $stmt = $db->prepare('SELECT RestaurantId, Name, Address, OwnerId FROM Restaurant LIMIT ?');
        $stmt-> execute(array($size));
      }


      $restaurants = array();
      while ($restaurant = $stmt->fetch()) {
        $restaurants[] = new Restaurant($restaurant['RestaurantId'], $restaurant['Name'], $restaurant['Address'], $restaurant['OwnerId']);
      }
      return $restaurants;
    }

    static function getRestaurantsByOwner(PDO $db, int $id) : array {
      $stmt = $db->prepare('SELECT RestaurantId, Name, Address, OwnerId FROM Restaurant WHERE OwnerId = ?');
      $stmt-> execute(array($id));

      $restaurants = array();
      while ($restaurant = $stmt->fetch()) {
        $restaurants[] = new Restaurant($restaurant['RestaurantId'], $restaurant['Name'], $restaurant['Address'], $restaurant['OwnerId']);
      }
      return $restaurants;
    }

    static function getRestaurant(PDO $db, int $id) : Restaurant {
      $stmt = $db->prepare('
        SELECT RestaurantId, Name, Address, OwnerId
        FROM Restaurant WHERE RestaurantId = ?
      ');
      $stmt->execute(array($id));
  
      $restaurant = $stmt->fetch();
  
      return new Restaurant(
        $restaurant['RestaurantId'], $restaurant['Name'], $restaurant['Address'], $restaurant['OwnerId']
      );
    }

    static function deleteRestaurant(PDO $db, int $id) {
      $stmt = $db->prepare('
        DELETE FROM Restaurant WHERE RestaurantId = ?
      ');
      $stmt->execute(array($id));
  
      return;
    }

    static function searchRestaurants(PDO $db, array $get, array $categories, int $count) : array {
      $search = $get['search'];
      $score = $get['score'];
      $categories_to_check = array();
      foreach($categories as $category){
        if ($get[$category->id]){
          $categories_to_check[] = $category->id;
        }
      }
      $stmt = $db->prepare('
        SELECT RestaurantId, Name, Address, OwnerId
        FROM Restaurant WHERE Name LIKE ? LIMIT ?
      ');
      $stmt->execute(array('%' . $search . '%', $count));
  
      $restaurants = array();
      while ($restaurant = $stmt->fetch()) {
        $skip = false;
        if ($score && $score != ''){
          if (Restaurant::averageScore($db, $restaurant['RestaurantId']) < floatval($score)){
            $skip = true;
          }
        }
        foreach($categories_to_check as $check){
          if (!Restaurant::hasCategory($db, $restaurant['RestaurantId'], $check)){
            $skip = true;
          }
        }
        if(!$skip){
          $restaurants[] = new Restaurant(
            $restaurant['RestaurantId'], $restaurant['Name'], $restaurant['Address'], $restaurant['OwnerId']
          );
        }
      }
  
      return $restaurants;
    }

    static function averageScore(PDO $db, int $id): float {
      $count = 0;
      $total = 0.0;

      $stmt = $db->prepare('
        SELECT ReviewScore 
        FROM Review WHERE RestaurantId = ?
      ');
      $stmt->execute(array($id));
  
      while ($score = $stmt->fetch()) {
        $total += $score['ReviewScore'];
        $count += 1;
      }

      if ($count == 0) return -1;
      return ($total/$count);
    }

    static function hasCategory(PDO $db, int $restaurant, int $category): bool{
      $stmt = $db->prepare('
        SELECT CategoryRestaurantId
        FROM CategoryRestaurant WHERE CategoryId = ? AND RestaurantId = ?
      ');
      $stmt->execute(array($category, $restaurant));
  
      if ($has = $stmt->fetch()) {
        return true;
      }
      return false;
    }
  }
?>