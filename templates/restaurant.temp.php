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

<?php function drawRestaurant(Restaurant $restaurant, array $menus, array $dishes) { ?>
  <h2><?=$restaurant->name?></h2>
  <section id="menus">
    <h2>MENUS</h2>
    <?php foreach ($menus as $menu) { ?>
    <article>
      <img src="https://picsum.photos/200/250?<?=$menu->id?>">
      <p class="name"><?=$menu->name?></p>
      <p class="info"><?=$menu->price?> € <?php if ($menu->category !== "Unspecified") {echo "/" . $menu->category;} ?></p>
    </article>
    <?php } ?>
  </section>
  <section id="dishes">
    <h2>DISHES</h2>
    <?php foreach ($dishes as $dish) { ?>
    <article>
      <img src="https://picsum.photos/200/250?<?=$dish->id?>">
      <p class="name"><?=$dish->name?></p>
      <p class="info"><?=$dish->price?> € <?php if ($dish->category !== "Unspecified") {echo  "/" . $dish->category;} ?></p>
    </article>
    <?php } ?>
  </section>
<?php } ?>