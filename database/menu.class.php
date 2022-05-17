<?php
  declare(strict_types = 1);

  class Menu {
    public int $id;
    public string $name;
    public double $price;
    public string $category;
    public int $restaurant;

    public function __construct(int $id, string $name, double $price, string $category, int $restaurant)
    {
      $this->id = $id;
      $this->name = $name;
      $this->price = $price;
      $this->category = $category;
      $this->restaurant = $restaurant;
    }


    static function getMenuDishes(PDO $db): array{
      $stmt = $db->prepare('SELECT DishId, Name, Price, Category FROM MenuDish, Dish WHERE MenuDish.MenuId = ? and Dish.DishId = MenuDish.DishId');
      $stmt-> execute(array($this->id));

      $dishes = array();
      while ($dish = $stmt->fetch()) {
        $dishes[] = new Dish($dish['DishId'], $dish['Name'], $dish['Price'], $dish['Category']);

      }
      return $dishes;
    }

  
  }
?>