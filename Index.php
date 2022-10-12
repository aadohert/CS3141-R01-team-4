<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="eng">
    
    <header> 
        <?php 
            require "db.php";


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
            <?php 
                printTopBanner();
            ?>
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