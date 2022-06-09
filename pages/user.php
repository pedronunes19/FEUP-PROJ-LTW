<?php
    declare(strict_types = 1);
    require_once('../session/session.php');
    $session = new Session();


    require_once('../templates/common.temp.php');
    require_once('../database/connection.db.php');
    require_once('../templates/user.temp.php');
    

    $db = getDatabaseConnection();
    drawHeader("../css/user.css",$session);
    if ($session->getType() == "customer") {
        $user = Customer::getCustomer($db, $session->getID());
        $orders = Order::getOrdersByUser($db, $user->id);
        $restaurants = Customer::getfavoriteRestaurants($db, $user->id);
        $reviews = Review::getReviewsByUser($db, $user->id);

        drawUserPage($db, $session, $user);
        drawTables($db, $session, $restaurants, $orders, $reviews);
    }
    
    else {
        $user = RestaurantOwner::getOwner($db, $session->getID());
        $orders = Order::getOrdersByRestaurant($db, $user->id);
        $reviews = Review::getReviews($db, $user->id);
    }
    drawEditProfile($db, $session, $user);
    drawFooter();
?>    
