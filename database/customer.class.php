<?php
  declare(strict_types = 1);

  class Customer {
    public int $id;
    public string $first_name;
    public string $last_name;
    public string $address;
    public string $city;
    public string $country;
    public string $postal_code;
    public string $phone;
    public string $email;

    public function __construct(int $id, string $first_name, string $last_name, ?string $address, ?string $city, ?string $country, ?string $postal_code, ?string $phone, string $email)
    {
      $this->id = $id;
      $this->first_name = $first_name;
      $this->last_name = $last_name;
      $this->email = $email;

      $arr = [
        "address" => $address, 
        "city" => $city, 
        "country" => $country, 
        "postal_code" => $postal_code, 
        "phone" => $phone
      ];

      foreach ($arr as $field) {
        if (isset($field)) { 
          $field_name = key($arr);
          $this->$field_name = $field;
        }
      }
    }

    function name() {
      return $this->first_name . ' ' . $this->last_name;
    }

    function save($db) {
      $stmt = $db->prepare('
        UPDATE Customer SET FirstName = ?, LastName = ?, Address = ?, PhoneNumber = ?
        WHERE CustomerId = ?
      ');

      $stmt->execute(array($this->first_name, $this->last_name, $this->address, $this->phone, $this->id));
    }
    
    static function getCustomerWithPassword(PDO $db, string $email, string $password) : ?Customer {
      $stmt = $db->prepare('
        SELECT CustomerId, FirstName, LastName, Address, City, Country, PostalCode, PhoneNumber, Email
        FROM Customer 
        WHERE lower(Email) = ? AND Password = ?
      ');

      $stmt->execute(array(strtolower($email), sha1($password)));
  
      if ($customer = $stmt->fetch()) {
        return new Customer(
          $customer['CustomerId'],
          $customer['FirstName'],
          $customer['LastName'],
          $customer['Address'],
          $customer['City'],
          $customer['Country'],
          $customer['PostalCode'],
          $customer['PhoneNumber'],
          $customer['Email']
        );
      } else return null;
    }

    static function getCustomer(PDO $db, int $id) : Customer {
      $stmt = $db->prepare('
        SELECT CustomerId, FirstName, LastName, Address, City, Country, PostalCode, PhoneNumber, Email
        FROM Customer 
        WHERE CustomerId = ?
      ');

      $stmt->execute(array($id));
      $customer = $stmt->fetch();
      
      return new Customer(
        $customer['CustomerId'],
        $customer['FirstName'],
        $customer['LastName'],
        $customer['Address'],
        $customer['City'],
        $customer['Country'],
        $customer['PostalCode'],
        $customer['PhoneNumber'],
        $customer['Email']
      );
    }

    function isFavoriteRestaurant(PDO $db, int $restaurant) : ?bool {
      $stmt = $db->prepare('
        SELECT FavoriteCustomerRestaurantId
        FROM FavoriteCustomerRestaurant 
        WHERE CustomerId = ? AND RestaurantId = ?
      ');

      $stmt->execute(array($this->id, $restaurant));
  
      if ($favorite = $stmt->fetch()) {
        return true;
      }
      
      return false;

    }

    function getfavouriteRestaurants(PDO $db,int $customer){
      $stmt = $db->prepare('SELECT RestaurantId
        FROM FavoriteCustomerRestaurant
        WHERE CustomerId = ?
      ');
      $stmt->execute(array($this->id,$customer));
      

    }

    function favoriteRestaurant(PDO $db, int $restaurant) {
      $stmt = $db->prepare('
        INSERT INTO FavoriteCustomerRestaurant (CustomerId, RestaurantId)
        VALUES ?, ?
      ');

      $stmt->execute(array($this->id, $restaurant));
  

    }

    function unFavoriteRestaurant(PDO $db, int $restaurant) {
      $stmt = $db->prepare('
        DELETE FROM FavoriteCustomerRestaurant
        WHERE CustomerId = ?, RestaurantId = ?
      ');

      $stmt->execute(array($this->id, $restaurant));
  

    }

    function isFavoriteDish(PDO $db, int $dish) : ?bool {
      $stmt = $db->prepare('
        SELECT FavoriteCustomerDishId
        FROM FavoriteCustomerDish
        WHERE CustomerId = ? AND DishId = ?
      ');

      $stmt->execute(array($this->id, $dish));
  
      if ($favorite = $stmt->fetch()) {
        return true;
      }
      
      return false;

    }

    function favoriteDish(PDO $db, int $dish) {
      $stmt = $db->prepare('
        INSERT INTO FavoriteCustomerDish (CustomerId, DishId)
        VALUES ?, ?
      ');

      $stmt->execute(array($this->id, $dish));
  

    }

    function unFavoriteDish(PDO $db, int $dish) {
      $stmt = $db->prepare('
        DELETE FROM FavoriteCustomerDish
        WHERE CustomerId = ?, DishId = ?
      ');

      $stmt->execute(array($this->id, $dish));
  

    }


  }
?>