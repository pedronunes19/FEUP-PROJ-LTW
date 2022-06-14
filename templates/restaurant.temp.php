<?php 
    declare(strict_types = 1);
    require_once('../database/restaurant.class.php');
    require_once('../database/customer.class.php');
    require_once('../database/category.class.php');
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

<?php function drawRestaurantSearch(array $restaurants, array $dishes, array $categories, string $search) { ?>

    <script>let nav = 0;</script>
    <script src="../scripts/sidemenu.js"></script>
    
    <div id="search-menu" class="search-menu">
      <div class="filter-search-container">
          <form action="search.php"  class="search-form">
              <input type="hidden" name="search" value=<?=htmlspecialchars($_GET['search'])?>>
              <input type="range" min=0 max=5 step=0.1 value="0" name="score" class="score-range" oninput="this.nextElementSibling.children[0].value = this.value">
              <p class="min-score-display">Min. Average: <output>0</output></p>
              <section class="categories">
              <?php foreach($categories as $category) {?>
                <input type="checkbox" value=<?=$category->name?> id="category-filter<?=$category->id?>" name=<?=$category->id?> class="category-filter">
                <label for="category-filter<?=$category->id?>"><?=$category->name?></label>
              <?php } ?> 
              </section> 
              <button class="button" type="submit">Aplicar</button>
          </form>
      </div>
    </div>
    <button class="openbtn" onclick="clickNav()"><i class="fas fa-bars"></i></button>

    <h2 class="sub-header">Search results for "<?=htmlspecialchars($search)?>"</h2>
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
            <a id="dish-image-blocks" href="restaurant.php?id=<?=$dish->restaurant?>">
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

<?php function drawRestaurant(PDO $db, Restaurant $restaurant, array $menus, array $dishes, array $reviews, array $categories, Session $session) { ?>
  <h2 class="sub-header"><?=$restaurant->name?> 
    <?php if($session->isLoggedIn() && $session->getType()=="customer"){
      drawFavoriteButton($db, $restaurant, $session);
    }?>
  </h2>
  <section class="restaurant-categories">
    <?php foreach ($categories as $category) { ?>
      <p class="restaurant-category"><?=$category->name?></p>
    <?php } ?>
  </section>
  <div class="card other-card">
  <h3>MENUS</h3>
  <section class="menus">
    <?php foreach ($menus as $menu) { 
      drawMenu($db, $menu);
    } ?>
  </section>
  </div>
  <div class="card other-card">
  <h3>DISHES</h3>
  <section class="dishes">
    <script>let dish; let buttonDish; let favoriteDish; let dish_map = new Map();</script>
    <?php foreach ($dishes as $dish) { ?>
    <a id = "dish-image-blocks">
      <img src="../images/dishes/<?=$dish->id?>.png" class = "center">
      <div class="middle-text">
        <div class="label"><?=$dish->name?> - <?=$dish->price?>€</div>
        <?php if($session->isLoggedIn() && $session->getType()=="customer"){
          drawFavoriteButtonDish($db, $dish->id, $session);
        }?>
      </div>
    </a>
    <?php } ?>
  </section>
  </div>
  <div class="card other-card">
  <?php drawReviews($db, $reviews, $session) ?>
  </div>
<?php } ?>

<?php function drawOwnerMenu($db, $session, $dishes, $menus) { ?>
  <?php $rid=$_GET['id']?>
  <div class="card other-card">
    <h3>OWNER MENU</h3>
    <h4>Dishes</h4>
    <?php drawModifyDishes($db, $dishes, $rid); ?>
    <h4>Menus</h4>
    <?php drawModifyMenus($db, $menus, $rid); ?>

  </div>
<?php } ?>

<?php function drawCartModify($db, $session, $dishes, $menus) { ?>
  <?php $rid=$_GET['id']?>
  <div class="card other-card">
  <h3>CART MENU</h3>
  <?php if(count($dishes) != 0) { ?>
    <form action="../actions/action.add_to_cart.php" method="post">
      <input type="hidden" name="restaurant-id" value=<?=$rid?>>
      <input type="hidden" name="type" value="dish">
      <div class="input-field">
      <label for="dish">Dishes</label>
      <select name="id" required>
      <?php foreach($dishes as $dish) { ?>
        <option value=<?=$dish->id?>><?=$dish->name?></option>
      <?php } ?>
      </select>

      <input class="text-field" type="number" name="amount" min=1 max=10 required>
      </div>
      <button class="button edit-button" type="submit">Add to cart</button>
    </form> 
    <?php } ?>

    <?php if(count($menus) != 0) { ?>
    <form action="../actions/action.add_to_cart.php" method="post">
      <input type="hidden" name="restaurant-id" value=<?=$rid?>>
      <input type="hidden" name="type" value="menu">
      <div class="input-field">
      <label for="dish">Menus</label>
      <select name="id" required>
        <?php foreach($menus as $menu) { ?>
          <option value=<?=$menu->id?>><?=$menu->name?></option>
        <?php } ?>
      </select>
      <input class="text-field" type="number" name="amount" min=1 max=10 required>
      </div>
      <button class="button edit-button" type="submit">Add to cart</button>
    </form> 
    <?php } ?>
  </div>
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

<?php function drawFavoriteButtonDish(PDO $db, int $dish, Session $session) { ?>
  <button class='button favorite-button-dish favorite-button-dish<?=$dish?>'> <span class='favorite-dish favorite-dish<?=$dish?>'>
      <?php if((Customer::getCustomer($db, $session->getId())->isFavoriteDish($db, $dish))){
          echo "&#10084;";
        } else {
          echo "&#9825;";
        }?>
    </span></button>
    <script>dish = <?=$dish?>;</script>
    <script src="../scripts/favorite.dish.js"></script>
<?php } ?>  

<?php function drawMenu(PDO $db, Menu $menu) { 
  $menu_dishes = $menu->getMenuDishes($db) ?>
    <a id = "menu-image-blocks">
      <img src="../images/menus/<?=$menu->id?>.png" class = "center">
      <div class="middle-text">
        <div class="label"><?=$menu->name?> - <?=$menu->price?>€</div>
        <?php foreach($menu_dishes as $dish) {?>
          <div class="secondary-label"><?=$dish->name?></div>
        <?php }?>
      </div>
    </a>
<?php } ?>

<?php function drawReviews(PDO $db, array $reviews, Session $session) { ?>
  <h3>REVIEWS</h3>
  <section class="reviews">
    <?php foreach ($reviews as $review) { ?>
      <div class = "review">
        <p id="review-customer"><?=Customer::getCustomer($db, $review->customer)->first_name?> <?=Customer::getCustomer($db, $review->customer)->last_name?></p>
        <p id="review-content"><?=$review->content?></p>
        <p id="review-score"><span id='user-score'><?=$review->score?></span>/5<span id="star"><i class="fa-regular fa-star"></i></span></p>
      </div>
    <?php } ?>
    <?php if($session->isLoggedIn() && $session->getType()=="customer"){ ?>
    <form action="../pages/modify.php" method="post" class="add-review-form">
      <input type="hidden" name="modify_type" value="review"> 
      <button class="button add-review" type="submit"><i class="fa fa-plus"></i></button>
    </form>
    <?php } ?>
  </section>
<?php } ?>