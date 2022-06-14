<?php
  declare(strict_types = 1);

  require_once('../session/session.php');
  $session = new Session();

  if ($_SESSION['csrf'] !== $_POST['csrf']) {
    http_response_code(405);
    require("../pages/error.php");
    die();
  }
  
  $session->logout();

  header('Location: ..');
?>
