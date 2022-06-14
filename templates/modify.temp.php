<?php 
    declare(strict_types = 1);
    require_once('../session/session.php'); 
    require_once('../database/restaurant.class.php');
    require_once('../database/menu.class.php');
    require_once('../database/dish.class.php');
    require_once('../database/order.class.php');
    require_once('../database/review.class.php');
    require_once('../database/category.class.php');
?>

<?php function drawRestaurantForm($db, $session, $object_id) {
    if ($object_id != null) { $restaurant = Restaurant::getRestaurant($db, $object_id); $restaurant_categories = Category::getRestaurantCategories($db, $object_id); } ?> 
    <?php $categories = Category::getCategories($db); ?>
    <div class="card modify-card">
        <h4 class="section-title">Restaurant</h4>
        <form <?php if ($object_id != null) { ?> action="../actions/action.edit_restaurant.php" 
            <?php } else { ?> action="../actions/action.create_restaurant.php" <?php } ?> method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value=<?=$object_id?>>
            <input type="hidden" name="owner-id" value=<?=$session->getID()?>>
            <div class="input-field">
                <label for="name">Restaurant name *</label>
                <input class="text-field" type="text" name="name" <?php if ($object_id != null) {?> value="<?=$restaurant->name?>"<?php }?> required>
            </div>
            <div class="input-field">
                <label for="address">Restaurant address</label>
                <input class="text-field" type="text" name="address" <?php if ($object_id != null) {?> value="<?=$restaurant->address?>"<?php }?>>
            </div>
            <div class="input-field">
                <label for="category">Restaurant category 1 *</label>
                <select name="category-1" required>
                    <?php if ($object_id != null) { ?> <option value=<?=$restaurant_categories[0]->id?>><?=$restaurant_categories[0]->name?></option> <?php } ?>
                    <?php foreach($categories as $category) { ?> 
                        <?php if (isset($restaurant_categories)) {
                            if ($category->id != $restaurant_categories[0]->id) { ?>
                            <option value=<?=$category->id?>><?=$category->name?></option>
                        <?php } }
                        else { ?>
                            <option value=<?=$category->id?>><?=$category->name?></option>
                    <?php } }?>
                </select>
            </div>
            <div class="input-field">
                <label for="category">Restaurant category 2</label>
                <select name="category-2">
                    <?php if ($object_id != null && count($restaurant_categories) > 1) { ?> <option value=<?=$restaurant_categories[1]->id?>><?=$restaurant_categories[1]->name?></option> <?php } ?>
                    <option value="none"></option>
                    <?php foreach($categories as $category) { ?> 
                        <?php if (isset($restaurant_categories) && count($restaurant_categories) > 1) {
                            if ($category->id != $restaurant_categories[1]->id) { ?>
                            <option value=<?=$category->id?>><?=$category->name?></option>
                        <?php } }
                        else { ?>
                            <option value=<?=$category->id?>><?=$category->name?></option>
                    <?php } }?>
                </select>
            </div>
            <div class="input-field">
                <label for="category">Restaurant category 3</label>
                <select name="category-3">
                    <?php if ($object_id != null && count($restaurant_categories) > 2) { ?> <option value=<?=$restaurant_categories[2]->id?>><?=$restaurant_categories[2]->name?></option> <?php } ?>
                    <option value="none"></option>
                    <?php foreach($categories as $category) { ?> 
                        <?php if (isset($restaurant_categories) && count($restaurant_categories) > 2) {
                            if ($category->id != $restaurant_categories[2]->id) { ?>
                            <option value=<?=$category->id?>><?=$category->name?></option>
                        <?php } }
                        else { ?>
                            <option value=<?=$category->id?>><?=$category->name?></option>
                    <?php } }?>
                </select>
            </div>
            <div class="input-field">
                <?php if ($object_id != null) { ?>
                    <label for="image">Restaurant picture</label>
                    <input class="text-field" type="file" name="image">
                <?php } else { ?>
                    <label for="image">Restaurant picture *</label>
                    <input class="text-field" type="file" name="image" required>
                <?php } ?>
            </div>

            <div class="asterisk-info">
                <a class="text-info">* - Required field<br></a>
            </div> 
            <div class="button-wrapper">
                <button class="button edit-button" type="submit">Edit information</button>
            </div>
        </form>
    </div>
<?php } ?>

