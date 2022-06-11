<?php
    declare(strict_types = 1);

    require_once('../session/session.php');
    $session = new Session();
    
    require_once('../templates/common.temp.php');
    require_once('../templates/account.temp.php');
    require_once('../database/connection.db.php');

    $db = getDatabaseConnection();

    if (isset($_SESSION['id'])) {
        http_response_code(404);
        require("error.php");
        die();
    }

    drawFormWrapper("../css/account.css", $session);
    drawRegisterForm();
    drawFooter();
?>