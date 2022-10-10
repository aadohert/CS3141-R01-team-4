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

        <?php 
        require "db.php";

        session_start();


        ?>

    </head>

    <body>
            <!-- This div is used for setting up the table for the navigation bar.  -->
            <div>
                <table class="navbar-table" width="100%">
                    <col style="width: 70%">
                    <col style="width: 20%">
                    <col style="width: 10%">
                    <tr>
                        <th id="Icon"><h1><a href="/Index.php" style="margin-left: 15px;">Star Finder</a></h1></th>
                        <?php 
                            if(isset($_SESSION["user"])) {
                                echo '<th class="navbar-right-align"><h3><a href="">'.$_SESSION["user"].'\'s Favorites</a></h3></th>';
                                //add a logout button to the right of this
                            }
                            else echo '<th class="navbar-right-align"><button onclick="location.href = \'login.php\';" style="background-image: url(\'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQjrCdY7vbLNb3uuqCixRviazh7zdc0yUSB3Ou2w27iCQRKN6T1ylCGuCs1YXkTOQBTjzM&usqp=CAU\'); color:white; cursor:pointer; width:75px;height:35px;">Login</button></th>';
                        ?>
                    </tr>
                </table>
            </div>
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
                            //echo '<p style="color:green">'.$_SESSION["user"].' logs in</p>' ; 
                        }  
                        else {
                            echo '<p style="color:red"> incorrect username and password</p>' ; 
                            session_destroy(); //this is for testing purposes, later user should have a button to log out
                        }
                    }

                ?>

    </body>

</html>
