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

}