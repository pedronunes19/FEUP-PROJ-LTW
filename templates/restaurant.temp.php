<?php 
    declare(strict_types = 1);
    require_once('../database/restaurant.class.php')
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