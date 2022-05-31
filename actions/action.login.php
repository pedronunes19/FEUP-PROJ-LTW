<?php
  declare(strict_types = 1);

  require_once('../session/session.php');
  $session = new Session();
  
  require_once('../database/connection.db.php');
  require_once('../database/customer.class.php');

  $db = getDatabaseConnection();
  $customer = Customer::getCustomerWithPassword($db, $_POST['email'], $_POST['password']);
  
  if ($customer) {
    $session->setId($customer->id);
    $session->setName($customer->name());
    $session->addMessage('success', "You're in!");
  } else {
    $session->addMessage('error', "Wrong email or password...");
  }

  header('Location: ../pages/index.php');
?>