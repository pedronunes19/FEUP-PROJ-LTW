<?php
    declare(strict_types = 1);

    require_once('../session/session.php');
    $session = new Session();
    
    require_once('../templates/common.temp.php');
    require_once('../templates/account.temp.php');
    require_once('../database/connection.db.php');

    $db = getDatabaseConnection();

    drawFormWrapper($session);
    drawLoginForm();
    drawFooter();
?>