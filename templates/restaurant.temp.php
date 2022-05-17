<?php 
    declare(strict_types = 1);
    require_once('database/restaurant.class.php')
?>
<?php function drawRestaurants(array $restaurants) { ?>
    <h2>Restaurants</h2>
    <section id="restaurants">
        <?php foreach($restaurants as $restaurant) { ?> 
            <article>
                <img src="https://picsum.photos/200?<?=$restaurant->id?>">
                <a href="restaurant.php?id=<?=$restaurant->id?>"><?=$restaurant->name?></a>
            </article>
        <?php } ?>
    </section>
<?php } ?>