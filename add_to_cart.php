<?php
session_start();
require_once("connection.php");
//grab productId from URL
$item_id = $_GET['productid'] ?? null;
//run code to database if logged in and session set
if(isset($_SESSION["username"])){
    //Grab everything from cart where the username is the same
    $cart = $pdo->prepare("SELECT * FROM cart WHERE cart_user  = ?");
    $cart->execute([$_SESSION["username"]]);
    $cart_items = $cart->fetchAll();
    //If the cart already has something inside it
    if(count($cart_items) > 0){
        echo  "cart isnt empty";
        $cart_match = null;
        //if itemId equals something that is already inside the database update the quantity 
        //for each loop to go through the car products in the user
        foreach($cart_items as $item){
            //check if the item is inside table already
            if($item_id === $item['cart_product']){
                //Grab which array item this product belonds to
                $cart_match = $item;
            }
            else{
                $cart_match = null;
            }
        }
        //prepare to change if not null meaning match was found
        if($cart_match != null){
            //grab quantity of this items inside this row 
            $quantity_in_row = $cart_match['product_amount'];
            $quantity_in_row += 1;
            $add_item = $pdo->prepare('UPDATE cart SET product_amount = ? WHERE cart_user = ? AND cart_product = ?');
            //send into the database the new quantity first checking if the user matches and then the product ID
            $add_item->execute([$quantity_in_row,$_SESSION['username'],$cart_match['cart_product']]);
        }
        //else add a new product into the cart
        else{
            $product_amount = 1;
            $cart = $pdo->prepare("INSERT INTO cart(cart_user, cart_product, product_amount)
            VALUES (?, ?, ?)");
            $cart->execute([$_SESSION["username"],$item_id,$product_amount]);
        }
    }
    //else if cart is empty insert Into database as a new product
    else{
        $product_amount = 1;
        $cart = $pdo->prepare("INSERT INTO cart(cart_user, cart_product, product_amount)
        VALUES (?, ?, ?)");
        $cart->execute([$_SESSION["username"],$item_id,$product_amount]);
    }
}
else{
    //do cookie stuff
    ECHO "outside mother condition cookie";
}
//Grab current URL in order to return user to where they were previously at
//$_SERVER['HTTP_HOST'] is the host name of the url
//REQUESTT_URI os the uniform resource identifier, basically the last thing in the url
//wont work ; - ; 
//header("Location: http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}");

sleep(2);
header("Location: cart.php");
?>