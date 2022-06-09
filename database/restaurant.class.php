<?php
  declare(strict_types = 1);

  class Restaurant {
    public int $id;
    public string $name;
    public string $address;
    public int $owner;

    public function __construct(int $id, string $name, string $address, int $owner)
    {
      $this->id = $id;
      $this->name = $name;
      $this->address = $address;
      $this->owner = $owner;
    }

    function save($db) {
      $stmt = $db->prepare('
        UPDATE Restaurant SET Name = ?, Address = ?, OwnerId = ?
        WHERE RestaurantId = ?
      ');

      $stmt->execute(array($this->name, $this->address, $this->id, $this->owner));
    }

    static function getRestaurants(PDO $db, int $size) : array {
      $stmt = $db->prepare('SELECT RestaurantId, Name, Address, OwnerId FROM Restaurant LIMIT ?');
      $stmt-> execute(array($size));

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
        $restaurant['RestaurantId'], 
        $restaurant['Name'],
        $restaurant['Address'],
        $restaurant['OwnerId'],
      );
    }

    static function searchRestaurants(PDO $db, string $search, int $count) : array {
      $stmt = $db->prepare('
        SELECT RestaurantId, Name, Address
        FROM Restaurant WHERE Name LIKE ? LIMIT ?
      ');
      $stmt->execute(array('%' . $search . '%', $count));
  
      $restaurants = array();
      while ($restaurant = $stmt->fetch()) {
        $restaurants[] = new Restaurant(
          $restaurant['RestaurantId'], 
          $restaurant['Name'],
          $restaurant['Address'],
          $restaurant['Category']
        );
      }
  
      return $restaurants;
    }

    function hasScore(PDO $db, int $id): bool {

      $stmt = $db->prepare('
        SELECT ReviewScore 
        FROM Review WHERE RestaurantId = ?
      ');
      $stmt->execute(array($id));
  
      if($score = $stmt->fetch()) {
        return true;
      }

      return false;
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