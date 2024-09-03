<?php
require_once('header.php');
//check if user is logged in If yes display the content of their account
//else send them back home

//if theres nothing set it will turn to true, if true it will turn to false 
if(!isset($_SESSION["username"])){
    header("Location: main.php");
}
else{
    //pull all the information from SQL where username username is the same as ana existing row
    $profile = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $profile->execute([$_SESSION["username"]]);
    $profile_result = $profile->fetch();
    //loop through data
    echo '<section class="profilecontainer">';
    echo '<h1 id="profile_name">First Name: ' . $profile_result['first_name'] . '</h1>';
    echo '<h1 id="profile_name">Last Name: ' . $profile_result['last_name'] . '</h1>';
    echo '<a href="logout.php">Logout</a>';
    echo '</section>';
}
require_once('footer.php');
?>