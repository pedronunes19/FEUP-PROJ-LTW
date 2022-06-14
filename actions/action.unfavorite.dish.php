<?php
require_once('../database/customer.class.php');

require_once('../session/session.php');
$session = new Session();

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    http_response_code(405);
    require("../pages/error.php");
    die();
}

require_once('../database/connection.db.php');
$db = getDatabaseConnection();
Customer::getCustomer($db, $session->getId())->unFavoriteDish($db, $_POST['dish'])?>
