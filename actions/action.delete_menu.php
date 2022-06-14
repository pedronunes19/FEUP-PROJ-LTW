<?php
require_once('../database/menu.class.php');

require_once('../session/session.php');
$session = new Session();

require_once('../database/connection.db.php');

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    http_response_code(405);
    require("../pages/error.php");
    die();
}

$db = getDatabaseConnection();

Menu::deleteMenu($db, $_POST['menu']);

$session->addMessage('success', "Menu deleted successfully!");
header("Location: ../pages/restaurant.php?id=" . $_POST['restaurant-id']);
?>