<?php
  declare(strict_types = 1);

  class Costumer {
    public int $id;
    public string $first_name;
    public string $last_name;
    public string $address;
    public string $city;
    public string $country;
    public string $postal_code;
    public string $phone;
    public string $email;

    public function __construct(int $id, string $first_name, string $last_name, string $adress, string $city, string $country, string $postal_code, string $phone, string $email)
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

  
  }
?>