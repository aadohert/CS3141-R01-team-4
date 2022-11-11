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

    <body onload="themeChecker()">
            <?php 
                printTopBanner();

                //if user is logged in, send them to index page instead
                if(isset($_SESSION["user"])) header('LOCATION:Index.php');

            ?>

            <hr>

                <?php 
                    if(isset($_POST["login"])) {
                        $auth = authenticate($_POST["username"], $_POST["password"]);
                        $count = checkCount($_POST["username"]);
                        if($auth[0] == 1 && $count <= 3) {
                            $_SESSION["user"]=$auth[1];
                            header("LOCATION:Index.php");
                            $count = countZero($_POST["username"]);
                            }  
                        else {
                            echo '<p style="color:red"> incorrect username and password</p>' ;
                            $checkUser = checkUsername($_POST["username"]);
                            if($checkUser[0] == 1) 
                            {
                                $count = addCount($_POST["username"]);
                                if ($count = 4)
                                {
                                    echo '<p style="color:red"> account is locked for 10 seconds</p>' ;
                                    $lockouttime = time(); 
                                }
                                if ($count > 4)
                                {
                                    if(time() - $lockouttime < 10)
                                    {
                                    echo '<p style="color:red"> account is still locked</p>' ;
                                    }else
                                    {
                                        $count = countZero($_POST["username"]);
                                    }
                                }
                            }
                        }
                    }
                ?>
                <div class="wrap-login-container">
                <div class="login-container">
                    <form method="post" action="login.php">
                        <span class="login-title"><strong>Login</strong></span>
                        <div class="login-input">
                            <label for="username" class="login-input-label"><strong>Username</strong></label> 
                            <input type="text" id="username" name="username" class="login-input-field"> 
                        </div>
                        <div class="login-input">
                            <label for="password" class="login-input-label"><strong>Password</strong></label> 
                            <input type="password" id="password" name="password" class="login-input-field">
                        </div>
                        <div class="login-button-div">
                            <input type="submit" name="login" value="login" class="login-button">
                        </div>
                        <div>
                            </p>   
                                No account? <a href="/createAccount.php">Click here to create one!<a>
                            </p>
                        </div>
                </div>
                </div>
            <script src="jsfunc.js"></script>
    </body>

</html>
