<?php
require_once('../database/customer.class.php');

require_once('../session/session.php');
$session = new Session();

require_once('../database/connection.db.php');
$db = getDatabaseConnection();

Customer::getCustomer($db, $session->getId())->unFavoriteRestaurant($db, $_POST['restaurant'])?>