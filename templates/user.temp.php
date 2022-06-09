<?php
    declare(strict_types = 1);
    require_once('../database/customer.class.php');
    require_once('../database/restaurantOwner.class.php');
    require_once('../database/dish.class.php');
    require_once('../database/restaurant.class.php');
    require_once('../database/order.class.php');
    require_once('../database/review.class.php');
?>

<?php function drawUserPage($db, $session, $user) { ?>
    <h1 class = "greeting"> Hello, <?=$user->first_name?> <?=$user->last_name?>!</h1>
    <div class ='container'>
        <div class="card picture-card">
            <img class="profile-img" src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="User">
        </div>
        <div class="card intro-card">
            <div class="section-wrapper">
                <h4 class="section-title">Name</h4>
                <div class="section-text"><?=$user->first_name?> <?=$user->last_name?></div>
            </div>
            <div class="section-wrapper">
                <h4 class="section-title">Address</h4>
                <?php $user->address == "" ? $address = "Address: None" : $address = $user->address?>
                <?php $user->postal_code == "" ? $postal_code = "Postal code: None" : $postal_code = $user->postal_code?>
                <?php $user->city == "" ? $city = "City: None" : $city = $user->city?>
                <?php $user->country == "" ? $country = "Country: None" : $country = $user->country?>
                <div class="section-text"><?=$address?></div>
                <div class="section-text"><?=$postal_code?></div>
                <div class="section-text"><?=$city?></div>
                <div class="section-text"><?=$country?></div>
            </div>
            <div class="section-wrapper">
                <h4 class="section-title">Email</h4>
                <div class="section-text"><?=$user->email?></div>
            </div>
            <div class="section-wrapper">
                <h4 class="section-title">Phone Number</h4>
                <?php $user->phone == "" ? $phone = "None" : $phone = $user->phone?>
                <div class="section-text"><?=$phone?></div>
            </div>
        </div>
<?php } ?>
        
<?php function drawEditProfile($db, $session, $user) { ?>
    <div class="card edit-card">
        <h4 class="section-title order-title">Edit profile</h4>
        <form action="../actions/action.edit_profile.php" method="post">
            <div class="input-field">
                <label for="first-name">First Name *</label>
                <input class="register_required" type="text" name="first-name" placeholder="James" value="<?=$user->first_name?>" required>
            </div>

            <div class="input-field">
                <label for="last-name">Last Name *</label>
                <input class="register_required" type="text" name="last-name" placeholder="Doe" value="<?=$user->last_name?>" required>
            </div>

            <div class="input-field">
            <?php if ($session->getType() == "customer") { ?>
                <label for="address">Address *</label>
                <input class="register_required" type="text" name="address" placeholder="Doe Street, 77" value="<?=$user->address?>" required>
            <?php } else { ?>
                <label for="address">Address</label>
                <input class="register_optional" type="text" name="address" placeholder="Doe Street, 77" value="<?=$user->address?>">
            <?php } ?>
            </div>

            <div class="input-field">
                <label for="postal-code">Postal Code</label>
                <input class="register_optional" type="text" name="postal-code" placeholder="4470-123" minlength="8" maxlength="8" value="<?=$user->postal_code?>">
            </div>

            <div class="input-field">
                <label for="city">City</label>
                <input class="register_optional" type="text" name="city" placeholder="Doe City" value="<?=$user->city?>">
            </div>

            <div class="input-field">
                <label for="country">Country</label>
                <input class="register_optional" type="text" name="country" placeholder="Doeland" value="<?=$user->country?>">
            </div>

            <div class="input-field">
                <label for="phone-number">Phone Number</label>
                <input class="register_optional" type="tel" name="phone-number" placeholder="912345678" minlength="9" maxlength="9" value="<?=$user->phone?>">
            </div>

            <div class="input-field">
                <label for="email">Email *</label>
                <input class="register_required" type="text" name="email" placeholder="jamesdoe@goodmail.com" value="<?=$user->email?>" required>
            </div>

            <div class="input-field">
                <label for="password">Password *</label>
                <input class="register_required" type="password" name="password" placeholder="123" required minlength=10>
            </div>

            <div class="asterisk-info">
                <a class="text-info">* - Required field<br></a>
            </div> 
            <div class="button-wrapper">
                <button class="button edit-button" type="submit">Edit information</button>
            </div>
        </form>
    </div>
</div>
<?php } ?>

