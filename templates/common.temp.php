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
      <?php } ?>
    </section>
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
    <form class="icon" action="../pages/login.php">
        <button class="icon" type="submit">
            <i class="fa-solid fa-right-to-bracket"></i>
        </button>
    </form>
<?php } ?>

<?php function drawButtonsLogin() { ?>
    <form class="icon" action="../pages/user.php">
        <button class="icon">
            <i class="fa-solid fa-circle-user"></i>
        </button>
    </form>
    <form class="icon" action="../actions/action.logout.php" method="post">
        <button class="icon" type="submit">
            <i class="fa-solid fa-right-from-bracket"></i>
        </button>
    </form>
<?php } ?>