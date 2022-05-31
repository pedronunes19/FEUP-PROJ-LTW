<?php
  declare(strict_types = 1);

  class RestaurantOwner {
    public int $id;
    public string $first_name;
    public string $last_name;
    public ?string $address;
    public ?string $city;
    public ?string $country;
    public ?string $postal_code;
    public ?string $phone;
    public string $email;

    public function __construct(int $id, string $first_name, string $last_name, ?string $address, ?string $city, ?string $country, ?string $postal_code, ?string $phone, string $email)
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

    function save($db) {
      $stmt = $db->prepare('
        UPDATE RestaurantOwner SET FirstName = ?, LastName = ?, Address = ?, PhoneNumber = ?
        WHERE CustomerId = ?
      ');

      $stmt->execute(array($this->first_name, $this->last_name, $this->address, $this->city = $city, $this->country = $country, $this->postal_code = $postal_code, $this->phone = $phone, $this->email = $email, $this->id));
    }

    static function create($db, string $first_name, string $last_name, ?string $address, ?string $city, ?string $country, ?string $postal_code, ?string $phone, string $email, string $password) {
      $stmt = $db->prepare('
        INSERT INTO RestaurantOwner (OwnerId, FirstName, LastName, Address, City, Country, PostalCode, PhoneNumber, Email, Password) 
        VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

      $stmt->execute(array($first_name, $last_name, $address, $city, $country, $postal_code, $phone, strtolower($email), password_hash($password, PASSWORD_BCRYPT)));
    }
    
    static function getOwnerWithPassword(PDO $db, string $email, string $password) : ?RestaurantOwner {
      $stmt = $db->prepare('
        SELECT OwnerId, FirstName, LastName, Address, PhoneNumber, Email
        FROM RestaurantOwner
        WHERE lower(Email) = ? AND Password = ?
      ');

      $stmt->execute(array(strtolower($email), sha1($password)));
  
      if ($owner = $stmt->fetch()) {
        return new RestaurantOwner(
          $owner['OwnerId'],
          $owner['FirstName'],
          $owner['LastName'],
          $owner['Address'],
          $owner['City'],
          $owner['Country'],
          $owner['PostalCode'],
          $owner['PhoneNumber'],
          $owner['Email']
        );
      } else return null;
    }

    static function getOwnerWithEmail(PDO $db, string $email) : ?RestaurantOwner {
      $stmt = $db->prepare('
        SELECT OwnerId, FirstName, LastName, Address, City, Country, PostalCode, PhoneNumber, Email
        FROM RestaurantOwner
        WHERE lower(Email) = ?
      ');

      $stmt->execute(array(strtolower($email)));
  
      if ($owner = $stmt->fetch()) {
        return new RestaurantOwner(
          $owner['OwnerId'],
          $owner['FirstName'],
          $owner['LastName'],
          $owner['Address'],
          $owner['City'],
          $owner['Country'],
          $owner['PostalCode'],
          $owner['PhoneNumber'],
          $owner['Email']
        );
      } else return null;
    }

    static function getOwner(PDO $db, int $id) : RestaurantOwner {
      $stmt = $db->prepare('
        SELECT OwnerId, FirstName, LastName, Address, PhoneNumber, Email
        FROM RestaurantOwner 
        WHERE OwnerId = ?
      ');

      $stmt->execute(array($id));
      $owner = $stmt->fetch();
      
      return new RestaurantOwner(
        $owner['OwnerId'],
        $owner['FirstName'],
        $owner['LastName'],
        $owner['Address'],
        $owner['City'],
        $owner['Country'],
        $owner['PostalCode'],
        $owner['PhoneNumber'],
        $owner['Email']
      );
    }

  
  }
?>