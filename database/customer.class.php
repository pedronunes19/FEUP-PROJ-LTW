<?php
  declare(strict_types = 1);

  class Customer {
    public int $id;
    public string $first_name;
    public string $last_name;
    public string $address;
    public ?string $city;
    public ?string $country;
    public ?string $postal_code;
    public ?string $phone;
    public string $email;

    public function __construct(int $id, string $first_name, string $last_name, string $address, ?string $city, ?string $country, ?string $postal_code, ?string $phone, string $email)
    {
      $this->id = $id;
      $this->first_name = $first_name;
      $this->last_name = $last_name;
      $this->address = $address;
      $this->city = $city;
      $this->country = $country;
      $this->postal_code = $postal_code;
      $this->phone = $phone;
      $this->email = $email;
    }

    function name() {
      return $this->first_name . ' ' . $this->last_name;
    }

    function save($db, string $first_name, string $last_name, string $address, ?string $city, ?string $country, ?string $postal_code, ?string $phone, string $email, string $password) {
      $stmt = $db->prepare('
        UPDATE Customer SET FirstName = ?, LastName = ?, Address = ?, City = ?, Country = ?, PostalCode = ?, PhoneNumber = ?, Email = ?, Password = ?
        WHERE CustomerId = ?
      ');

      $stmt->execute(array($first_name, $last_name, $address, $city, $country, $postal_code, $phone, strtolower($email), password_hash($password, PASSWORD_BCRYPT), $this->id));
    }

    static function create($db, string $first_name, string $last_name, string $address, ?string $city, ?string $country, ?string $postal_code, ?string $phone, string $email, string $password) {
      $stmt = $db->prepare('
        INSERT INTO Customer (CustomerId, FirstName, LastName, Address, City, Country, PostalCode, PhoneNumber, Email, Password) 
        VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

      $stmt->execute(array($first_name, $last_name, $address, $city, $country, $postal_code, $phone, strtolower($email), password_hash($password, PASSWORD_BCRYPT)));
    }
    
    static function getCustomerWithPassword(PDO $db, string $email, string $password) : ?Customer {
      $stmt = $db->prepare('
        SELECT CustomerId, FirstName, LastName, Address, City, Country, PostalCode, PhoneNumber, Email, Password
        FROM Customer 
        WHERE lower(Email) = ?
      ');

      $stmt->execute(array(strtolower($email)));
  
      if (($customer = $stmt->fetch()) && password_verify($password, $customer['Password'])) {
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

    static function getCustomerWithEmail(PDO $db, string $email) : ?Customer {
      $stmt = $db->prepare('
        SELECT CustomerId, FirstName, LastName, Address, City, Country, PostalCode, PhoneNumber, Email
        FROM Customer 
        WHERE lower(Email) = ?
      ');

      $stmt->execute(array(strtolower($email)));
  
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

    static function getfavoriteRestaurants(PDO $db, int $id){
      $stmt = $db->prepare('SELECT FavoriteCustomerRestaurantId, Restaurant.OwnerId, Restaurant.RestaurantId, CustomerId, Name, Address
        FROM FavoriteCustomerRestaurant
        INNER JOIN Restaurant
        ON FavoriteCustomerRestaurant.RestaurantId = Restaurant.RestaurantId
        WHERE CustomerId = ? ORDER BY Restaurant.RestaurantId ASC
      ');
      $stmt->execute(array($id));
      $restaurants = array();
      while ($restaurant = $stmt->fetch()) {
        $restaurants[] = new Restaurant($restaurant['RestaurantId'], $restaurant['Name'], $restaurant['Address'], $restaurant['OwnerId']);
      }
      return $restaurants;

    }

    static function getfavoriteDishes(PDO $db, int $id){
      $stmt = $db->prepare('SELECT FavoriteCustomerDishId, Dish.RestaurantId, Dish.Price, CustomerId, Dish.Name, Dish.DishId
        FROM FavoriteCustomerDish
        INNER JOIN Dish
        ON FavoriteCustomerDish.DishId = Dish.DishId
        WHERE CustomerId = ? ORDER BY Dish.DishId ASC
      ');
      $stmt->execute(array($id));
      $dishes = array();
      while ($dish = $stmt->fetch()) {
        $dishes[] = new Dish($dish['DishId'], $dish['Name'], $dish['Price'], $dish['RestaurantId']);
      }
      return $dishes;

    }

    function favoriteRestaurant(PDO $db, int $restaurant) {
      $stmt = $db->prepare('
        INSERT INTO FavoriteCustomerRestaurant (CustomerId, RestaurantId)
        VALUES (?, ?)
      ');

      $stmt->execute(array($this->id, $restaurant));
  

    }

    function unFavoriteRestaurant(PDO $db, int $restaurant) {
      $stmt = $db->prepare('
        DELETE FROM FavoriteCustomerRestaurant
        WHERE CustomerId = ? AND RestaurantId = ?
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
        VALUES (?, ?)
      ');

      $stmt->execute(array($this->id, $dish));
  

    }

    function unFavoriteDish(PDO $db, int $dish) {
      $stmt = $db->prepare('
        DELETE FROM FavoriteCustomerDish
        WHERE CustomerId = ? AND DishId = ?
      ');

      $stmt->execute(array($this->id, $dish));
  

    }


  }
?>