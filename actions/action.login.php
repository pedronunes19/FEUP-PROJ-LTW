<?php
  declare(strict_types = 1);

  require_once('../session/session.php');
  $session = new Session();
  
  require_once('../database/connection.db.php');
  require_once('../database/customer.class.php');
  require_once('../database/restaurantOwner.class.php');

  $db = getDatabaseConnection();
  $customer = Customer::getCustomerWithPassword($db, $_POST['email'], $_POST['password']);
  $owner = RestaurantOwner::getOwnerWithPassword($db, $_POST['email'], $_POST['password']);
  $type = $_POST['account-type'];

  if ($customer && ($type == "customer")) {
    $session->setId($customer->id);
    $session->setName($customer->name());
    $session->setType($type);
    $session->addMessage('success', "You're in! Welcome, customer " . $customer->name() . "!");
    header('Location: ../pages/index.php');
  } else if ($owner && ($type == "owner")) {
    $session->setId($owner->id);
    $session->setName($owner->name());
    $session->setType($type);
    $session->addMessage('success', "You're in! Welcome, owner " . $owner->name() . "!");
    header('Location: ../pages/index.php');
  } else {
    $session->addMessage('error', "Wrong email or password...");
    header('Location: ../pages/login.php');
  }
?>