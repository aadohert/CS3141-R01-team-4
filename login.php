<?php
    session_start();
    require "db.php";
?>
<!DOCTYPE html>
<html lang="eng">

    <head>
        <style>
            a:visited{
                text-decoration: none;
                color: black;
            }
            a{
                text-decoration: none;
            }
            th#Icon{
                text-align: left;
            }
            th.navbar-right-align{
                text-align: right;
            }
            .form-group{
                margin-bottom: 10px;
            }
            #starNameDiv{
                margin-bottom: 75px;
            }
            .divOffSet{
                margin-left: 15px;
            }
        </style>
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

    </body>

</html>