<?php function drawReviewForm($db, $session, $object_id, $rid) {
    if ($object_id != null) $review = Review::getReview($db, $object_id); ?>
    <div class="card modify-card">
    <?php if ($object_id != null) { 
        $reviewed_restaurant = Restaurant::getRestaurant($db, $review->restaurant)?> 
        <h4 class="section-title">Review for <?=$reviewed_restaurant->name?></h4>
        <?php } else { ?><h4 class="section-title">New Review</h4><?php } ?>
        <form <?php if ($object_id != null) { ?> action="../actions/action.edit_review.php"
            <?php } else { ?> action="../actions/action.create_review.php" <?php } ?> method="post">
            <input type="hidden" name="id" value=<?=$object_id?>>
            <input type="hidden" name="user-id" value=<?=$session->getID()?>>
            <div class="input-field">
                <label for="name">Review content *</label>
                <textarea class="text-field" type="text" name="content" required><?php if ($object_id != null) {?><?=$review->content?><?php }?></textarea>
            </div>
            <div class="input-field">
                <label for="name">Review score (integer number from 1 to 5) *</label>
                <input class="text-field" type="number" name="score" <?php if ($object_id != null) {?> value="<?=$review->score?>"<?php }?> min=1 max=5 required>
            </div>
            <?php if ($object_id == null) { 
                $restaurants = Restaurant::getRestaurants($db, 0)?>
                <label for="name">Restaurant name *</label>
                <div class="input-field">
                    <select name="restaurant" required>
                        <?php if ($rid != null) { $source_restaurant = Restaurant::getRestaurant($db, $rid) ?>
                        <option value=<?=$rid?>><?=$source_restaurant->name?> </option>
                        <?php } ?>
                        <?php foreach($restaurants as $restaurant) { ?>
                            <option value=<?=$restaurant->id?>><?=$restaurant->name?> </option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
            <div class="asterisk-info">
                <a class="text-info">* - Required field<br></a>
            </div> 
            <div class="button-wrapper">
                <button class="button edit-button" type="submit">Edit information</button>
            </div>
        </form>
    </div>
<?php } ?>

<?php function drawDishForm($db, $session, $object_id) {
    if ($object_id != null) $dish = Dish::getDish($db, $object_id); $rid = $_POST['restaurant-id']; $dish_categories = Category::getDishCategories($db, $object_id); ?> 
    <?php $categories = Category::getCategories($db); ?>
    <div class="card modify-card">
        <h4 class="section-title">Dish</h4>
        <form <?php if ($object_id != null) { ?> action="../actions/action.edit_dish.php"
            <?php } else { ?> action="../actions/action.create_dish.php" <?php } ?> method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value=<?=$object_id?>>
            <input type="hidden" name="restaurant-id" value=<?=$rid?>>
            <div class="input-field">
                <label for="name">Dish name *</label>
                <input class="text-field" type="text" name="name" <?php if ($object_id != null) {?> value="<?=$dish->name?>"<?php }?> required>
            </div>
            <div class="input-field">
                <label for="name">Dish price (in €) *</label>
                <input class="text-field" type="number" name="price" <?php if ($object_id != null) {?> value="<?=$dish->price?>"<?php }?> min=0.01 step="0.01" required>
            </div>
            <div class="input-field">
                <label for="category">Dish category 1 *</label>
                <select name="category-1" required>
                    <?php if ($object_id != null) { ?> <option value=<?=$dish_categories[0]->id?>><?=$dish_categories[0]->name?></option> <?php } ?>
                    <?php foreach($categories as $category) { ?> 
                        <?php if (isset($dish_categories)) {
                            if ($category->id != $dish_categories[0]->id) { ?>
                            <option value=<?=$category->id?>><?=$category->name?></option>
                        <?php } }
                        else { ?>
                            <option value=<?=$category->id?>><?=$category->name?></option>
                    <?php } }?>
                </select>
            </div>
            <div class="input-field">
                <label for="category">Dish category 2</label>
                <select name="category-2">
                    <?php if ($object_id != null && count($dish_categories) > 1) { ?> <option value=<?=$dish_categories[1]->id?>><?=$dish_categories[1]->name?></option> <?php } ?>
                    <option value="none"></option>
                    <?php foreach($categories as $category) { ?> 
                        <?php if (isset($dish_categories) && count($dish_categories) > 1) {
                            if ($category->id != $dish_categories[1]->id) { ?>
                            <option value=<?=$category->id?>><?=$category->name?></option>
                        <?php } }
                        else { ?>
                            <option value=<?=$category->id?>><?=$category->name?></option>
                    <?php } }?>
                </select>
            </div>
            <div class="input-field">
                <label for="category">Dish category 3</label>
                <select name="category-3">
                    <?php if ($object_id != null && count($dish_categories) > 2) { ?> <option value=<?=$dish_categories[2]->id?>><?=$dish_categories[2]->name?></option> <?php } ?>
                    <option value="none"></option>
                    <?php foreach($categories as $category) { ?> 
                        <?php if (isset($dish_categories) && count($dish_categories) > 2) {
                            if ($category->id != $dish_categories[2]->id) { ?>
                            <option value=<?=$category->id?>><?=$category->name?></option>
                        <?php } }
                        else { ?>
                            <option value=<?=$category->id?>><?=$category->name?></option>
                    <?php } }?>
                </select>
            </div>
            <div class="input-field">
                <?php if ($object_id != null) { ?>
                    <label for="image">Dish picture</label>
                    <input class="text-field" type="file" name="image">
                <?php } else { ?>
                    <label for="image">Dish picture *</label>
                    <input class="text-field" type="file" name="image" required>
                <?php } ?>
            </div>
            <div class="asterisk-info">
                <a class="text-info">* - Required field<br></a>
            </div> 
            <div class="button-wrapper">
                <button class="button edit-button" type="submit">Edit information</button>
            </div>
        </form>
    </div>
<?php } ?>

<?php function drawMenuForm($db, $session, $object_id) {
    if ($object_id != null) { $menu = Menu::getMenu($db, $object_id); $rid = $_POST['restaurant-id']; $menu_categories = Category::getMenuCategories($db, $object_id); 
    $menu_dishes = $menu->getMenuDishes($db); $dishes = Dish::getRestaurantDishes($db, intval($rid)); } ?> 
    <?php $categories = Category::getCategories($db); ?>
    <div class="card modify-card">
        <h4 class="section-title">Menu</h4>
        <form <?php if ($object_id != null) { ?> action="../actions/action.edit_menu.php"
            <?php } else { ?> action="../actions/action.create_menu.php" <?php } ?> method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value=<?=$object_id?>>
            <input type="hidden" name="restaurant-id" value=<?=$rid?>>
            <div class="input-field">
                <label for="name">Menu name *</label>
                <input class="text-field" type="text" name="name" <?php if ($object_id != null) {?> value="<?=$menu->name?>"<?php }?> required>
            </div>
            <div class="input-field">
                <label for="name">Menu price (in €) *</label>
                <input class="text-field" type="number" name="price" <?php if ($object_id != null) {?> value="<?=$menu->price?>"<?php }?> min=0.01 step="0.01" required>
            </div>
            <div class="input-field">
                <label for="category">Menu category 1 *</label>
                <select name="category-1" required>
                    <?php if ($object_id != null) { ?> <option value=<?=$menu_categories[0]->id?>><?=$menu_categories[0]->name?></option> <?php } ?>
                    <?php foreach($categories as $category) { ?> 
                        <?php if (isset($menu_categories)) {
                            if ($category->id != $menu_categories[0]->id) { ?>
                            <option value=<?=$category->id?>><?=$category->name?></option>
                        <?php } }
                        else { ?>
                            <option value=<?=$category->id?>><?=$category->name?></option>
                    <?php } }?>
                </select>
            </div>
            <div class="input-field">
                <label for="category">Menu category 2</label>
                <select name="category-2">
                    <?php if ($object_id != null && count($menu_categories) > 1) { ?> <option value=<?=$menu_categories[1]->id?>><?=$menu_categories[1]->name?></option> <?php } ?>
                    <option value="none"></option>
                    <?php foreach($categories as $category) { ?> 
                        <?php if (isset($menu_categories) && count($menu_categories) > 1) {
                            if ($category->id != $menu_categories[1]->id) { ?>
                            <option value=<?=$category->id?>><?=$category->name?></option>
                        <?php } }
                        else { ?>
                            <option value=<?=$category->id?>><?=$category->name?></option>
                    <?php } }?>
                </select>
            </div>
            <div class="input-field">
                <label for="category">Menu category 3</label>
                <select name="category-3">
                    <?php if ($object_id != null && count($menu_categories) > 2) { ?> <option value=<?=$menu_categories[2]->id?>><?=$menu_categories[2]->name?></option> <?php } ?>
                    <option value="none"></option>
                    <?php foreach($categories as $category) { ?> 
                        <?php if (isset($menu_categories) && count($menu_categories) > 2) {
                            if ($category->id != $menu_categories[2]->id) { ?>
                            <option value=<?=$category->id?>><?=$category->name?></option>
                        <?php } }
                        else { ?>
                            <option value=<?=$category->id?>><?=$category->name?></option>
                    <?php } }?>
                </select>
            </div>
            <div class="input-field">
                <label for="menu-dish">Menu dish 1</label>
                <select name="menu-dish-1" required>
                    <?php if ($object_id != null && count($menu_dishes) > 0) { ?> <option value=<?=$menu_dishes[0]->id?>><?=$menu_dishes[0]->name?></option> <?php } ?>
                    <?php foreach($dishes as $dish) { ?> 
                        <?php if (isset($menu_dishes) && count($menu_dishes) > 0) {
                            if ($dish->id != $menu_dishes[0]->id) { ?>
                            <option value=<?=$dish->id?>><?=$dish->name?></option>
                        <?php } }
                        else { ?>
                            <option value=<?=$dish->id?>><?=$dish->name?></option>
                    <?php } }?>
                </select>
            </div>
            <div class="input-field">
                <label for="menu-dish">Menu dish 2</label>
                <select name="menu-dish-2">
                    <?php if ($object_id != null && count($menu_dishes) > 1) { ?> <option value=<?=$menu_dishes[1]->id?>><?=$menu_dishes[1]->name?></option> <?php } ?>
                    <option value="none"></option>
                    <?php foreach($dishes as $dish) { ?> 
                        <?php if (isset($menu_dishes) && count($menu_dishes) > 1) {
                            if ($dish->id != $menu_dishes[1]->id) { ?>
                            <option value=<?=$dish->id?>><?=$dish->name?></option>
                        <?php } }
                        else { ?>
                            <option value=<?=$dish->id?>><?=$dish->name?></option>
                    <?php } }?>
                </select>
            </div>
            <div class="input-field">
                <label for="menu-dish">Menu dish 3</label>
                <select name="menu-dish-3">
                    <?php if ($object_id != null && count($menu_dishes) > 2) { ?> <option value=<?=$menu_dishes[2]->id?>><?=$menu_dishes[2]->name?></option> <?php } ?>
                    <option value="none"></option>
                    <?php foreach($dishes as $dish) { ?> 
                        <?php if (isset($menu_dishes) && count($menu_dishes) > 2) {
                            if ($dish->id != $menu_dishes[2]->id) { ?>
                            <option value=<?=$dish->id?>><?=$dish->name?></option>
                        <?php } }
                        else { ?>
                            <option value=<?=$dish->id?>><?=$dish->name?></option>
                    <?php } }?>
                </select>
            </div>
            <div class="input-field">
                <?php if ($object_id != null) { ?>
                    <label for="image">Menu picture</label>
                    <input class="text-field" type="file" name="image">
                <?php } else { ?>
                    <label for="image">Menu picture *</label>
                    <input class="text-field" type="file" name="image" required>
                <?php } ?>
            </div>
            <div class="asterisk-info">
                <a class="text-info">* - Required field<br></a>
            </div>
            <div class="button-wrapper">
                <button class="button edit-button" type="submit">Edit information</button>
            </div>
        </form>
    </div>
<?php } ?>