<?php
require_once('../database/menu.class.php');

require_once('../session/session.php');
$session = new Session();

require_once('../database/connection.db.php');
$db = getDatabaseConnection();

Menu::deleteMenu($db, $_POST['menu']);

$session->addMessage('success', "Menu deleted successfully!");
header("Location: ../pages/restaurant.php?id=" . $_POST['restaurant-id']);
?>