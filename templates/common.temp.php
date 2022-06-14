<?php declare(strict_types = 1); 
require_once('../session/session.php');
?>

<?php function drawHeader(string $css, Session $session) { ?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700;900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/eee7326786.js" crossorigin="anonymous"></script>
    <script src="../scripts/close.js" defer></script>
    <title>Take-away</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href=<?=$css?>>
</head>
<body>
    <header>
        <h1 class="logo-wrapper"><a class="no-select logo" href=".">TAKE-AWAY</a></h1>
        <div class="topnav">
            <div class="search-container">
                <form action="search.php"  class="search-form">
                    <input type="text" placeholder="Search..." name="search">
                    <button class="button" type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
        <?php 
            if ($session->isLoggedIn()) drawButtonsLogin($session);
            else drawButtonsNoLogin();
        ?>
    </header>
    <section id="session-messages">
        <?php foreach ($session->getMessages() as $message) { ?>
        <article class="<?=$message['type']?>">
            <?=$message['text']?>
        </article>
        <button class="button close-button">close</button>
        <?php } ?>
    </section>
    <main>
<?php } ?>

<?php function drawFooter() { ?>
    </main>
    <footer>
        <p>Amazing take-away website for LTW, 2022. All rights reserved &copy</p>
    </footer>
  </body>
</html>
<?php } ?>

<?php function drawButtonsNoLogin() { ?>
    <div class="icon-wrapper">
        <div class="icon">
            <a class = "icon-area" href="../pages/login.php">
                <button class="icon">
                    <i class="fa-solid fa-right-to-bracket"></i>
                </button>
            </a>
        </div>
    </div>
<?php } ?>

<?php function drawButtonsLogin($session) { ?>
    <div class="icon-wrapper">
        <div class="icon">
            <a class = "icon-area" href="../pages/user.php">
                <button class="icon">
                    <i class="fa-solid fa-circle-user"></i>
                </button>
            </a>
        </div>
        <form class="logout-form" action="../actions/action.logout.php" method="post">
            <div class="icon">
            <button class="icon logout-icon" type="submit">
                <i class="fa-solid fa-right-from-bracket"></i>
            </button>
            </div>
        </form>
        <?php if ($session->getType() == "customer") { ?>
        <div class="icon">
            <a class = "icon-area" href="../pages/cart.php">
                <button class="icon">
                    <i class="fa-solid fa-cart-shopping"></i>
                </button>
            </a>
        </div>
        <?php } ?>
    </div>
<?php } ?>