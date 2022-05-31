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

    static function getMenus(PDO $db, int $size) : array {
      $stmt = $db->prepare('SELECT MenuId, Name, Price, RestaurantId FROM Menu LIMIT ?');
      $stmt-> execute(array($size));

      $menus = array();
      while ($menu = $stmt->fetch()) {
        $menus[] = new Menu($menu['MenuId'], $menu['Name'], $menu['Price'], $menu['RestaurantId']);

      }
      return $menus;
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