<?php
    declare(strict_types = 1);

    require_once('../session/session.php');
    $session = new Session();

    require_once('../templates/common.temp.php');
    require_once('../templates/restaurant.temp.php');
    require_once('../database/connection.db.php');
    //require_once('templates/menus.temp.php');

    $db = getDatabaseConnection();

    $restaurant = Restaurant::getRestaurant($db, intval($_GET['id']));
    $menus = Menu::getRestaurantMenus($db, intval($_GET['id']));
    $dishes = Dish::getRestaurantDishes($db, intval($_GET['id']));
    $reviews = Review::getReviews($db, intval($_GET['id']));

    drawHeader("../css/restaurant.css", $session);
    drawRestaurant($db, $restaurant, $menus, $dishes, $reviews);
    drawFooter();
?>