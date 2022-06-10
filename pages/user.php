<?php
    declare(strict_types = 1);
    require_once('../session/session.php');
    $session = new Session();


    require_once('../templates/common.temp.php');
    require_once('../database/connection.db.php');
    require_once('../templates/user.temp.php');
    
    if (!isset($_SESSION['id'])) {
        http_response_code(404);
        require("error.php");
        die();
    }

    $db = getDatabaseConnection();

    if ($session->getType() == "customer") {
        $user = Customer::getCustomer($db, $session->getID());
        $orders = Order::getOrdersByUser($db, $user->id);
        $restaurants = Customer::getfavoriteRestaurants($db, $user->id);
        $reviews = Review::getReviewsByUser($db, $user->id);
    }
    else {
        $user = RestaurantOwner::getOwner($db, $session->getID());
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
        $orders = array();
        $orders_aux = array();
        foreach ($restaurants as $restaurant) {
            $orders_aux = Order::getOrdersByRestaurant($db, $restaurant->id);
            if (count($orders_aux) != 0) {
                foreach ($orders_aux as $order) {
                    array_push($orders, $order);
                }
            }
        }
    }

    drawHeader("../css/user.css",$session);
    drawUserPage($db, $session, $user);
    drawSeparateCards($db, $session, $restaurants, $orders, $reviews);
    drawEditProfile($db, $session, $user);
    drawFooter();
?>    
