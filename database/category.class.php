<?php
  declare(strict_types = 1);

  class Category {
    public int $id;
    public string $name;

    public function __construct(int $id, string $name)
    {
      $this->id = $id;
      $this->name = $name;
    }

    static function getCategory(PDO $db, int $id) : Category {
        $stmt = $db->prepare('SELECT CategoryId, Name
        FROM Category
        WHERE CategoryId = ?
        ');
        $stmt-> execute(array($id));
  
        $category = $stmt->fetch();
        return new Category($category['CategoryId'], $category['Name']);
    }

    static function getCategories(PDO $db) : array {

        $stmt = $db->prepare('SELECT CategoryId, Name FROM Category'); 
        $stmt-> execute(array());
  

        $categories = array();
        while ($category = $stmt->fetch()) {
          $categories[] = new Category($category['CategoryId'], $category['Name']);
        }
        return $categories;
    }

    static function getRestaurantCategories(PDO $db, int $restaurant) : array {
        $stmt = $db->prepare('
          SELECT CategoryRestaurant.CategoryId, Name
          FROM CategoryRestaurant INNER JOIN Category ON CategoryRestaurant.CategoryId = Category.CategoryId 
          WHERE RestaurantId = ?
        ');
        $stmt->execute(array($restaurant));
    
        $categories = array();
        while ($category = $stmt->fetch()) {
          $categories[] = new Category($category['CategoryId'], $category['Name']);
        }
        return $categories;
      }
    
    static function addRestaurantCategories(PDO $db, int $category, int $restaurant) {
        $stmt = $db->prepare('
          INSERT INTO CategoryRestaurant (CategoryId, RestaurantId) VALUES (?, ?)
        ');
        $stmt->execute(array($category, $restaurant));
    }

    static function deleteRestaurantCategories(PDO $db, int $restaurant) {
        $stmt = $db->prepare('
          DELETE FROM CategoryRestaurant WHERE RestaurantId = ?
        ');
        $stmt->execute(array($restaurant));
    }

}