<?php 
    declare(strict_types = 1);
    require_once('../database/restaurant.class.php');
    require_once('../database/customer.class.php');
    require_once('../database/menu.class.php');
    require_once('../database/dish.class.php');
    require_once('../database/review.class.php');
    require_once('../session/session.php');
?>
<?php function drawRestaurants(array $restaurants) { ?>
    <h2 class="sub-header">Which restaurant will you try today?</h2>
    <section class="restaurants">
        <?php foreach($restaurants as $restaurant) { ?> 
            <a id="restaurant-image-blocks" href="restaurant.php?id=<?=$restaurant->id?>">
                <img src="https://picsum.photos/400/200?<?=$restaurant->id?>" class="center">
                <div class="middle-text">
                    <div class="label"><?=$restaurant->name?></div>
                </div>
            </a>
        <?php } ?>
    </section>
<?php } ?>

<?php function drawRestaurantSearch(array $restaurants, string $search) { ?>
    <h2 class="sub-header">Search results for "<?=$search?>"</h2>
    <section class="restaurants">
        <?php foreach($restaurants as $restaurant) { ?> 
            <a id="restaurant-image-blocks" href="restaurant.php?id=<?=$restaurant->id?>">
                <img src="https://picsum.photos/400/200?<?=$restaurant->id?>" class="center">
                <div class="middle-text">
                    <div class="label"><?=$restaurant->name?></div>
                </div>
            </a>
        <?php } ?>
    </section>
<?php } ?>

<?php function drawRestaurantsSlideshow(array $restaurants) { ?>
  <section class="suggestions">
  <div class = "slideshow-container">
    <a class = "prev" onclick="plusSlides(-1)">&#10094;</a>  
    <?php $slide_counter = 1;
    foreach($restaurants as $restaurant) { ?> 
        <div class = "slide-fading">
          <img src="https://picsum.photos/400/200?<?=$restaurant->id?>" style = "width: 100%;">
          <div class = "img-text">
            <a href="restaurant.php?id=<?=$restaurant->id?>"> <?=$restaurant->name?> </a>
          </div>
        </div>
    <?php $slide_counter +=1;} ?>
    <a class = "next" onclick="plusSlides(1)">&#10095;</a> 
  </div>
  <div style="text-align:center">
          <span class = "dot" onclick="currentSlide(1)"></span>
          <span class = "dot" onclick="currentSlide(2)"></span>
          <span class = "dot" onclick="currentSlide(3)"></span>
          <span class = "dot" onclick="currentSlide(4)"></span>
          <span class = "dot" onclick="currentSlide(5)"></span>
  </div>

  <script src="../scripts/restaurants.js"></script>

  </section>
<?php } ?>

<?php function drawRestaurant(PDO $db, Restaurant $restaurant, array $menus, array $dishes, array $reviews, Session $session) { ?>
  <h2 class="sub-header"><?=$restaurant->name?> 
    <?php if($session->isLoggedIn()){
      drawFavoriteButton($db, $restaurant, $session);
    }?>
  </h2>
  <h3>MENUS</h3>
  <section class="menus">
    <?php foreach ($menus as $menu) { 
      drawMenu($db, $menu);
    } ?>
  </section>
  <h3>DISHES</h3>
  <section class="dishes">
    <?php foreach ($dishes as $dish) { ?>
    <a id = "dish-image-blocks">
      <img src="https://picsum.photos/200?<?=($dish->id * 50)?>" class = "center">
      <div class="middle-text">
        <div class="label"><?=$dish->name?> - <?=$dish->price?>€</div>
      </div>
    </a>
    <?php } ?>
  </section>
  <?php drawReviews($db, $reviews) ?>
<?php } ?>

<?php function drawFavoriteButton(PDO $db, Restaurant $restaurant, Session $session) { ?>
  <button class='button favorite-button'> <span class='favorite'>
      <?php if((Customer::getCustomer($db, $session->getId())->isFavoriteRestaurant($db, $restaurant->id))){
          echo "&#10084;";
        } else {
          echo "&#9825;";
        }?>
    </span></button>
    <script>let res = <?= $restaurant->id ?>;</script>
    <script src="../scripts/favorite.js"></script>
<?php } ?>  

<?php function drawMenu(PDO $db, Menu $menu) { 
  $menu_dishes = $menu->getMenuDishes($db) ?>
    <a id = "menu-image-blocks">
      <img src="https://picsum.photos/200?<?=$menu->id?>" class = "center">
      <div class="middle-text">
        <div class="label"><?=$menu->name?> - <?=$menu->price?>€</div>
        <?php foreach($menu_dishes as $dish) {?>
          <div class="secondary-label"><?=$dish->name?></div>
        <?php }?>
      </div>
    </a>
<?php } ?>

<?php function drawReviews(PDO $db, array $reviews) { ?>
  <h3>REVIEWS</h3>
  <section class="reviews">
    <?php foreach ($reviews as $review) { ?>
      <div class = "review">
        <p id="review-customer"><?=Customer::getCustomer($db, $review->customer)->first_name?> <?=Customer::getCustomer($db, $review->customer)->last_name?></p>
        <p id="review-content"><?=$review->content?></p>
        <p id="review-score"><?php if($review->score >= 4) {echo "<span id='positive'>" . $review->score . "</span>";} 
                                   else if($review->score == 3) {echo "<span id='mid'>" . $review->score . "</span>";}
                                   else {echo "<span id='negative'>" . $review->score . "</span>";}?>/5<span id="star">&#9733</span></p>
      </div>
    <?php } ?>
  </section>
<?php } ?>