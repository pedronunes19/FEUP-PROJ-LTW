<?php
  declare(strict_types = 1);

  class Restaurant {
    public int $id;
    public string $name;
    public string $address;
    public string $category;

    public function __construct(int $id, string $name, string $address, $category)
    {
      if (!is_string($category)) {
        $category = 'Unspecified';
      }
      $this->id = $id;
      $this->name = $name;
      $this->adress = $address;
      $this->category = $category;
    }

    function save($db) {
      $stmt = $db->prepare('
        UPDATE Restaurant SET Name = ?, Address = ?, Category = ?
        WHERE RestaurantId = ?
      ');

      $stmt->execute(array($this->name, $this->address, $this->category, $this->id));
    }

    static function getRestaurants(PDO $db, int $size) : array {
      $stmt = $db->prepare('SELECT RestaurantId, Name, Address, Category FROM Restaurant LIMIT ?');
      $stmt-> execute(array($size));

      $restaurants = array();
      while ($restaurant = $stmt->fetch()) {
        $restaurants[] = new Restaurant(intval($restaurant['RestaurantId']), $restaurant['Name'], $restaurant['Address'], $restaurant['Category']);
      }
      return $restaurants;
    }

    static function getRestaurant(PDO $db, int $id) : Restaurant {
      $stmt = $db->prepare('
        SELECT RestaurantId, Name, Address, Category 
        FROM Restaurant WHERE RestaurantId = ?
      ');
      $stmt->execute(array($id));
  
      $restaurant = $stmt->fetch();
  
      return new Restaurant(
        $restaurant['RestaurantId'], 
        $restaurant['Name'],
        $restaurant['Address'],
        $restaurant['Category']
      );
    }

    static function searchRestaurants(PDO $db, string $search, int $count) : array {
      $stmt = $db->prepare('
        SELECT RestaurantId, Name, Address, Category 
        FROM Restaurant WHERE Name LIKE ? LIMIT ?
      ');
      $stmt->execute(array($search . '%', $count));
  
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

    function averageScore(PDO $db): double {
      $count = 0;
      $total = 0.0;

      $stmt = $db->prepare('
        SELECT ReviewScore 
        FROM Review WHERE RestaurantId = ?
      ');
      $stmt->execute(array($this->id));
  
      while ($score = $stmt->fetch()) {
        $total += $score;
        $count += 1;
      }

      return ($total/$count);
    }
  }
?>