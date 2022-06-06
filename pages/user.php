<?php
    declare(strict_types = 1);
    require_once('../session/session.php');
    $session = new Session();


    require_once('../templates/common.temp.php');
    require_once('../database/connection.db.php');
    require_once('../templates/user.temp.php');
    

    $db = getDatabaseConnection();

    if ($session->getType() == "customer") $user = Customer::getCustomer($db, $session->getID());
    else $user = RestaurantOwner::getOwner($db, $session->getID());

    $orders = Order::getOrders($db, $user->id);

    drawHeader("../css/user.css",$session);
    drawUserPage($db, $user, $orders);
    drawFooter();
?>    
