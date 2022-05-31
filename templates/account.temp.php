<?php 
    declare(strict_types = 1);
    require_once('../session/session.php'); 
?>

<?php function drawFormWrapper(Session $session) { ?>
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
    <link rel="stylesheet" href="../css/account.css">
</head>
<body>
    <section id="session-messages">
      <?php foreach ($session->getMessages() as $message) { ?>
        <article class="<?=$message['type']?>">
          <?=$message['text']?>
        </article>
      <?php } ?>
    </section>
    <main>
<?php } ?>

<?php function drawLoginForm() { ?>
    <form action="../actions/action.login.php" method="post" class="login-register-form">
        <h1 class="logo-wrapper"><a class="no-select logo" href=".">TAKE-AWAY</a></h1>
        <div class="input-field">
            <label for="email">Email</label>
            <input id="login_email" type="text" name="email" placeholder="jamesdoe@goodmail.com" required>
        </div>

        <div class="input-field">
            <label for="password">Password</label>
            <input id="login_password" type="password" name="password" placeholder="123" required minlength=10>
        </div>

        <div class="button-page-swap-wrapper">
            <button type="submit">Login</button>
            <span>
                <a class="account-page-switch" href="../pages/register.php">Don't have an account? Click here!</a>
            </span>
        </div>
    </form>
<?php } ?>

<?php function drawRegisterForm() { ?>
    <form action="../actions/action.register.php" onsubmit="return address_requirement_toggle()" class="login-register-form" method="post">
        <h1 class="logo-wrapper"><a class="no-select logo" href=".">TAKE-AWAY</a></h1>

        <div class="input-field">
            <label for="first-name">First Name *</label>
            <input class="register_required" type="text" name="first-name" placeholder="James" required>
        </div>

        <div class="input-field">
            <label for="last-name">Last Name *</label>
            <input class="register_required" type="text" name="last-name" placeholder="Doe" required>
        </div>

        <div class="input-field">
            <label for="address">Address **</label>
            <input class="register_required" id="requirement-toggle-field" type="text" name="address" placeholder="Doe Street, 77">
        </div>

        <div class="input-field">
            <label for="city">City</label>
            <input class="register_optional" type="text" name="city" placeholder="Doe City">
        </div>

        <div class="input-field">
            <label for="country">Country</label>
            <input class="register_optional" type="text" name="country" placeholder="Doeland">
        </div>

        <div class="input-field">
            <label for="postal-code">Postal Code</label>
            <input class="register_optional" type="text" name="postal-code" placeholder="4470-123" size="8">
        </div>

        <div class="input-field">
            <label for="phone-number">Phone Number</label>
            <input class="register_optional" type="tel" name="phone-number" placeholder="912345678" size="9">
        </div>

        <div class="input-field">
            <label for="email">Email *</label>
            <input class="register_required" type="text" name="email" placeholder="jamesdoe@goodmail.com" required>
        </div>

        <div class="input-field">
            <label for="password">Password *</label>
            <input class="register_required" type="password" name="password" placeholder="123" required minlength=10>
        </div>

        <div class="input-field">
            <label for="account-type">Account Type *</label>
            <select class="register_required" id="account-type" name="account-type" required>
                <option value="customer">Customer</option>
                <option value="owner">Owner</option>
            </select>
        </div>

        <div class="asterisk-info">
            <a class="text-info">* - Required field<br></a>
            <a class="text-info">** - Required when creating a Customer account</a>
        </div> 

        <div class="button-page-swap-wrapper">
            <button type="submit">Register</button>
            <span>
                <a class="account-page-switch" href="../pages/login.php">Already have an account? Click here!</a>
            </span>
        </div>
    </form>
    <script src="../scripts/account.js"></script> 
<?php } ?>

