<?php
  declare(strict_types = 1);

  require_once('../session/session.php'); 
  $session = new Session();
  
  require_once('../database/connection.db.php');
  require_once('../database/customer.class.php');
  require_once('../database/restaurantOwner.class.php');

  $db = getDatabaseConnection();
  $customer = Customer::getCustomerWithEmail($db, $_POST['email']);
  $owner = RestaurantOwner::getOwnerWithEmail($db, $_POST['email']);

  if (($customer && ($_POST['account-type'] == "customer")) || ($owner && ($_POST['account-type'] == "owner"))) {
    $session->addMessage('error', "That email is already in use!");
    header("Location: ../pages/register.php");
  }
  else {
    if ($_POST['account-type'] == "customer") {
      Customer::create($db, $_POST["first-name"], $_POST["last-name"], $_POST["address"], $_POST["city"], $_POST["country"], $_POST["postal-code"], $_POST["phone-number"], $_POST["email"], $_POST["password"]);
      $user = Customer::getCustomerWithEmail($db, $_POST['email']);
    }
    else {
      RestaurantOwner::create($db, $_POST["first-name"], $_POST["last-name"], $_POST["address"], $_POST["city"], $_POST["country"], $_POST["postal-code"], $_POST["phone-number"], $_POST["email"], $_POST["password"]);
      $user = RestaurantOwner::getOwnerWithEmail($db, $_POST['email']);
    }
    $session->setId($user->id);
    $session->setName($user->name());
    $session->addMessage('success', "Account created! Don't worry, we logged in for you.");
    header("Location: ../pages/index.php");
  }
?>