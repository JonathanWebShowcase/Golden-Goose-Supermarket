<?php 
require_once 'header.php';
?>
<?php require_once 'connection.php';?>
<section id="slideshowContainer">
    <section id="container_slider">
        <?php
        //For Each Loop 
        $index = 1;
        $slide_query = $pdo->query("SELECT * FROM slides");
        //I need to use a fetchALL in order to create an array that I can edit the first value of when a user is logged in
        $slides = $slide_query->fetchALL();
        //Check to see if a user is logged in
        if (isset($_SESSION["username"])){
            $slides[0]['slide_header'] = "Welcome " . $_SESSION["FirstName"];
        }
        foreach ($slides as $slide)
        {
        ?>
            <section class="slide_container" id="slide_<?=$index?>">
                <img src="<?=$slide['slide_img']?>" class="slideshow_image">
                <section class="slide_text">
                    <h1 class="header"><?=$slide['slide_header']?></h1>
                    <p class="paragraph"><?=$slide['slide_text']?></p>
                    <?php
                    //check if its slide one and not put a link in the slide
                    if($index == 1){
                        
                    }
                    else{
                        echo '<a class="link" href="aisles.php?' . $slide['slide_category'] . '">' . ucfirst($slide['slide_category']) . '</a>';
                    }
                    ?>
                </section>
            </section>
        <?php
        $index += 1;
        }
        ?>
    </section>
</section>
<section id="slideshow_navigation">
    <a href="#slide_1"></a>
    <a href="#slide_2"></a>
    <a href="#slide_3"></a>
    <a href="#slide_4"></a>
    <a href="#slide_5"></a>
    <a href="#slide_6"></a>
</section>
<main class="main_container">

<h1 class="headings">Sales!</h1>
    <section id="sales_container">
        <?php
        //grab each product that has a sale
        $sales = $pdo->query("SELECT * FROM products WHERE sale_status = 'true'");
        //Loop through table to populate page
        foreach($sales as $sale){
        ?> 
        <section class="cardItem">
            <section id="sale_image">
                <img src="<?=$sale['product_img']?>">
            </section>
            <section id="sale_name">
                <p><?=$sale['product_name']?></p>
            </section>
            <section id="sale_info">
                <p id="original_price"><?=$sale['product_originalPrice']?></p>
                <p id="sale_price"><?=$sale['product_salesPrice']?></p>
            </section>
            <section id="add_cart">
                <a href="add_to_cart.php?productid=<?=$sale['product_primary']?>">Add To Cart</a>
            </section>
        </section>
        <?php
        }
        ?>
    </section>


<h1 class="headings">Promoted</h1>
    <section id="sales_container">
        <?php
        //grab each product that has a promotion
        $promotions = $pdo->query("SELECT * FROM products WHERE promoted = 'true'");
        //Loop through table to populate page
        foreach($promotions as $promotion){
        ?> 
        <section class="cardItem">
            <section id="sale_image">
                <img src="<?=$promotion['product_img']?>">
            </section>
            <section id="sale_name">
                <p><?=$sale['product_name']?></p>
            </section>
            <section id="sale_info" class="original_price_promoted">
                <p><?=$promotion['product_originalPrice']?></p>
            </section>
            <section id="add_cart">
                <a href="add_to_cart.php?productid=<?=$promotion['product_primary']?>">Add To Cart</a>
            </section>
        </section>
        <?php
        }
        ?>
    </section>

</main>
<?php require_once 'footer.php';?>