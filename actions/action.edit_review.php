<?php
  declare(strict_types = 1);

  require_once('../session/session.php');
  $session = new Session();
  
  require_once('../database/connection.db.php');
  require_once('../database/restaurant.class.php');
  require_once('../database/review.class.php');

  $db = getDatabaseConnection();

  $review = Review::getReview($db, intval($_POST["id"]));

  $review->save($db, intval($_POST["score"]), $_POST["content"], intval($_POST["id"]));
 
  $session->addMessage('success', "Review edited successfully!");
  header("Location: ../pages/user.php");
?>