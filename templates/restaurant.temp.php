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
                <img src="../images/restaurants/<?=$restaurant->id?>.png" class="center">
                <div class="middle-text">
                    <div class="label"><?=$restaurant->name?></div>
                </div>
            </a>
        <?php } ?>
    </section>
<?php } ?>

<?php function drawRestaurantSearch(array $restaurants, array $dishes, string $search) { ?>

    <script>var nav = 0;</script>
    <script src="../scripts/sidemenu.js"></script>
    
    <div id="search-menu" class="search-menu">
      <div class="filter-search-container">
          <form action="search.php"  class="search-form">
              <input type="hidden" name="search" value=<?=$_GET['search']?>>
              <input type="range" min=0 max=5 step=0.1 value="2.5" name="score" id="score-range" oninput="this.nextElementSibling.value = this.value">
              <p id="score-value">2.5</p>
              <button class="button" type="submit"><i class="fa fa-search"></i></button>
          </form>
      </div>
    </div>
    <button class="openbtn" onclick="clickNav()"><i class="fas fa-bars"></i></button>

    <h2 class="sub-header">Search results for "<?=$search?>"</h2>
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
    <section class="dishes">
        <?php foreach($dishes as $dish) { ?> 
            <a id="dish-image-blocks" href="restaurant.php?id=<?=$dish->id?>">
                <img src="https://picsum.photos/200?<?=$dish->id * 50?>.png" class="center">
                <div class="middle-text">
                    <div class="label"><?=$dish->name?></div>
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
          <a href="restaurant.php?id=<?=$restaurant->id?>">
            <img src="../images/restaurants/<?=$restaurant->id?>.png">
            <div class = "img-text">
              <?=$restaurant->name?>
            </div>
          </a>
        </div>
    <?php $slide_counter +=1;} ?>
    <a class = "next" onclick="plusSlides(1)">&#10095;</a> 
  </div>
  <div class="dot-choices">
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
    <?php if($session->isLoggedIn() && $session->getType()=="customer"){
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
        <p id="review-score"><span id='user-score'><?=$review->score?></span>/5<span id="star"><i class="fa-regular fa-star"></i></span></p>
      </div>
    <?php } ?>
  </section>
<?php } ?>