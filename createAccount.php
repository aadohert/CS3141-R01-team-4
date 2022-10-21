<?php
     /**
     * account creation page
     *
     * @author  TSP team 4 
     * Julianna Cummings, River Dallas, Avery Doherty, Nicky Franklin, Brendan Fuhrman
     */

    session_start();
    require "db.php";
?>
<!DOCTYPE html>
<html lang="eng">    
    <head>
        <link rel="stylesheet" href="style.css">
        <title>Star Finder</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 



    </head>

    <body onload="themeChecker()">
        <?php
            printTopBanner();
            ?><hr><?php

            //if the user is logged in, send them back to index page instead
            if(isset($_SESSION["user"])) header('LOCATION:Index.php');

            //if user has pressed the create button, check all inputs are valid before creating account
            if(isset($_POST["create"])) {
                //checks all boxes are filled
                if (empty($_POST["username"]) || empty($_POST["password1"]) || empty($_POST["password2"])) {
                    echo '<p style="color:red">please fill in all boxes</p>';
                }
                //check username is short enough 
                else if (strlen($_POST["username"]) > 50) {
                    echo '<p style="color:red">username is too long, please pick a shorter one</p>';
                }
                //checks password is long enough 
                else if (strlen($_POST["password1"]) < 8) {
                    echo '<p style="color:red">password must be at least 8 characters</p>';
                }
                //matches passwords, creates account if they do
                else if($_POST["password1"] == $_POST["password2"]) {
                    //create user will throw error if the username is already in use
                    $_SESSION["user"] = createUser($_POST["username"], $_POST["password1"]);
                    if(isset($_SESSION["user"])) header('LOCATION:Index.php');
                }
                //error if passwords don't match
                else echo '<p style="color:red">passwords do not match</p>';
            
                
            }
            
        ?>

        <form method="post" action="createAccount.php">

        <label for="username"><strong>username:<br> </strong></label> 
        <input type="text" id="username" name="username"> 
        <br> <br>

        <label for="password"><strong>password:<br> </strong></label> 
        <input type="password" id="password1" name="password1">
        <br> <br>

        <label for="password2"><strong>confirm password:<br> </strong></label> 
        <input type="password" id="password2" name="password2">
        <br> <br>

        <input type="submit" name="create" value="create">


        </form>
        
        <script src="jsfunc.js"></script>
    <body>
</html>
