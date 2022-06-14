<?php
require_once('../database/restaurant.class.php');

require_once('../session/session.php');
$session = new Session();

require_once('../database/connection.db.php');

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    http_response_code(405);
    require("../pages/error.php");
    die();
}

$db = getDatabaseConnection();

Restaurant::deleteRestaurant($db, $_POST['restaurant']);

$session->addMessage('success', "Restaurant deleted successfully!");
header("Location: ../pages/user.php");
?>