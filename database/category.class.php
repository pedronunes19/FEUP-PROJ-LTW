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

    static function getDishCategories(PDO $db, int $dish) : array {
      $stmt = $db->prepare('
        SELECT CategoryDish.CategoryId, Name
        FROM CategoryDish INNER JOIN Category ON CategoryDish.CategoryId = Category.CategoryId 
        WHERE DishId = ?
      ');
      $stmt->execute(array($dish));
  
      $categories = array();
      while ($category = $stmt->fetch()) {
        $categories[] = new Category($category['CategoryId'], $category['Name']);
      }
      return $categories;
    }

    static function addDishCategories(PDO $db, int $category, int $dish) {
      $stmt = $db->prepare('
        INSERT INTO CategoryDish (CategoryId, DishId) VALUES (?, ?)
      ');
      $stmt->execute(array($category, $dish));
    }

    static function deleteDishCategories(PDO $db, int $dish) {
      $stmt = $db->prepare('
        DELETE FROM CategoryDish WHERE DishId = ?
      ');
      $stmt->execute(array($dish));
    }

    static function getMenuCategories(PDO $db, int $menu) : array {
      $stmt = $db->prepare('
        SELECT CategoryMenu.CategoryId, Name
        FROM CategoryMenu INNER JOIN Category ON CategoryMenu.CategoryId = Category.CategoryId 
        WHERE MenuId = ?
      ');
      $stmt->execute(array($menu));
  
      $categories = array();
      while ($category = $stmt->fetch()) {
        $categories[] = new Category($category['CategoryId'], $category['Name']);
      }
      return $categories;
    }

    static function addMenuCategories(PDO $db, int $category, int $menu) {
      $stmt = $db->prepare('
        INSERT INTO CategoryMenu (CategoryId, MenuId) VALUES (?, ?)
      ');
      $stmt->execute(array($category, $menu));
    }

    static function deleteMenuCategories(PDO $db, int $menu) {
      $stmt = $db->prepare('
        DELETE FROM CategoryMenu WHERE MenuId = ?
      ');
      $stmt->execute(array($menu));
    }
}