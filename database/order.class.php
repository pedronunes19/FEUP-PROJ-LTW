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

    static function getOrders(PDO $db, int $id) : array {
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
  
  }
?>