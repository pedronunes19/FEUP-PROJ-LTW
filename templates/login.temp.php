<?php declare(strict_types = 1); ?>
<?php function drawLoginWrapper() { ?>
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
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
<main>
<?php } ?>

<?php function drawLoginForm() { ?>
<form action="#!" id="login-form">
<h1 class="logo-wrapper"><a class="no-select" id="logo" href=".">TAKE-AWAY</a></h1>
<div class="text-field">
    <label for="username">Username</label>
    <input type="text" id="username" placeholder="jamesdoe">
</div>

<div class="text-field">
    <label for="password">Password</label>
    <input type="password" id="password" placeholder="123">
</div>

<div id="button-register-wrapper">
    <button type="submit">Login</button>
    <a href=".">Don't have an account? Click here!</a>
</div>
</form>
<?php } ?>