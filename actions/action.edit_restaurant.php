<?php
  declare(strict_types = 1);

  require_once('../session/session.php');
  $session = new Session();
  
  require_once('../database/connection.db.php');
  require_once('../database/restaurantOwner.class.php');
  require_once('../database/restaurant.class.php');

  $db = getDatabaseConnection();

  $restaurant = Restaurant::getRestaurant($db, intval($_POST["id"]));

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
      move_uploaded_file($_FILES["image"]["tmp_name"], "../images/restaurants/" . $restaurant->id . ".png");
    }
  }

  $restaurant->save($db, $_POST["name"], $_POST["address"], intval($_POST["owner-id"]), intval($_POST["id"]));
 
  $session->addMessage('success', "Restaurant edited successfully!");
  header("Location: ../pages/user.php");
?>