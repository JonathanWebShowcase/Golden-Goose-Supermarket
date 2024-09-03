

<?php
require_once 'header.php';
require_once 'connection.php';
?>
<section class="cart_container">
<?php
//if user is logged in
if(isset($_SESSION["username"])){
    //grab user information
    $user_info = $pdo->prepare("SELECT * FROM users WHERE username  = ?");
    $user_info->execute([$_SESSION["username"]]);
    $user = $user_info->fetch();
    $first_name = $user['first_name'];
    //Grab cart informationfield lasagna
    $cart_info = $pdo->prepare("SELECT * FROM cart WHERE cart_user  = ? AND product_amount != 0");
    $cart_info->execute([$_SESSION["username"]]);
    $cart = $cart_info->fetchAll();
    echo "<h1>Welcome " . $first_name . "!</h1>";
    //if display a cart empty messege 
    if(!count($cart) > 0){
        echo "<h1>Cart Empty, Happy Shopping!</h1>";
    }
    //if the cart has soemthing within it 
    else{
        //create an array of all the different items within the customers cart to pull from products table
        $cartproducts = [];
        foreach($cart as $product_id){
            //I need to use [] after the arrayname in order to add into it or else Im just overwriting the datatype and value
            $cartproducts[] = $product_id['cart_product'];
        }
        //Prepare the SQL prepare dynamically based on the amount of items inside the product array
        //initiate the SQL
        $sql = "SELECT * FROM products WHERE product_primary IN (";
        //implode turns an array of values into a string
        //array_fill creates an array based on specified value in this case ? 
        //array_fill creates an array with the same amount of items as the array $cart_products
        //so Im going to grab every product within the cart
        $sql .= implode(", ", array_fill(0, count($cartproducts), "?"));
        $sql .= ")";
        //I dont need this bottom line since Cartproducts already holds an array so I can just fit in inside the execute 
        //$cart_values_string = implode(", ", $cartproducts);
        $product_grab = $pdo->prepare($sql);
        $product_grab->execute($cartproducts);
        $user_cart = $product_grab->fetchAll();
?>
<?php
        foreach($user_cart as $cart_item){
            //Need to grab stuff from cart for each individual product so multiple database runs
            $cart_info_individual = $pdo->prepare("SELECT * FROM cart WHERE cart_user  = ? && cart_product = ?");
            $cart_info_individual->execute([$_SESSION["username"], $cart_item['product_primary']]);
            $cart_individual = $cart_info_individual->fetch();
?>
         <section class="cardItem_cart">
            <section id="cart_image">
                <img src="<?=$cart_item['product_img']?>">
            </section>
            <section id="car_information">
                <section id="cart_name">
                    <p><?=$cart_item['product_name']?></p>
                </section>
                <section id="cart_info">
                    <?php
                    if($cart_item['sale_status'] == 'true'){
                        echo '<p id="sale_price">' . $cart_item['product_salesPrice'] . '</p>';
                        echo '<p id="original_price">' . $cart_item['product_originalPrice'] . '</p>';
                    }
                    else{
                        echo '<p id="original_price_cart">' . $cart_item['product_originalPrice'] . '</p>';
                    }
                    ?>
                </section>
            </section>
            <section id="remove">
                <a href="remove_from_cart.php?productid=<?=$cart_item['product_primary']?>">
                    <img src="img/minus.png" alt="">
                </a>
                <h1><?=$cart_individual['product_amount']?></h1>
                <a href="add_to_cart.php?productid=<?=$cart_item['product_primary']?>">
                <img src="img/add.png" alt="">
                </a>
            </section>
        </section>
<?php
        }
    }
}
else{
    echo "<h1>Nothing Here, Happy Shopping!</h1>";
}
?>
</section>
<?php
require_once('footer.php');
?>