<?php function drawTables($db, $session, array $restaurants, array $orders, array $reviews) { ?>
    <div class="card table-card">
        <?php if ($session->getType() == "customer") {
            drawUserOrders($db, $orders);
            drawFavoriteRestaurants($db, $restaurants);
            drawReviewsByUser($db, $reviews);
        } ?>
    </div>
<?php } ?>

<?php function drawReviewsByUser($db, array $reviews) { ?>
    <h4 class="section-title">Your Reviews</h4>
    <?php if (count($reviews) == 0) { ?>
        <div class="empty-section-wrapper">
            <div class="empty-section-text">No reviews yet. Your opinion is valuable!</div>
        </div>
    <?php } 
    else { ?>
    <table class="table restaurant-table">
        <thead class="table-header-list">
            <tr>
                <th class="table-header">Restaurant Name</th>
                <th class="table-header">Review Content</th>
                <th class="table-header">Review Score</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($reviews as $review) { 
            $restaurant = Restaurant::getRestaurant($db, $review->restaurant);
            $restaurant_name = $restaurant->name;
        ?>
            <tr>
                <td class="table-cell"><?=$restaurant_name?></td>
                <td class="table-cell"><?=$review->content?></td>
                <td class="table-cell"><?=$review->score?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } ?>
<?php } ?> 

<?php function drawFavoriteRestaurants($db, array $restaurants) { ?>
    <h4 class="section-title">Favorite Restaurants</h4>
    <table class="table restaurant-table">
        <thead class="table-header-list">
            <tr>
                <th class="table-header">Restaurant Name</th>
                <th class="table-header">Restaurant Address</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($restaurants as $restaurant) { ?>
            <tr>
                <td class="table-cell"><?=$restaurant->name?></td>
                <td class="table-cell"><?=$restaurant->address?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } ?>

<?php function drawUserOrders($db, array $orders) { ?>
    <h4 class="section-title">Order history</h4>
    <table class="table order-table">
        <thead class="table-header-list">
            <tr>
                <th class="table-header">Restaurant Name</th>
                <th class="table-header">Status</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $order) { 
            $restaurant = Restaurant::getRestaurant($db, $order->restaurant)?>
            <tr>
                <td class="table-cell"><?=$restaurant->name?></td>
                <td class="table-cell"><?=$order->status?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } ?>

<!--
    <div class = 'main-body'>
            <div class="row gutters-sm">
                    <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                        <div class="intro-card">
                            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="User" class="rounded-circle" width="150">
                            <div class="mt-3">
                            <h4><=$customer->first_name?> <=$customer->last_name?></h4>
                            <p class="text-muted font-size-sm"><=$customer->address?></p>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="card">
                        <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github mr-2 icon-inline"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>Favourite Restaurants</h6>
                            <span class="text-secondary">Put Restaurants</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter mr-2 icon-inline text-info"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>Favourite Dishes</h6>
                            <span class="text-secondary">Put dishes</span>
                        </li>
                        </ul>
                    </div>
                    </div>
                    <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                            <h6 class="mb-0">Full Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                            <=$customer->first_name?> <=$customer->last_name?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                            <=$customer->email?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                            <h6 class="mb-0">Mobile</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                            <=$customer->phone?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                            <h6 class="mb-0">Address</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                            <=$customer->adress?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                            <a class="btn btn-info " target="__blank" href="">Edit</a>
                            </div>
                        </div>
                        </div>
                    </div>
            </div>
-->