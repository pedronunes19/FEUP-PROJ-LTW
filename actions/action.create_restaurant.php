<?php
  declare(strict_types = 1);

  require_once('../session/session.php');
  $session = new Session();
  
  require_once('../database/connection.db.php');
  require_once('../database/restaurantOwner.class.php');
  require_once('../database/restaurant.class.php');
  require_once('../database/category.class.php');

  if ($_SESSION['csrf'] !== $_POST['csrf']) {
    http_response_code(405);
    require("../pages/error.php");
    die();
  }

  $db = getDatabaseConnection();

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
  }

  if (($_POST['category-1'] == $_POST['category-2']) || (($_POST['category-3'] == $_POST['category-2']) && $_POST['category-2'] != "none") || ($_POST['category-1'] == $_POST['category-3'])) {
    $session->addMessage('error', "A restaurant cannot have more than one category with the same name!");
    header("Location: ../pages/user.php");
    die();
  }

  Restaurant::create($db, htmlspecialchars($_POST["name"]), $_POST["address"], intval($_POST["owner-id"]));
  
  $restaurants = Restaurant::getRestaurants($db, 0);
  $restaurant =  $restaurants[count($restaurants)-1];
  Category::addRestaurantCategories($db, intval($_POST['category-1']), $restaurant->id);
  if ($_POST['category-2'] != "none") Category::addRestaurantCategories($db, intval($_POST['category-2']), $restaurant->id);
  if ($_POST['category-3'] != "none") Category::addRestaurantCategories($db, intval($_POST['category-3']), $restaurant->id);

  move_uploaded_file($_FILES["image"]["tmp_name"], "../images/restaurants/" . $restaurant->id . ".png");
 
  $session->addMessage('success', "Restaurant created successfully!");
  header("Location: ../pages/user.php");
?>