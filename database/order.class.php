<?php
  declare(strict_types = 1);

  class Order {
    public int $id;
    public int $customer;
    public int $restaurant;
    public string $status;

    public function __construct(int $id, int $customer, int $restaurant, string $status)
    {
      $this->id = $id;
      $this->customer = $customer;
      $this->restaurant = $restaurant;
      $this->status = $status;
    }

    function save($db, string $status, int $id) {
      $stmt = $db->prepare('
        UPDATE OrderQueue SET Status = ?
        WHERE OrderId = ?
      ');

      $stmt->execute(array($status, $id));
    }    

    static function getOrder(PDO $db, int $id) : Order {
      $stmt = $db->prepare('SELECT OrderId, CustomerId, RestaurantId, Status
      FROM OrderQueue
      WHERE OrderId = ? 
      ');
      $stmt-> execute(array($id));

      $order = $stmt->fetch();
      return new Order($order["OrderId"], $order['CustomerId'], $order['RestaurantId'], $order['Status']);
    }

    static function getOrdersByUser(PDO $db, int $id) : array {
      $stmt = $db->prepare('SELECT OrderId, CustomerId, RestaurantId, Status
      FROM OrderQueue
      WHERE CustomerId = ? 
      ORDER BY OrderId DESC LIMIT 5');
      $stmt-> execute(array($id));

      $orders = array();
      while ($order = $stmt->fetch()) {
        $orders[] = new Order($order["OrderId"], $order['CustomerId'], $order['RestaurantId'], $order['Status']);
      }
      return $orders;
    }

    static function getOrdersByRestaurant(PDO $db, int $id) : array {
      $stmt = $db->prepare('SELECT OrderId, CustomerId, RestaurantId, Status
      FROM OrderQueue
      WHERE RestaurantId = ? 
      ORDER BY OrderId DESC');
      $stmt-> execute(array($id));

      $orders = array();
      while ($order = $stmt->fetch()) {
        $orders[] = new Order($order["OrderId"], $order['CustomerId'], $order['RestaurantId'], $order['Status']);
      }
      return $orders;
    }
  
  }
?>