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
        <link rel="stylesheet" href="\style.css">
        <title>Star Finder</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 



    </head>

    <body onload="themeChecker()">
            <?php 
                printTopBanner();
                if(!isset($_SESSION["user"])) header('LOCATION:Index.php');
            ?>
        <hr>
        <?php
        $favs = viewFavorites($_SESSION["user"]);
        foreach($favs as $star) {
            echo "<p>name: ".$star[0]."</p>";
        }
        
        ?>
        <script src="jsfunc.js"></script>
    </body>