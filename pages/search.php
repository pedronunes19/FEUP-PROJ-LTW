<?php
    declare(strict_types = 1);

    require_once('../session/session.php');
    $session = new Session();

    require_once('../templates/common.temp.php');
    require_once('../templates/restaurant.temp.php');
    require_once('../database/connection.db.php');

    $db = getDatabaseConnection();
    $restaurants = Restaurant::searchRestaurants($db, $_GET['search'], $_GET['score'], 18);
    $dishes = Dish::searchDishes($db, $_GET['search'], 16);
    $categories = Category::getCategories($db);

    drawHeader("../css/search.css", $session);
    drawRestaurantSearch($restaurants, $dishes, $categories, $_GET['search']);
    drawFooter();
?>