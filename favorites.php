<?php
    /**
     * favorites page
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
                if(!isset($_SESSION["user"])) header("LOCATION:Index.php");

                if (isset ($_POST["unfav"])) {
                    
                    removeFavorite($_SESSION["user"], $_SESSION["star"]);

                } 
            ?>
        <hr>
        <?php
        if(isset($_POST["favStar"])) {
            $starInfo = queryStarByName($_POST["favStar"]);
            echo '<h1>Star Name: '.$starInfo[0].'</h1>';
            $_SESSION["star"] = $starInfo[0];
            if(!is_null($starInfo[3])) echo '<p>Constellation: '.$starInfo[3].' </p>';
            echo '<p>About: '.$starInfo[4].'</p>';

            $starAlt = round(radiansToDegrees(altitudeWhenGivenName($starInfo[0], 'now')), 2, PHP_ROUND_HALF_DOWN);
            $starAz = round(radiansToDegrees(azimuthWhenGivenName($starInfo[0], 'now')), 2, PHP_ROUND_HALF_DOWN);
                    
            //echo "<p> DEC: ".$star[2]." RA: ".$star[1]." </p>";
            echo "<p>Star can be found at <br>";
            echo 'Altitude: '.$starAlt.' Azimuth: '.$starAz.'</p>';

            echo '<form method = "post" action = "favorites.php"> <button id = "unfav" name = "unfav" value = "unfav">Unfavorite Star</button> </form>';
            echo '<br>';
        }
        else {
            $username = str_replace("<", "&lt", $_SESSION["user"]);
            $username = str_replace(">", "&gt", $username);
            echo "<h1>".$username."'s Favorite Stars</h1>";
            echo "<p>select a star below to view info about it</p> <br>";
        }
        $favs = viewFavorites($_SESSION["user"]);
        if(empty($favs)) echo "<p>You have no favorited stars! Go to the index page and find some to favorite :)";
        foreach($favs as $star) {
            //echo "<p>name: ".$star[0]."</p>";
            echo '
            <form method="post" action="favorites.php" class="inline">
            <input type="hidden" name="favStar" value="'.$star[0].'">
            <button type="submit" class="const" name="favStar" value="'.$star[0].'" class="link-button">
                '.$star[0].'
            </button>
            </form>';
        }
        
        ?>
        <script src="jsfunc.js"></script>
    </body>