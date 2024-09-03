<?php
//Start the session so every page will be able to read ana access the session
//on every page wehre header is required there will be the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/slideshow.css">
    <link rel="stylesheet" href="CSS/navbar.css">
    <link rel="stylesheet" href="CSS/cards.css">
    <link rel="stylesheet" href="CSS/login.css">
    <link rel="stylesheet" href="CSS/footer.css">
    <link rel="stylesheet" href="CSS/aisle.css">
    <link rel="stylesheet" href="CSS/signUp.css">
    <link rel="stylesheet" href="CSS/cart.css">
    <link rel="stylesheet" href="CSS/individual.css">
</head>
<body>
<?php require_once 'connection.php'?>
<section id="navigation_container">
    <nav>
        <section id="logoContainer">
            <a id="anchor_container" href="main.php">
                <img id="logo_image" src="img/goose (1).gif" alt="Logo Of Golden Goose">
                <h1 id="logo_title">The Golden Goose</h1>
            </a>
        </section>
        <section id="searchContainer">
            <form id="search_container_form" action="aisles.php" method="get">
                <input type="search" name="category" id="search_bar" placeholder="Search For Item">
            </form>
        </section>
        <section id="User">
            <?php
            //If the user is logged in display view account else display login
            if(isset($_SESSION['username'])){
                echo '<a href="profile.php">
                <img id="login_image" src="img/LoggenIN.png" alt="Login Logo">
                <p>Profile</p>
                </a>';
            }
            else{
                echo '<a href="login.php">
                <img id="login_image" src="img/login_login.png" alt="Login Logo">
                <p>Log In</p>
                </a>';
            }
            ?>
        </section>
        <section id="cart">
            <a href="cart.php">
                <img id="cart_image" src="img/cart_cart.png" alt="Cart Logo">
                <p>Cart</p>
            </a>
        </section>
    </nav>
    <section id="aisles">
        <ul>
            <li><a href="aisles.php?All">All</a></li>
            <li><a href="aisles.php?category=produce">Produce</a></li>
            <li><a href="aisles.php?category=frozen">Frozen</a></li>
            <li><a href="aisles.php?category=dairy">Dairy</a></li>
            <li><a href="aisles.php?category=bakery">Bakery</a></li>
            <li><a href="aisles.php?category=snacks">Snacks</a></li>
        </ul>
    </section>
</section>
