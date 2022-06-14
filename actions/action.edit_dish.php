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
      header("Location: ../pages/restaurant.php?id=" . $_POST['restaurant-id']);
      die();
    } 

    if ($_FILES["image"]["size"] > 10000000) {
      $session->addMessage('error', "The file submitted is too large! (maximum ~10 MB)");
      header("Location: ../pages/restaurant.php?id=" . $_POST['restaurant-id']);
      die();
    }
  }

  if (($_POST['category-1'] == $_POST['category-2']) || (($_POST['category-3'] == $_POST['category-2']) && $_POST['category-2'] != "none") || ($_POST['category-1'] == $_POST['category-3'])) {
    $session->addMessage('error', "A dish cannot have more than one category with the same name!");
    header("Location: ../pages/restaurant.php?id=" . $_POST['restaurant-id']);
    die();
  }

  $dish = Dish::getDish($db, intval($_POST['id']));
  $dish->save($db, htmlspecialchars($_POST["name"]), floatval($_POST["price"]), intval($_POST["id"]));

  Category::deleteDishCategories($db, intval($_POST['id']));
  Category::addDishCategories($db, intval($_POST['category-1']), intval($_POST['id']));
  if ($_POST['category-2'] != "none") Category::addDishCategories($db, intval($_POST['category-2']), intval($_POST['id']));
  if ($_POST['category-3'] != "none") Category::addDishCategories($db, intval($_POST['category-3']), intval($_POST['id']));

  move_uploaded_file($_FILES["image"]["tmp_name"], "../images/dishes/" . $dish->id . ".png");
 
  $session->addMessage('success', "Dish edited successfully!");
  header("Location: ../pages/restaurant.php?id=" . $_POST['restaurant-id']);
?>