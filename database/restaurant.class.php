<?php
  declare(strict_types = 1);

  class Restaurant {
    public int $id;
    public string $name;
    public ?string $address;
    public int $owner;
    public int $category;

    public function __construct(int $id, string $name, ?string $address, int $owner, int $category)
    {
      $this->id = $id;
      $this->name = $name;
      $this->address = $address;
      $this->owner = $owner;
      $this->category = $category;
    }

    function save($db, string $name, ?string $address, int $owner_id, int $category, int $id) {
      $stmt = $db->prepare('
        UPDATE Restaurant SET Name = ?, Address = ?, OwnerId = ?, CategoryId = ?
        WHERE RestaurantId = ?
      ');

      $stmt->execute(array($name, $address, $owner_id, $category, $id));
    }

    static function create($db, string $name, ?string $address, int $owner_id, int $category) {
      $stmt = $db->prepare('
        INSERT INTO Restaurant (RestaurantId, Name, Address, OwnerId, CategoryId)  
        VALUES (NULL, ?, ?, ?, ?)'
      );
      $stmt->execute(array($name, $address, $owner_id, $category));
    }

    static function getRestaurants(PDO $db, int $size) : array {
      if ($size == 0) {
        $stmt = $db->prepare('SELECT RestaurantId, Name, Address, OwnerId, CategoryId FROM Restaurant'); 
        $stmt-> execute(array());
      }
      else {
        $stmt = $db->prepare('SELECT RestaurantId, Name, Address, OwnerId, CategoryId FROM Restaurant LIMIT ?');
        $stmt-> execute(array($size));
      }


      $restaurants = array();
      while ($restaurant = $stmt->fetch()) {
        $restaurants[] = new Restaurant($restaurant['RestaurantId'], $restaurant['Name'], $restaurant['Address'], $restaurant['OwnerId'], $restaurant['CategoryId']);
      }
      return $restaurants;
    }

    static function getRestaurantsByOwner(PDO $db, int $id) : array {
      $stmt = $db->prepare('SELECT RestaurantId, Name, Address, OwnerId, CategoryId FROM Restaurant WHERE OwnerId = ?');
      $stmt-> execute(array($id));

      $restaurants = array();
      while ($restaurant = $stmt->fetch()) {
        $restaurants[] = new Restaurant($restaurant['RestaurantId'], $restaurant['Name'], $restaurant['Address'], $restaurant['OwnerId'], $restaurant['CategoryId']);
      }
      return $restaurants;
    }

    static function getRestaurant(PDO $db, int $id) : Restaurant {
      $stmt = $db->prepare('
        SELECT RestaurantId, Name, Address, OwnerId, CategoryId
        FROM Restaurant WHERE RestaurantId = ?
      ');
      $stmt->execute(array($id));
  
      $restaurant = $stmt->fetch();
  
      return new Restaurant(
        $restaurant['RestaurantId'], $restaurant['Name'], $restaurant['Address'], $restaurant['OwnerId'], $restaurant['CategoryId']
      );
    }

    static function deleteRestaurant(PDO $db, int $id) {
      $stmt = $db->prepare('
        DELETE FROM Restaurant WHERE RestaurantId = ?
      ');
      $stmt->execute(array($id));
  
      return;
    }


    static function searchRestaurants(PDO $db, string $search, ?string $score, int $count) : array {
      $stmt = $db->prepare('
        SELECT RestaurantId, Name, Address, OwnerId, CategoryId
        FROM Restaurant WHERE Name LIKE ? LIMIT ?
      ');
      $stmt->execute(array('%' . $search . '%', $count));
  
      $restaurants = array();
      while ($restaurant = $stmt->fetch()) {
        if ($score && $score != ''){
          if (Restaurant::averageScore($db, $restaurant['RestaurantId']) < floatval($score)){
            continue;
          }
        }
        $restaurants[] = new Restaurant(
          $restaurant['RestaurantId'], $restaurant['Name'], $restaurant['Address'], $restaurant['OwnerId'], $restaurant['CategoryId']
        );
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
  }
?>