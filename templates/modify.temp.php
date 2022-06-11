<?php 
    declare(strict_types = 1);
    require_once('../session/session.php'); 
    require_once('../database/restaurant.class.php');
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

<?php function drawReviewForm($db, $session, $object_id) {
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