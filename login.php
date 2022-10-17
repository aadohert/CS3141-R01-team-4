<?php
    /**
     * Login page
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

    <body>
            <?php 
                printTopBanner();

                //if user is logged in, send them to index page instead
                if(isset($_SESSION["user"])) header('LOCATION:Index.php');

            ?>

            <hr>

                <form method="post" action="login.php">

                <label for="username"><strong>username: <br></strong></label> 
                <input type="text" id="username" name="username"> 
                <br> <br>

                <label for="password"><strong>password: <br></strong></label> 
                <input type="password" id="password" name="password">
                <br> <br>

                <input type="submit" name="login" value="login">

                </form>
                <p> 
                No account? <a href="/createAccount.php">Click here to create one!<a>
                </p>    

                <?php
                    if(isset($_POST["login"])) {

                        $auth = authenticate($_POST["username"], $_POST["password"]);
                        if($auth == 1) {
                            $_SESSION["user"]=$_POST["username"];
                            header("LOCATION:Index.php");
                        }  
                        else {
                            echo '<p style="color:red"> incorrect username and password</p>' ; 
                        }
                    }

                ?>
            <script src="jsfunc.js"></script>
    </body>

</html>
