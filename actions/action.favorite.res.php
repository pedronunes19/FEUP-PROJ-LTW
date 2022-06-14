<?php
require_once('../database/customer.class.php');

require_once('../session/session.php');
$session = new Session();

require_once('../database/connection.db.php');

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    http_response_code(405);
    require("../pages/error.php");
    die();
}

$db = getDatabaseConnection();

Customer::getCustomer($db, $session->getId())->favoriteRestaurant($db, $_POST['restaurant'])?>