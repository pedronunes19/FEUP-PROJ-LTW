<?php
require_once('../database/review.class.php');

require_once('../session/session.php');
$session = new Session();

require_once('../database/connection.db.php');
$db = getDatabaseConnection();

Review::deleteReview($db, $_POST['review']);

$session->addMessage('success', "Review deleted successfully!");
header("Location: ../pages/user.php");
?>