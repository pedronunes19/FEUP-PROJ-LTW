<?php declare(strict_types = 1); ?>
<?php function drawHeader() { ?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Take-away</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1><a href="/">TAKE-AWAY</a></h1>
        <?php drawLogin(); ?>
    </header>
    <main>
<?php } ?>

<?php function drawFooter() { ?>
    </main>
    <footer>
        <p class="left">Amazing take-away website for LTW, 2022</p>
        <p class="right">All rights reserved</p>
    </footer>
  </body>
</html>
<?php } ?>

<?php function drawLogin() { ?>
    <form action="action_login.php" method="post" class="login">
        <input type="text" name="username" placeholder="Your username here:">
        <input type="password" name="password" placeholder="Your password here:">
        <button type="submit">Login</button>
        <form>
            <button formaction="/">Register</button>
        </form>
    </form>
<?php } ?>