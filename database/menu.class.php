<?php
  declare(strict_types = 1);

  class Menu {
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
        UPDATE Menu SET Name = ?, Price = ?
        WHERE MenuId = ?
      ');

      $stmt->execute(array($name, $price, $id));
    }

    static function create($db, string $name, float $price, int $restaurant) {
      $stmt = $db->prepare('
        INSERT INTO Menu (Name, Price, RestaurantId)  
        VALUES (?, ?, ?)'
      );
      $stmt->execute(array($name, $price, $restaurant));
    }

    static function deleteMenu(PDO $db, int $id) {
      $stmt = $db->prepare('
        DELETE FROM Menu WHERE MenuId = ?
      ');
      $stmt->execute(array($id));
  
      return;
    }

    static function getMenus(PDO $db, int $size) : array {
      if ($size == 0) {
        $stmt = $db->prepare('SELECT MenuId, Name, Price, RestaurantId FROM Menu'); 
        $stmt-> execute(array());
      }
      else {
        $stmt = $db->prepare('SELECT MenuId, Name, Price, RestaurantId FROM Menu LIMIT ?');
        $stmt-> execute(array($size));
      }

      $menus = array();
      while ($menu = $stmt->fetch()) {
        $menus[] = new Menu($menu['MenuId'], $menu['Name'], $menu['Price'], $menu['RestaurantId']);

      }
      return $menus;
    }

    static function getMenu(PDO $db, int $id) : Menu {
      $stmt = $db->prepare('SELECT MenuId, Name, Price, RestaurantId FROM Menu WHERE MenuId = ?');
      $stmt-> execute(array($id));

      $menus = array();
      $menu = $stmt->fetch();
      
      return new Menu($menu['MenuId'], $menu['Name'], $menu['Price'], $menu['RestaurantId']);
    }

    static function getRestaurantMenus(PDO $db, int $restaurant) : array {
      $stmt = $db->prepare('SELECT MenuId, Name, Price, RestaurantId FROM Menu WHERE RestaurantId = ?');
      $stmt-> execute(array($restaurant));

      $menus = array();
      while ($menu = $stmt->fetch()) {
        $menus[] = new Menu($menu['MenuId'], $menu['Name'], $menu['Price'], $menu['RestaurantId']);

      }
      return $menus;
    }


    function getMenuDishes(PDO $db): array{
      $stmt = $db->prepare('SELECT Dish.DishId, Name, Price, RestaurantId FROM MenuDish, Dish WHERE MenuDish.MenuId = ? and Dish.DishId = MenuDish.DishId');
      $stmt-> execute(array($this->id));

      $dishes = array();
      while ($dish = $stmt->fetch()) {
        $dishes[] = new Dish($dish['DishId'], $dish['Name'], $dish['Price'], $dish['RestaurantId']);

      }
      return $dishes;
    }


  }
?>