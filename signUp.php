<?php
require_once 'header.php';
require_once 'connection.php';
$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$email = $_POST['email'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$userNames_data = $pdo->query("SELECT username FROM users");
$_list_usernames = $userNames_data -> fetchAll();
$messege = "";
$submit_value = $_POST["submitUser"] ?? "";
//Do the validation up here to check if the variables are what I need them to be 
//and if not return the variables as the values of the form elements 
//dont send form unless the criteria is met 

//Define Regular expressions
$symbols_regex = '/[!@#$%^&*()\-_=+{};:,<.>]/';
$number_regex = '/[0-9]/';
//these are like wildcards in linux
// the / starts the string pattern, the \. matches the dot, the stick is like OR operator, $ means it should be at the end of the string, /i makes it c se insensitive
$domain_regex = '/\.(com|edu)$/i';

//Validate inputs only when the form has been submited using the hidden submit value
if($submit_value =='Sign Up!'){

    //Names
    //No symbols
    if(preg_match($symbols_regex, $first_name)) {
        $firstName_testOne = false;
    }
    else{
        $firstName_testOne = true;
    }
    //no symbols
    if(preg_match($symbols_regex, $last_name)) {
        $lastName_testOne = false;
    }
    else{
        $lastName_testOne = true;
    }

    //email
    //must have @ symbol
    if(preg_match('/@/', $email)) {
        $email_testOne = true;
    }
    else{
        $email_testOne = false;
    }
    //.com or .edu
    if(preg_match($domain_regex, $email)) {
        $email_testTwo = true;
    }
    else{
        $email_testTwo = false;
    }

    //Username
    //length greater than 8 and less that 12
    if(strlen($username) >= 8 && strlen($username) <= 12){
        $username_testOne = true;
    }
    else{
        $username_testOne = false;
    }
    //Must not match user in database
    //for this I have to loop throuhg an array returned by the database of different user names 
    // Loop through the array of arrays
    foreach ($_list_usernames as $user) {
        // Check if the value exists in the 'username' key
        if ($user['username'] === $username) {
            $username_testTwo = false;
            break; // Exit the loop once the value is found
        }
        else{
            $username_testTwo = true;
        }
    }
    //Password
    //length greater than 8
    if(strlen($password) >= 8) {
        $password_testOne = true;
    }
    else{
        $password_testOne = false;
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
    if ($password === $confirm_password){
        $password_testFour = true;
    }
    else{
        $password_testFour = false;
    }
    //If all tests passed try to access database and log user in
    if ($firstName_testOne &&
        $lastName_testOne &&
        $email_testOne &&
        $email_testTwo &&
        $username_testOne &&
        $username_testTwo &&
        $password_testOne &&
        $password_testTwo &&
        $password_testThree &&
        $password_testFour) {
    //if all tests passed then an account is created 
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
    }
    else{
        //checks if the form has been submitted at least once
        if ($submit_value =='Sign Up!'){
            $messege = "Please Check And Try Again";
        }
    }
}
else{
   //do nothing 
}

//each rule will have a nested ternary opperator, first to check if the value exists using isset
//If yes it will perform the seacond ternary operator else it will return id=grey
//The second ternary operator will check if the test has been passed and echo green or red depeinfing on if true or false
?>


<form id="signUpForm" action="signUp.php" method="POST">
    <input type="text" name="first_name" id="first_name" placeholder="Enter your first name" value="<?=$first_name?>"/>
    <br/>
    <ul class="firstNameRules">
        <li id="<?= isset($firstName_testOne) ? ($firstName_testOne ? 'green' : 'red') : 'grey' ?>"> Must Not Contain Symbols</li>
    </ul>
    <input type="text" name="last_name" id="last_name" placeholder="Enter your last name" value="<?=$last_name?>"/>
    <br/>
    <ul class="lastNameRules">
        <li id="<?= isset($lastName_testOne) ? ($lastName_testOne ? 'green' : 'red') : 'grey' ?>" >Must Not Contain Symbols</li>
    </ul> <br>
    <input type="text" name="email" id="email" placeholder="Enter your email" value="<?=$email?>"/>
    <br/> 
    <ul class="emailRules">
        <li id="<?= isset($email_testOne) ? ($email_testOne ? 'green' : 'red') : 'grey' ?>" >Must Contain '@' symbol</li>
        <li id="<?= isset($email_testTwo) ? ($email_testTwo ? 'green' : 'red') : 'grey' ?>" >Must Have Valid Domain Name</li>
    </ul> <br>
    <input type="text" name="username" id="username_signUp" placeholder="Enter a username" value="<?=$username?>"/>
    <br/>
    <ul class="usernameRules">
        <li id="<?= isset($username_testOne) ? ($username_testOne ? 'green' : 'red') : 'grey' ?>" >Must be between 8 - 12 Characters long</li>
        <li id="<?= isset($username_testTwo) ? ($username_testTwo ? 'green' : 'red') : 'grey' ?>" >Username Must Not Exist</li>
    </ul> <br>
    <input type="password" name="password" id="password_signUp" placeholder="Enter a password" value="<?=$password?>"/>
    <br />
    <ul class="passwordRules">
        <li id="<?= isset($password_testOne) ? ($password_testOne ? 'green' : 'red') : 'grey' ?>" >Must be longer than 8 characters</li>
        <li id="<?= isset($password_testTwo) ? ($password_testTwo ? 'green' : 'red') : 'grey' ?>" >Must contain at least one number</li>
        <li id="<?= isset($password_testThree) ? ($password_testThree ? 'green' : 'red') : 'grey' ?>" >Must contain at least one symbol</li>
    </ul> <br>
    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password" />
    <br />
    <ul class="confirmPasswordRules">
        <li id="<?= isset($password_testFour) ? ($password_testFour ? 'green' : 'red') : 'grey' ?>" >Password Must Match</li>
    </ul> <br>
    <input type="submit" value="Sign Up!" name="submitUser"/>
    <p><?=$messege ?></p>
</form>

