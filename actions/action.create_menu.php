<?php
  declare(strict_types = 1);

  require_once('../session/session.php');
  $session = new Session();
  
  require_once('../database/connection.db.php');
  require_once('../database/restaurantOwner.class.php');
  require_once('../database/menu.class.php');
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
    $session->addMessage('error', "A menu cannot have more than one category with the same name!");
    header("Location: ../pages/restaurant.php?id=" . $_POST['restaurant-id']);
    die();
  }

  if (($_POST['menu-dish-1'] == $_POST['menu-dish-2']) || (($_POST['menu-dish-3'] == $_POST['menu-dish-2']) && $_POST['menu-dish-2'] != "none") || ($_POST['menu-dish-1'] == $_POST['menu-dish-3'])) {
    $session->addMessage('error', "A menu cannot be built with two equal dishes!");
    header("Location: ../pages/restaurant.php?id=" . $_POST['restaurant-id']);
    die();
  }

  Menu::create($db, htmlspecialchars($_POST["name"]), floatval($_POST["price"]), intval($_POST["restaurant-id"]));
  $menus = Menu::getMenus($db, 0);
  $menu =  $menus[count($menus)-1];

  $menu->addMenuDishes($db, intval($_POST['menu-dish-1']));
  if ($_POST['menu-dish-2'] != "none")  $menu->addMenuDishes($db, intval($_POST['menu-dish-2']));
  if ($_POST['menu-dish-3'] != "none")  $menu->addMenuDishes($db, intval($_POST['menu-dish-3']));

  Category::addMenuCategories($db, intval($_POST['category-1']), $menu->id);
  if ($_POST['category-2'] != "none") Category::addMenuCategories($db, intval($_POST['category-2']), $menu->id);
  if ($_POST['category-3'] != "none") Category::addMenuCategories($db, intval($_POST['category-3']), $menu->id);

  move_uploaded_file($_FILES["image"]["tmp_name"], "../images/menus/" . $menu->id . ".png");
 
  $session->addMessage('success', "Menu created successfully!");
  header("Location: ../pages/restaurant.php?id=" . $_POST['restaurant-id']);
?>