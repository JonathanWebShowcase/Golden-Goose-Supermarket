<?php
require_once 'header.php';
require_once 'connection.php';
//Grad the primary key of the product
$productID = $_GET['productid'] ?? "";
//prepare a SQL and then execute using the variable provided
$products = $pdo->prepare("SELECT * FROM products WHERE product_primary = ?");
$products->execute([$productID]);
//fetch profuct
$individual_product = $products->fetch();
?>
<section class="cardItem_individual">
    <section id="individual_image">
        <img src="<?=$individual_product['product_img']?>">
    </section>
    <section id="individual_name">
        <p><?=$individual_product['product_name']?></p>
    </section>
    <section id="individual_info">
        <p><?=$individual_product['product_originalPrice']?></p>
    </section>
    <section id="individual_add_cart">
        <a href="add_to_cart.php?productid=<?=$product['product_primary']?>">Add To Cart</a>
    </section>
</section>
<?php
require_once 'footer.php';
?>