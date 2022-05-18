<?php
    declare(strict_types = 1);

    require_once('templates/common.temp.php');
    require_once('templates/restaurant.temp.php');
    require_once('database/connection.db.php');
    //require_once('templates/menus.temp.php');

    $db = getDatabaseConnection();

    $restaurants = Restaurant::getRestaurants($db, 14);

    $menus = array(
        array('id' => 1, 'name' => 'Menu 1'),
        array('id' => 2, 'name' => 'Menu 2'),
        array('id' => 3, 'name' => 'Menu 3')
    );

    drawHeader();
    drawRestaurants($restaurants);
    drawFooter();
?>