<?php
  declare(strict_types = 1);

  class Restaurant {
    public int $id;
    public string $name;
    public string $address;
    public string $category;

    public function __construct(int $id, string $name, string $address)
    {
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
      $stmt = $db->prepare('SELECT RestaurantId, Name, Address FROM Restaurant LIMIT ?');
      $stmt-> execute(array($size));

      $restaurants = array();
      while ($restaurant = $stmt->fetch()) {
        $restaurants[] = new Restaurant($restaurant['RestaurantId'], $restaurant['Name'], $restaurant['Address']);

      }
      return $restaurants;
    }
  }
?>