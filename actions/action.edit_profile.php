<?php
  declare(strict_types = 1);

  require_once('../session/session.php');
  $session = new Session();
  
  require_once('../database/connection.db.php');
  require_once('../database/customer.class.php');
  require_once('../database/restaurantOwner.class.php');

  if ($_SESSION['csrf'] !== $_POST['csrf']) {
    http_response_code(405);
    require("../pages/error.php");
    die();
  }

  $db = getDatabaseConnection();
  $type = $session->getType();
  $type == "customer" ? $user = Customer::getCustomer($db, $session->getId()) : $user = RestaurantOwner::getOwner($db, $session->getId());

  if (strlen($_FILES["image"]["tmp_name"]) != 0) {
    $verify_image = getimagesize($_FILES["image"]["tmp_name"]);
    if ($verify_image == false) {
      $session->addMessage('error', "The file submitted is not a supported image format!");
      header("Location: ../pages/user.php");
      die();
    } 

    if ($_FILES["image"]["size"] > 10000000) {
      $session->addMessage('error', "The file submitted is too large! (maximum ~10 MB)");
      header("Location: ../pages/user.php");
      die();
    }
    
    else {
      move_uploaded_file($_FILES["image"]["tmp_name"], "../images/" . $type . "s/" . $user->id . ".png");
    }
  }


  $user->save($db, htmlspecialchars($_POST["first-name"]), htmlspecialchars($_POST["last-name"]), htmlspecialchars($_POST["address"]), htmlspecialchars($_POST["city"]), htmlspecialchars($_POST["country"]), htmlspecialchars($_POST["postal-code"]), htmlspecialchars($_POST["phone-number"]), htmlspecialchars($_POST["email"]), $_POST["password"], $session->getId());
 
  $session->setName($user->name());
  $session->addMessage('success', "Profile edited successfully!");
  header("Location: ../pages/user.php");
?>