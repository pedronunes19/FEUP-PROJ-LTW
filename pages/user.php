<?php
    declare(strict_types = 1);
    require_once('../session/session.php');
    $session = new Session();


    require_once('../templates/common.temp.php');
    require_once('../database/connection.db.php');
    require_once('../templates/user.temp.php');
    

    $db = getDatabaseConnection();

    $customer = Customer::getCustomer($db,intval($_GET['id']));

    drawHeader("../css/user.css",$session);
    drawUserPage($customer);
    drawFooter();
?>    
