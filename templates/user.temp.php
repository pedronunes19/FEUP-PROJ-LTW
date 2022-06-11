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
            <img class="profile-img" src="../images/<?=$session->getType()?>s/<?=$user->id?>.png" alt="User">
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
        <form action="../actions/action.edit_profile.php" method="post" enctype="multipart/form-data">
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

            <div class="input-field">
                <label for="image">Profile picture</label>
                <input class="register_optional" type="file" name="image">
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

<?php function drawSeparateCards($db, $session, array $restaurants, array $orders, array $reviews) { ?>
    <?php if ($session->getType() == "customer") {
        drawFavoriteRestaurants($restaurants);
        drawUserOrders($db, $orders);
        drawReviewsByUser($db, $reviews);
    } else {
        drawOwnedRestaurants($db, $restaurants);
        drawReviewsByRestaurant($db, $reviews);
        drawRestaurantOrders($db, $orders);
    } 
    ?>
<?php } ?>

<?php function drawModifyRestaurants(array $restaurants) { ?>
    <form action="../pages/modify.php" method="post">
        <input type="hidden" name="modify_type" value="restaurant">
        <button class="button edit-button" type="submit">Create new restaurant</button>
    </form> 
    <form action="../pages/modify.php" method="post">
        <div class="input-field">
        <input type="hidden" name="modify_type" value="restaurant">
        <select name="object_id" required>
            <?php foreach($restaurants as $restaurant) { ?>
                <option value=<?=$restaurant->id?>><?=$restaurant->name?> </option>
            <?php } ?>
        </select>
        </div>
        <button class="button edit-button" type="submit">Update restaurant</button>
    </form>
    <form action="../actions/action.delete_restaurant.php" method="post">
        <div class="input-field">
        <select name="restaurant" required>
            <?php foreach($restaurants as $restaurant) { ?>
                <option value=<?=$restaurant->id?>><?=$restaurant->name?> </option>
            <?php } ?>
        </select>
        </div>
        <button class="button edit-button" type="submit">Delete restaurant</button>
    </form>
<?php } ?>

<?php function drawModifyOrders($db, array $orders) { ?>
    <form action="../actions/action.edit_order.php" method="post">
        <div class="input-field">
        <select name="object_id" required>
            <?php foreach($orders as $order) { 
                $restaurant = Restaurant::getRestaurant($db, $order->restaurant);
                $customer = Customer::getCustomer($db, $order->customer);?>
                <option value=<?=$order->id?>><?=$restaurant->name?> - <?=$customer->name()?> - <?=$order->status?></option>
            <?php } ?>
        </select>
        <select name="status" required>
                <option value="Received">Received</option>
                <option value="Preparing">Preparing</option>
                <option value="Ready">Ready</option>
                <option value="Delivered">Delivered</option>
        </select>
        </div>
        <button class="button edit-button" type="submit">Change order status</button>
    </form>
<?php } ?>

<?php function drawModifyReviews($db, array $reviews) { ?>
    <form action="../pages/modify.php" method="post">
        <input type="hidden" name="modify_type" value="review">
        <input type="hidden" name="restaurant" value=<?=$restaurant->id?>>
        <input type="hidden" name="customer" value=<?=$customer->id?>>
        <button class="button edit-button" type="submit">Create new review</button>
    </form> 
    <form action="../pages/modify.php" method="post">
        <div class="input-field">
        <input type="hidden" name="modify_type" value="review">
        <select name="object_id" required>
            <?php foreach($reviews as $review) { 
                $restaurant = Restaurant::getRestaurant($db, $review->restaurant);?>
                <option value=<?=$review->id?>><?=$restaurant->name?>: <?=$review->content?> </option>
            <?php } ?>
        </select>
        <button class="button edit-button" type="submit">Update review</button>
        </div>
    </form>
    <form action="../actions/action.delete_review.php" method="post">
        <div class="input-field">
        <select name="review" required>
            <?php foreach($reviews as $review) { 
                $restaurant = Restaurant::getRestaurant($db, $review->restaurant);?>
                <option value=<?=$review->id?>><?=$restaurant->name?>: <?=$review->content?> </option>
            <?php } ?>
        </select>
        <button class="button edit-button" type="submit">Delete review</button>
        </div>
    </form>
<?php } ?>

