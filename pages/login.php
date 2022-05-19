<?php
    declare(strict_types = 1);

    require_once('../templates/common.temp.php');
    require_once('../templates/login.temp.php');
    require_once('../database/connection.db.php');


?>

<?php
    drawLoginWrapper();
    drawLoginForm();
    drawFooter();
?>