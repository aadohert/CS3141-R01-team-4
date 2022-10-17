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

    <body class="light-mode" onload="themeChecker()">
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
            <script src="jsfunc.js"></script>
    </body>
</html>