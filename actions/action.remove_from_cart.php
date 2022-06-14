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

$session->removeFromCart($_POST['type'], intval($_POST['id']));
header("Location: ../pages/cart.php");
?>