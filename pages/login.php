<?php
    declare(strict_types = 1);

    require_once('../templates/common.temp.php');
    require_once('../templates/account.temp.php');
    require_once('../database/connection.db.php');


?>

<?php
    drawFormWrapper();
    drawLoginForm();
    drawFooter();
?>