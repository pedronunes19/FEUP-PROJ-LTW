<?php
  declare(strict_types = 1);

  require_once('../session/session.php');
  $session = new Session();
  
  require_once('../database/connection.db.php');
  require_once('../database/restaurant.class.php');
  require_once('../database/review.class.php');

  if ($_SESSION['csrf'] !== $_POST['csrf']) {
    http_response_code(405);
    require("../pages/error.php");
    die();
  }

  $db = getDatabaseConnection();

  $review = Review::getReview($db, intval($_POST["id"]));

  $review->save($db, $review->score, $review->content, htmlspecialchars($_POST['response']), intval($_POST["id"]));
 
  $session->addMessage('success', "Response registered successfully!");
  header("Location: ../pages/user.php");
?>