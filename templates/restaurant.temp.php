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
      <img src="https://picsum.photos/200?<?=$dish->id?>" class = "center">
      <div class="middle-text">
        <div class="label"><?=$menu->name?></div>
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
        <div class="label"><?=$menu->name?></div>
      </div>
    </a>
<?php } ?>