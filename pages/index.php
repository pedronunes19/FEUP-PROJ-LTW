<?php
    declare(strict_types = 1);

    require_once('../templates/common.temp.php');
    require_once('../templates/restaurant.temp.php');
    require_once('../database/connection.db.php');
    //require_once('templates/menus.temp.php');

    $db = getDatabaseConnection();

    $restaurants = Restaurant::getRestaurants($db, 14);

    $menus = Menu::getMenus($db, 14);

    drawHeader();
    drawRestaurants($restaurants);
    drawFooter();
?>