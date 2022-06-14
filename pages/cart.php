<?php
    declare(strict_types = 1);

    require_once('../session/session.php');
    $session = new Session();
    
    require_once('../templates/common.temp.php');
    require_once('../templates/account.temp.php');
    require_once('../templates/cart.temp.php');
    require_once('../database/connection.db.php');

    $db = getDatabaseConnection();

    if (!isset($_SESSION['id']) || $session->getType() == "owner") {
        http_response_code(404);
        require("error.php");
        die();
    }

    if ($_SESSION['items'] == null){
        $session->addMessage('error', "Your cart is empty!");
        header("Location: ..");
        die();
    }

    drawHeader("../css/restaurant.css", $session);
    drawCheckout($db, $session);
    drawFooter();
?>