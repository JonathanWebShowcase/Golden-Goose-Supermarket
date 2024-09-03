<?php
//get header and database file
require_once 'header.php';
require_once 'connection.php';
$username = $_POST["username"] ?? "";
$password = $_POST["password"] ?? "";
$submit_value = $_POST["submitvalue"] ?? "";
$messege = "";
//check to see if user is logged in and send to profile.php if yes
?>
<?php
//Define Regular expressions
$symbols_regex = '/[!@#$%^&*()\-_=+{};:,<.>]/';
$number_regex = '/[0-9]/';

//Validate inputs 
//I realise the only validation I need here is the username and password matching
//Username

/*
//length greater than 8 and less that 12
if(strlen($username) > 8 && strlen($username) < 12){
    $username_testOne = true;
}
else{
    $username_testOne = false;
}

//Password

//length greater than 8
if(strlen($password) >= 8) {
    $password_testOne = true;
}
else{
    $password_testOne = false;
}
//length less than 12
if(strlen($password) >= 12) {
    $password_testTwo = true;
}
else{
    $password_testTwo = false;
}

//number
if(preg_match($number_regex, $password)) {
    $password_testTwo = true;
}
else{
    $password_testTwo = false;
}
//symbols
if(preg_match($symbols_regex, $password)) {
    $password_testThree = true;
}
else{
    $password_testThree = false;
}
*/
//If all tests passed try to access database and log user in

   //if the username is send to the server run the Sql ELSE set the variable to 0
try
{
    $attempt_logIN = $pdo->prepare("SELECT username, password, first_name FROM  users WHERE username = ?");
    $attempt_logIN->execute([$username]);
    //Check to see if there was a return from the database 
    if($Bababooey = $attempt_logIN->fetch()){
        $pleas_god_no = password_verify($password, $Bababooey["password"]);
        if ($pleas_god_no){
            // create a session for the user 
            $_SESSION["username"] = $username;
            $_SESSION["FirstName"] = $Bababooey["first_name"];
            header("Location: main.php");
            exit; 
        }
        else{
            $messege = "please end my suffering";
        }
    }
    //If the messege is empty and the database returns something there will be an error messege 
    //a hidden value is sent through POST and this conditions check to see if the submit button was sent and returns the error messege
    elseif ($submit_value =='Login!'){
        $messege = "Username Or Password is incorrect";
    }
    //the default is to leave the messege blank so the client doesnt see an error messege when first accessing the page
}
catch (\PDOException $e) 
{
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}


?>
<form id="LoginForm" action="login.php" method="POST">
<input type="text" name="username" id="username" placeholder="Enter a username" />
<br/>
<input type="password" name="password" id="password" placeholder="Enter a password" />
<br />
<input type="submit" value="Login!" id="login-button" name="submitvalue"/>
<a id="signUpbutton" href="signUp.php">Join the family!</a>
<h1><?=$messege?></h1>
</form>
