<?php
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
            ?>

            <hr>

                <form method="post" action="login.php">

                <label for="username"><strong>username: </strong></label> 
                <input type="text" id="username" name="username"> 
                <br> <br>

                <label for="password"><strong>password: </strong></label> 
                <input type="password" id="password" name="password">
                <br> <br>

                <input type="submit" name="login" value="login">

                </form>

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

    </body>

</html>
