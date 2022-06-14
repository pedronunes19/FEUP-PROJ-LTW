<?php
require_once('../database/dish.class.php');

require_once('../session/session.php');
$session = new Session();

require_once('../database/connection.db.php');

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    http_response_code(405);
    require("../pages/error.php");
    die();
}

$db = getDatabaseConnection();

Dish::deleteDish($db, $_POST['dish']);

$session->addMessage('success', "Dish deleted successfully!");
header("Location: ../pages/restaurant.php?id=" . $_POST['restaurant-id']);
?>