<?php function drawReviewsByUser($db, array $reviews) { ?>
    <div class="card other-card">
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
        ?>
            <tr>
                <td class="table-cell"><?=$restaurant->name?></td>
                <td class="table-cell"><?=$review->content?></td>
                <td class="table-cell"><?=$review->score?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php drawModifyReviews($db, $reviews); ?>
    </div>
    <?php } ?>
<?php } ?> 

<?php function drawFavoriteRestaurants(array $restaurants) { ?>
    <div class="card other-card">
    <h4 class="section-title">Favorite Restaurants</h4>
    <?php if (count($restaurants) == 0) { ?>
        <div class="empty-section-wrapper">
            <div class="empty-section-text">No favourite restaurants yet. Click the hearts!</div>
        </div>
    <?php }
    else { ?>
    <section class="restaurants">
        <?php foreach($restaurants as $restaurant) { ?> 
            <a id="restaurant-image-blocks" href="restaurant.php?id=<?=$restaurant->id?>">
                <img src="../images/restaurants/<?=$restaurant->id?>.png" class="center">
                <div class="middle-text">
                    <div class="label"><?=$restaurant->name?></div>
                </div>
            </a>
        <?php } ?>
    </section>
    </div>
    <?php } ?>
<?php } ?>

<?php function drawUserOrders($db, array $orders) { ?>
    <div class="card other-card">
    <h4 class="section-title">Order history</h4>
    <?php if (count($orders) == 0) { ?>
        <div class="empty-section-wrapper">
            <div class="empty-section-text">No orders yet. Get to eating!</div>
        </div>
    <?php }
    else { ?>
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
    </div>
<?php } ?>

<?php function drawRestaurantOrders($db, array $orders) { ?>
    <div class="card other-card">
    <h4 class="section-title">Order history</h4>
    <?php if (count($orders) == 0) { ?>
        <div class="empty-section-wrapper">
            <div class="empty-section-text">No orders yet. Give it time!</div>
        </div>
    <?php }
    else { ?>
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
    <?php }
    drawModifyOrders($db, $orders); ?>
    </div>
<?php } ?>

<?php function drawOwnedRestaurants($db, array $restaurants) { ?>
    <div class="card other-card">
    <h4 class="section-title">Owned Restaurants</h4>
    <?php if (count($restaurants) == 0) { ?>
        <div class="empty-section-wrapper">
            <div class="empty-section-text">No owned restaurants yet. Make your food known!</div>
        </div>
    <?php } 
    else { ?>
    <section class="restaurants">
        <?php foreach($restaurants as $restaurant) { ?> 
            <a id="restaurant-image-blocks" href="restaurant.php?id=<?=$restaurant->id?>">
                <img src="../images/restaurants/<?=$restaurant->id?>.png" class="center" width=400 height=200>
                <div class="middle-text">
                    <div class="label"><?=$restaurant->name?></div>
                </div>
            </a>
        <?php } ?>
    </section>
    <?php drawModifyRestaurants($restaurants) ?>
    </div>
    <?php } ?>
<?php } ?>

<?php function drawReviewsByRestaurant($db, array $reviews) { ?>
    <div class="card other-card">
    <h4 class="section-title">Your Restaurants' Reviews</h4>
    <?php if (count($reviews) == 0) { ?>
        <div class="empty-section-wrapper">
            <div class="empty-section-text">No reviews yet. Be patient!</div>
        </div>
    <?php } 
    else { ?>
    <table class="table restaurant-table">
        <thead class="table-header-list">
            <tr>
                <th class="table-header">Restaurant Name</th>
                <th class="table-header">Reviewer</th>
                <th class="table-header">Review Content</th>
                <th class="table-header">Review Score</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($reviews as $review) { 
            $restaurant = Restaurant::getRestaurant($db, $review->restaurant);
            $reviewer = Customer::getCustomer($db, $review->customer);
        ?>
            <tr>
                <td class="table-cell"><?=$restaurant->name?></td>
                <td class="table-cell"><?=$reviewer->name()?></td>
                <td class="table-cell"><?=$review->content?></td>
                <td class="table-cell"><?=$review->score?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } ?>
    </div>
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