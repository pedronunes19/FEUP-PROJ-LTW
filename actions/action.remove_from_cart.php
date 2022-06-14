<?php
require_once('../database/dish.class.php');

require_once('../session/session.php');
$session = new Session();

require_once('../database/connection.db.php');
$db = getDatabaseConnection();

$session->removeFromCart($_POST['type'], intval($_POST['id']));
header("Location: ../pages/cart.php");
?>