<?php
  declare(strict_types = 1);

  require_once('../session/session.php');
  $session = new Session();
  
  require_once('../database/connection.db.php');
  require_once('../database/order.class.php');

  if ($_SESSION['csrf'] !== $_POST['csrf']) {
    http_response_code(405);
    require("../pages/error.php");
    die();
  }

  $db = getDatabaseConnection();

  $order = Order::getOrder($db, intval($_POST["object_id"]));

  $order->save($db, $_POST["status"], intval($_POST["object_id"]));
 
  $session->addMessage('success', "Order status updated successfully!");
  header("Location: ../pages/user.php");
?>