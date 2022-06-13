<?php
  declare(strict_types = 1);

  require_once('../session/session.php');
  $session = new Session();
  
  require_once('../database/connection.db.php');
  require_once('../database/restaurantOwner.class.php');
  require_once('../database/dish.class.php');
  require_once('../database/category.class.php');

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
    $session->addMessage('error', "A dish cannot have more than one category with the same name!");
    header("Location: ../pages/user.php");
    die();
  }

  Dish::create($db, $_POST["name"], floatval($_POST["price"]), intval($_POST["restaurant-id"]));
  
  $dishes = Dish::getDishes($db, 0);
  $dish =  $dishes[count($dishes)-1];
  Category::addDishCategories($db, intval($_POST['category-1']), $dish->id);
  if ($_POST['category-2'] != "none") Category::addDishCategories($db, intval($_POST['category-2']), $dish->id);
  if ($_POST['category-3'] != "none") Category::addDishCategories($db, intval($_POST['category-3']), $dish->id);

  move_uploaded_file($_FILES["image"]["tmp_name"], "../images/dishes/" . $dish->id . ".png");
 
  $session->addMessage('success', "Dish created successfully!");
  header("Location: ../pages/restaurant.php?id=" . $dish->id);
?>