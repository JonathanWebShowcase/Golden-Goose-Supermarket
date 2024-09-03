<?php
session_start();
require_once 'connection.php';
//Grab Form Data these should only be sent when the data is validated
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

//Hashing password as a way to encode
$newPass = password_hash($password, PASSWORD_DEFAULT);
//Using prepare since these are client submitted values 
$newUser = $pdo->prepare("INSERT INTO users (first_name, last_name, email, username, password)
            VALUES (?,?,?,?,?)");
$newUser->execute([$first_name, $last_name, $email, $username, $newPass]);

//row count returns how many rows affected by sql statement linked
//so if its higher than 0 it means a new customer was added 
if($newUser->rowCount() > 0){
    $_SESSION["username"] = $username;
    $_SESSION["FirstName"] = $first_name;
    header("Location: main.php");
}
else{
    echo "<h1>Sorry something went wrong</h1>";
}
?>