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

$items = $session->getItems();

if ($items != null){
    foreach ($items as $item) {
        if ($item['restaurant'] != $_POST['restaurant-id']){
            $session->addMessage('error', "You cannot order food from different restaurants at once!");
            header("Location: ../pages/restaurant.php?id=" . $_POST['restaurant-id']);
            die();
        }
    }
    foreach ($items as $item) {
        if (($item['type'] == $_POST['type']) && ($item['id'] == $_POST['id'])) {
            $index = array_search($item, $session->getItems());
            $session->incrementAmount($index, $item['amount']);
            $session->addMessage('success', "Item(s) added to cart!");
            header("Location: ../pages/restaurant.php?id=" . $_POST['restaurant-id']);
            die();
        }
    }
}

$session->addToCart($_POST['type'], $_POST['id'], $_POST['amount'], $_POST['restaurant-id']);
$session->addMessage('success', "Item(s) added to cart!");
header("Location: ../pages/restaurant.php?id=" . $_POST['restaurant-id']);
?>