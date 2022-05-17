<?php
  declare(strict_types = 1);

  class RestaurantOwner {
    public int $id;
    public string $first_name;
    public string $last_name;
    public string $address;
    public string $phone;

    public function __construct(int $id, string $first_name, string $last_name, string $adress, string $phone)
    {
      $this->id = $id;
      $this->first_name = $first_name;
      $this->last_name = $last_name;
      $this->address = $address;
      $this->phone = $phone;
    }

    function name() {
      return $this->first_name . ' ' . $this->last_name;
    }

    function save($db) {
      $stmt = $db->prepare('
        UPDATE RestaurantOwner SET FirstName = ?, LastName = ?, Address = ?, PhoneNumber = ?
        WHERE CustomerId = ?
      ');

      $stmt->execute(array($this->first_name, $this->last_name, $this->address, $this->phone, $this->id));
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
      $customer = $stmt->fetch();
      
      return new RestaurantOwner(
        $owner['OwnerId'],
        $owner['FirstName'],
        $owner['LastName'],
        $owner['Address'],
        $owner['PhoneNumber'],
        $owner['Email']
      );
    }

  
  }
?>