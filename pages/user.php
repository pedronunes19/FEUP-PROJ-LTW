<?php
    declare(strict_types = 1);
    require_once('../session/session.php');
    $session = new Session();


    require_once('../templates/common.temp.php');
    require_once('../database/connection.db.php');
    require_once('../templates/user.temp.php');
    

    $db = getDatabaseConnection();

    if ($session->getType() == "customer") {
        $user = Customer::getCustomer($db, $session->getID());
        $orders = Order::getOrdersByUser($db, $user->id);
        $restaurants = Customer::getfavoriteRestaurants($db, $user->id);
        $reviews = Review::getReviewsByUser($db, $user->id);
    }
    else {
        $user = RestaurantOwner::getOwner($db, $session->getID());
        $orders = Order::getOrdersByRestaurant($db, $user->id);
        $restaurants = Restaurant::getRestaurantsByOwner($db, $user->id);
        $reviews = array();
        $review_aux = array();
        foreach ($restaurants as $restaurant) {
            $review_aux = Review::getReviews($db, $restaurant->id);
            if (count($review_aux) != 0) {
                foreach ($review_aux as $review) {
                    array_push($reviews, $review);
                }
            }
        }
    }

    drawHeader("../css/user.css",$session);
    drawUserPage($db, $session, $user);
    drawTables($db, $session, $restaurants, $orders, $reviews);
    drawEditProfile($db, $session, $user);
    drawFooter();
?>    
