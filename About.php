<?php
     /**
     * the main landing page for the site
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

    <body class="light-mode" onload="themeChecker()">
        <?php 
            printTopBanner();
        ?>
        </div></div><hr>
        <p>This site is designed to tell users from Houghton, Michigan where to find where a star is currently located relative to the horizon and cardinal directions. <br>
            The azimuth is how many degrees from due north you would need to turn, and the altitude is how many degrees up. To find altitude on hand, you can use thumb measurements - place your thumb horizontal on the horizon line, and each width of it is 2 degrees.
        </p>
        <br>
        <p>This website is made possible from hosting by Michigan Technological University</p>
        <img src="hukees.png" width="100">

        <script src="jsfunc.js"></script>
    </body>

</html>