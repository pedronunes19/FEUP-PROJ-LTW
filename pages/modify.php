<?php
    declare(strict_types = 1);

    require_once('../session/session.php');
    $session = new Session();
    
    require_once('../templates/common.temp.php');
    require_once('../templates/account.temp.php');
    require_once('../database/connection.db.php');
    require_once('../templates/modify.temp.php');

    $db = getDatabaseConnection();

    if (!isset($_SESSION['id'])) {
        http_response_code(404);
        require("error.php");
        die();
    }

    $object_id = intval($_POST['object_id']);

    drawHeader("../css/user.css", $session);
    switch ($_POST["modify_type"]) {
        case "restaurant":
            drawRestaurantForm($db, $session, $object_id);
        case "review":
            drawReviewForm($db, $session, $object_id);
        default:
            break;
    }
    drawFooter();
?>