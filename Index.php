<!DOCTYPE html>
<html lang="eng">
    <header> 
        <?php 
            require "db.php";

            session_start();

        ?>
    <header>
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
            <!-- This div is used for setting up the table for the navigation bar.  -->
            <div>
                <table class="navbar-table" width="100%">
                    <col style="width: 70%">
                    <col style="width: 20%">
                    <col style="width: 10%">
                    <tr>
                        <th id="Icon"><h1><a href="/Index.php" style="margin-left: 15px;">Star Finder</a></h1></th>
                        
                        <?php
                            if(isset($_SESSION["user"])) echo '<th class="navbar-right-align"><h3><a href="/Favorites.php">'.$_SESSION["user"].'\'s Favorites</a></h3></th>';
                            else echo '<th class="navbar-right-align"><h3><a href="/Login.php">Favorites</a></h3></th>';
                        
                             
                            if(isset($_SESSION["user"])) echo '<th class="navbar-right-align"><button onclick="location.href = \'logout.php\';" style="background-image: url(\'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQjrCdY7vbLNb3uuqCixRviazh7zdc0yUSB3Ou2w27iCQRKN6T1ylCGuCs1YXkTOQBTjzM&usqp=CAU\'); color:white; cursor:pointer; width:75px;height:35px;">Log Out</button></th>';
                            else echo '<th class="navbar-right-align"><button onclick="location.href = \'login.php\';" style="background-image: url(\'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQjrCdY7vbLNb3uuqCixRviazh7zdc0yUSB3Ou2w27iCQRKN6T1ylCGuCs1YXkTOQBTjzM&usqp=CAU\'); color:white; cursor:pointer; width:75px;height:35px;">Login</button></th>';
                        ?>

                        
                    </tr>
                </table>
            </div>
            <hr>
            <!--Div for inputting the star name-->
            <div id="starNameDiv" class="divOffSet">
                <form style="margin-top:20px;">
                    <div class="form-group">
                        <input class="form-control" type="text" id="starName" name="starName" placeholder="Star Name" style="width: 150px">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="submit" value="Calculate"> 
                    </div>  
                </form>

            </div>
            <!--Div for inputting the RA and Dec-->
            <div class="divOffSet">
               <form>
                    <div class="form-group">
                        <input class="form-control" type="text" id="starName" name="starName" placeholder="RA" style="width: 150px">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" id="starName" name="starName" placeholder="Dec" style="width: 150px">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="submit" value="Calculate"> 
                    </div>  
                </form>
            </div>
    </body>
</html>