<?php
  declare(strict_types = 1);

  require_once('../session/session.php');
  $session = new Session();
  
  require_once('../database/connection.db.php');
  require_once('../database/customer.class.php');
  require_once('../database/restaurantOwner.class.php');

  $db = getDatabaseConnection();
  $type = $session->getType();
  $type == "customer" ? $user = Customer::getCustomer($db, $session->getId()) : $user = RestaurantOwner::getOwner($db, $session->getId());

  $user->save($db, $_POST["first-name"], $_POST["last-name"], $_POST["address"], $_POST["city"], $_POST["country"], $_POST["postal-code"], $_POST["phone-number"], $_POST["email"], $_POST["password"], $session->getId());
 
  $session->setName($user->name());
  $session->addMessage('success', "Profile edited successfully!");
  header("Location: ../pages/user.php");
?>