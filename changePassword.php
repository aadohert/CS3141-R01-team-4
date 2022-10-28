<?php
     /**
     * password change page
     *
     * @author  TSP team 4 
     * Julianna Cummings, River Dallas, Avery Doherty, Nicky Franklin, Brendan Fuhrman
     */

    session_start();
    require "db.php";
    if(!isset($_SESSION["user"])) header('LOCATION:Index.php');
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
            
                    if(isset($_POST["changePassword"])) {
                        $auth = authenticate($_POST["username"], $_POST["password"]);
                        if($auth[0] == 1) {
                            $_SESSION["user"]=$auth[1];
                            if (strlen($_POST["password2"]) < 8) {
                                echo '<p style="color:red">password must be at least 8 characters</p>';
                            }
                            if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["password2"])) {
                                echo '<p style="color:red">please fill in all boxes</p>';
                            }
                            if($_POST["password"] == $_POST["password2"]) {
                                echo '<p style="color:red">password already in use, please use a new password</p>';
                            }
                            else{
                                updatePassword($_POST["username"], $_POST["password2"]);
                            //$_SESSION["user"]=$_POST["username"];
                            //header("LOCATION:Index.php");
                            echo '<p style="color:green">password has been updated</p>' ;
                            }
                            }  
                        else {
                            echo '<p style="color:red"> incorrect password for account</p>' ; 
                        }
                    }
                ?>
             
        

            <form method="post" action="changepassword.php">

<label for="username"><strong>username: <br></strong></label> 
<input type="text" id="username" name="username"> 
<br> <br>

<label for="password"><strong>current password: <br></strong></label> 
<input type="password" id="password" name="password">
<br> <br>

<label for="password2"><strong>new password:<br> </strong></label> 
        <input type="password" id="password2" name="password2">
        <br> <br>


<input type="submit" name="changePassword" value="changePassword">

</form>
<p> 

<script src="jsfunc.js"></script>
    <body>
</html>
