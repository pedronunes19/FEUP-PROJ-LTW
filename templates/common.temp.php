<?php declare(strict_types = 1); ?>
<?php function drawHeader(string $css) { ?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700;900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/eee7326786.js" crossorigin="anonymous"></script>
    <title>Take-away</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href=<?=$css?>>
</head>
<body>
    <header>
        <h1 class="logo-wrapper"><a class="no-select" id="logo" href=".">TAKE-AWAY</a></h1>
        <div class="topnav">
            <div class="search-container">
                <form action="restaurants.php"  class="search-form">
                <input type="text" placeholder="Search..." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
            </div>
        <?php drawButtonsNoLogin(); ?>
    </header>
    <main>
<?php } ?>

<?php function drawFooter() { ?>
    </main>
    <footer>
        <p class="left">Amazing take-away website for LTW, 2022</p>
        <p class="right">All rights reserved &copy</p>
    </footer>
  </body>
</html>
<?php } ?>

<?php function drawButtonsNoLogin() { ?>
    <a class="icon" href="/pages/login.php">
        <i class="fa-solid fa-right-to-bracket"></i>
    </a>
<?php } ?>