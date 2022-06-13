<?php
    declare(strict_types = 1);

    require_once('../session/session.php');
    $session = new Session();

    require_once('../templates/common.temp.php');
    require_once('../templates/restaurant.temp.php');
    require_once('../database/connection.db.php');
    //require_once('templates/menus.temp.php');

    $db = getDatabaseConnection();

    $restaurant_list = Restaurant::getRestaurants($db, 0);

    if (!isset($_SESSION['id'])) {
        $session->addMessage('error', "You must login to access the restaurant pages!");
        header("Location: ../pages/login.php");
        die();
    } 

    if ((intval($_GET['id']) <= 0) || (intval($_GET['id']) > count($restaurant_list))) {
        http_response_code(404);
        require("error.php");
        die();
    }

    $restaurant = Restaurant::getRestaurant($db, intval($_GET['id']));
    $menus = Menu::getRestaurantMenus($db, intval($_GET['id']));
    $dishes = Dish::getRestaurantDishes($db, intval($_GET['id']));
    $reviews = Review::getReviews($db, intval($_GET['id']));
    $categories = Category::getRestaurantCategories($db, intval($_GET['id']));

    drawHeader("../css/restaurant.css", $session);
    drawRestaurant($db, $restaurant, $menus, $dishes, $reviews, $categories, $session);
    drawFooter();
?>