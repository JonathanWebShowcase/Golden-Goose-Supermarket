<?php
require_once 'header.php';
require_once 'connection.php';
$category = $_GET['category'] ?? "";

//Decide what products to display based on the GET variable value
//if none provided show all
if($category == "produce"){
    $products = $pdo->query("SELECT * FROM products WHERE product_category = 'produce'");
}
elseif($category == "dairy"){
    $products = $pdo->query("SELECT * FROM products WHERE product_category = 'dairy'");
}
elseif($category == "bakery"){
    $products = $pdo->query("SELECT * FROM products WHERE product_category = 'Bakery'");
}
elseif($category == "snacks"){
    $products = $pdo->query("SELECT * FROM products WHERE product_category = 'Snacks'");
}
elseif($category == "frozen"){
    $products = $pdo->query("SELECT * FROM products WHERE product_category = 'frozen'");
}
elseif($category == "All"){
    $products = $pdo->query("SELECT * FROM products");
}
else{
    $search_item = $pdo->prepare("SELECT * FROM products WHERE product_name LIKE CONCAT('%',?,'%')");
    $search_item->execute([$category]);
    $products = $search_item->fetchAll();
}
?> 
<section class="asileContainer">
<?php
//if there is something within the array do the loop
if($products){
    foreach($products as $product){
    ?> 
    <section class="cartItem_aisle">
        <section id="aisle_image">
            <img src="<?=$product['product_img']?>">
        </section>
        <section id="aisle_name">
            <a href="individual.php?productid=<?=$product['product_primary']?>">
                <p><?=$product['product_name']?></p>
            </a>
        </section>
        <section id="aisle_info" class="original_price_promoted">
            <p><?=$product['product_originalPrice']?></p>
        </section>
        <section id="aisle_add_cart">
            <a href="add_to_cart.php?productid=<?=$product['product_primary']?>">Add To Cart</a>
        </section>
    </section>
<?php
}}
else{
    echo "<h1 id='empty_messege'>Nothing Found</h1>";
}
?>
</section>
<?php
require_once 'footer.php';
?>