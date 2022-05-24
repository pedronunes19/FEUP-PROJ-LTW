<?php 
    declare(strict_types = 1);
    require_once('../database/restaurant.class.php');
    require_once('../database/menu.class.php');
    require_once('../database/dish.class.php');
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

<?php function drawRestaurantsSlideshow(array $restaurants) { ?>
  <section class="suggestions">
  <div class = "slideshow-container">
    <a class = "prev" onclick="plusSlides(-1)">&#10094;</a>  
    <?php $slide_counter = 1;
    foreach($restaurants as $restaurant) { ?> 
        <div class = "slide-fading">
          <img src="https://picsum.photos/400/200?<?=$restaurant->id?>" style = "width: 100%;">
          <div class = "img-text">
            <?=$restaurant->name?>
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

  <script src="../javascript/restaurants.js"></script>

  </section>
<?php } ?>

<?php function drawRestaurant(PDO $db, Restaurant $restaurant, array $menus, array $dishes) { ?>
  <h2 class="sub-header"><?=$restaurant->name?></h2>
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