<?php
  declare(strict_types = 1);

  require_once('../session/session.php');
  $session = new Session();
  
  require_once('../database/connection.db.php');
  require_once('../database/restaurant.class.php');
  require_once('../database/review.class.php');
  require_once('../database/order.class.php');

  $db = getDatabaseConnection();

  Order::create($db, intval($_POST["customer-id"]), intval($_POST["restaurant-id"]), "Received");
 
  $session->addMessage('success', "Your order has been placed! Thank you for your purchase!");
  $session->resetCart();
  header("Location: ../pages/index.php");
?>