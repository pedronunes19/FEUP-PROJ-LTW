<?php
    declare(strict_types = 1);
    require_once('../database/customer.class.php');
    require_once('../database/restaurantOwner.class.php');
    require_once('../database/dish.class.php');
    require_once('../database/menu.class.php');
    require_once('../database/restaurant.class.php');
    require_once('../database/order.class.php');
    require_once('../database/review.class.php');
?>

<?php function drawCheckout($db, $session) { ?>
    <div class="cart-container">
        <div class="card item-card">
            <h3 class="section-title">YOUR CART</h3>
            <section class="dishes" id="checkout-blocks">
            <?php foreach($session->getItems() as $arr) { ?>
                <?php if ($arr['type'] == "menu") $item = Menu::getMenu($db, $arr['id']) ?>
                <?php if ($arr['type'] == "dish") $item = Dish::getDish($db, $arr['id']) ?>
                <a id = "dish-image-blocks">
                    <?php if ($arr['type'] == "menu") { ?> <img src="../images/menus/<?=$item->id?>.png" class = "center">
                    <?php } else { ?> <img src="../images/dishes/<?=$item->id?>.png" class = "center"> <?php } ?>
                    <div class="middle-text">
                        <div class="label"><?=$item->name?> (x<?=$arr['amount']?>) - <?=($item->price)*($arr['amount'])?>€</div>
                        <form class="remove-button-form" action="../actions/action.remove_from_cart.php" method="post">
                        <input type="hidden" name="type" value=<?=$arr['type']?>>
                        <input type="hidden" name="id" value=<?=$arr['id']?>>
                        <button class="button remove-button" type="submit"><i class="fa-solid fa-xmark"></i></button>
                        </form>
                    </div>
                </a>
            <?php } ?>
            </section>
        </div>
        <div class="card price-card">
        <section class="total">
            <h3 class="section-title">PRICE LIST</h3>
            <?php $total = 0.0?>
            <h4>
            <?php foreach($session->getItems() as $arr) { ?>
                <?php if ($arr['type'] == "menu") $item = Menu::getMenu($db, $arr['id']) ?>
                <?php if ($arr['type'] == "dish") $item = Dish::getDish($db, $arr['id']) ?>
                <?=$item->name?> (x<?=$arr['amount']?>) -> <?=($item->price)*($arr['amount'])?>€<br>
                <?php $total += (($item->price)*($arr['amount']))?>
            <?php } ?>
            </h4>
        </section>
        <div class="final-calculation">
            <h4>Total price: <?=$total?>€</h4>
        </div>
        </div>
        <form action="../actions/action.order.php"? method="post">
            <input type="hidden" name="restaurant-id" value=<?=$session->getItems()[0]['restaurant']?>>
            <input type="hidden" name="customer-id" value=<?=$session->getId()?>>
            <div class="card button-card">
                <button id="checkout-button" class="button" type="submit">Order</button>
            </div>
        </form>
    </div>
<?php } ?>