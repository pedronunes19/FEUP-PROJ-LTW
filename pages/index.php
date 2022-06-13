<?php
    declare(strict_types = 1);
    require_once('../session/session.php');
    $session = new Session();

    require_once('../templates/common.temp.php');
    require_once('../templates/restaurant.temp.php');
    require_once('../database/connection.db.php');
    //require_once('templates/menus.temp.php');

    $db = getDatabaseConnection();
    $restaurants = Restaurant::getRestaurants($db, 0);

    $menus = Menu::getMenus($db, 14);

    drawHeader("../css/style.css", $session);
    drawRestaurantsSlideshow(Restaurant::getRestaurants($db, 5));
    drawRestaurants($restaurants);
    drawFooter();
?>