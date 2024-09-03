<?php
//check the session
session_start();
require_once('connection.php');
if(isset($_SESSION["username"])){
    //grab product ID
    $item_id = $_GET['productid'] ?? null;
    if($item_id != null){
        echo "inside noty null";
        $cart = $pdo->prepare("SELECT * FROM cart WHERE cart_user  = ? AND cart_product = ?");
        $cart->execute([$_SESSION["username"],$item_id]);
        $cart_item = $cart->fetch();
        //check to see if the quantity is 0 or not
        //if it isnt take away 1
        if($cart_item['product_amount'] > 0){
             //grab quantity of this items inside this row 
             $quantity_in_row = $cart_item['product_amount'];
             $quantity_in_row -= 1;
             //check if its 0 
             //if yes delete from table
            if($quantity_in_row <= 0){
                $delete_row = $pdo->prepare('DELETE FROM cart WHERE cart_user = ? AND cart_product = ?');
                //send into the database the new quantity first checking if the user matches and then the product ID
                $delete_row->execute([$_SESSION['username'],$item_id]);
                header("Location: cart.php");
            }
            //else update value with new product
            else{
                $delete_item = $pdo->prepare('UPDATE cart SET product_amount = ? WHERE cart_user = ? AND cart_product = ?');
                //send into the database the new quantity first checking if the user matches and then the product ID
                $delete_item->execute([$quantity_in_row,$_SESSION['username'],$item_id]);
                header("Location: cart.php");
            }
        }
    }

}
header("Location: cart.php");
?>