<?php
  declare(strict_types = 1);

  require_once('../session/session.php');
  $session = new Session();
  
  require_once('../database/connection.db.php');
  require_once('../database/restaurant.class.php');
  require_once('../database/review.class.php');

  $db = getDatabaseConnection();

  Review::create($db, intval($_POST["score"]), $_POST["content"], intval($_POST["user-id"]), intval($_POST["restaurant"]));
 
  $session->addMessage('success', "Review created successfully!");
  header("Location: ../pages/user.php");
?>