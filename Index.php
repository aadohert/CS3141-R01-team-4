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
            </div></div></form>
            </div></div> 
            <hr>
            <?php 
                if(isset($_POST["fav"])) {
                    
                    addFavorite($_SESSION["user"], $_SESSION["star"]);
                
                }
                else if (isset ($_POST["unfav"])) {
                    
                    removeFavorite($_SESSION["user"], $_SESSION["star"]);

                }
            ?>
            <table class="star" >
                <tr class = "star">
                    <td class = "star" >
                        <!-- star name form -->
                            <form action = "Index.php" autocomplete="off">
                                <div class="form-group">
                                    <input class="form-control" type="text" id="starName" name="starName" placeholder="Star Name" style="width: 150px">
                                </div>
                                <ul class="autofill"></ul>
                                <div class="form-group">
                                    <input class="form-control" type="submit" value="Calculate" name="Calculate"> 
                                </div>
                            </form>
                            <br>
                        <!-- RA and DEC form -->
                            <form action = "Index.php">
                            <div class="form-group">
                                <input class="form-control" type="text" id="RA" name="RA" placeholder="RA in Degrees" style="width: 150px">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" id="DEC" name="DEC" placeholder="DEC in Degrees" style="width: 150px">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="submit" value="Calculate" name="Calculate"> 
                            </div>  
                            </form>

                    </td>
                    <td class = "star">
                        <?php 
                            //default if button hasn't been hit
                            if(!isset($_GET["Calculate"])) {
                                echo "<h1> Welcome to the Starfinder site!</h1>
                                <p> Put a star's name or its right ascension and declination to find where it is relative to Houghton, Michigan </p>";
                            }
                            //runs if calculate is hit
                            else {
                                //checks user filled in either the starname or both of RA and DEC
                                if(!empty($_GET["starName"]) || !empty($_GET["RA"]) && !empty($_GET["DEC"])) {
                                    
                                    $star = 0;
                                    //calls starname query or RA and DEC query, depending 
                                    if(!empty($_GET["starName"])) $star = queryStarByName($_GET["starName"]);
                                    else $star = queryStarByRAandDEC($_GET["RA"], $_GET["DEC"]);

                                    if ($star == 0 ) {
                                        echo '<p style="color:red">Star does not exist in our database</p>';
                                        if (!empty($_GET["RA"]) && !empty($_GET["DEC"])) {
                                            $starAlt = round(radiansToDegrees(altitudeWhenGivenCoords($_GET["RA"], $_GET["DEC"], 'now')), 2, PHP_ROUND_HALF_DOWN);
                                            $starAz = round(radiansToDegrees(azimuthWhenGivenCoords($_GET["RA"], $_GET["DEC"], 'now')), 2, PHP_ROUND_HALF_DOWN);
                                            echo "<p>if the star exists it would be found at these points: ";
                                            echo "<br>Star's Altitude: ".$starAlt."          Star's Azimuth: ".$starAz."</p>";
                                        }
                                    }
                                    else {
                                        echo '<h1>Star Name: '.$star[0].'</h1>';
                                        $_SESSION["star"] = $star[0];
                                        if(!is_null($star[3])) echo '<p>Constellation: '.$star[3].' </p>';
                                        echo '<p>About: '.$star[4].'</p>';

                                        $starAlt = round(radiansToDegrees(altitudeWhenGivenName($star[0], 'now')), 2, PHP_ROUND_HALF_DOWN);
                                        $starAz = round(radiansToDegrees(azimuthWhenGivenName($star[0], 'now')), 2, PHP_ROUND_HALF_DOWN);
                                        
                                        //echo "<p> DEC: ".$star[2]." RA: ".$star[1]." </p>";
                                        echo "<p>Star can be found at <br>";
                                        echo 'Altitude: '.$starAlt.' Azimuth: '.$starAz.'</p>';
                                        
                                        
                                        if (isset($_SESSION["user"])) {
                                            $favorited = hasBeenFavorited($_SESSION["user"], $_SESSION["star"]);

                                            if(0 == $favorited) echo '<form method = "post" action = "Index.php?starName='.str_replace(" ", "+", $_SESSION["star"]).'&Calculate=Calculate"> <button id = "fav" name = "fav" value = "fav">Favorite Star</button> </form>';
                                            else echo '<form method = "post" action = "Index.php?starName='.str_replace(" ", "+", $_SESSION["star"]).'&Calculate=Calculate"> <button id = "unfav" name = "unfav" value = "unfav">Unfavorite Star</button> </form>';
                                        }
                                    }
                                    
                                }
                                else echo '<p style="color:red">To find a star please insert a name or right ascension and declination</p>';
                            }
                        ?>

                    </td>
                </tr>

                </div>
            <td> <?php if (isset($_SESSION["user"])) echo '<a href="/changePassword.php">Change Password</a>'; ?> </td>
            </table>

            <script src="jsfunc.js"></script>
            <script>
                
                var arr = <?php echo getStars();?>;
                var limit = 0;
                let autoFillInput = document.getElementById("starName");
                autoFillInput.addEventListener("keyup", function(){
                removeElements();
                for(let i of arr){
                    if(i.toLowerCase().startsWith(autoFillInput.value.toLowerCase()) && autoFillInput.value != ""){
                        if(limit >= 4){
                            break;
                        }
                        limit++;
                        let listItem = document.createElement("li");
                        listItem.classList.add("list-items");
                        listItem.style.cursor = "pointer";
                        listItem.setAttribute("onclick", "displayNames('" + i + "')");
                        let word = "<b>" + i.substring(0, autoFillInput.value.length) + "</b>";
                        word += i.substr(autoFillInput.value.length);
                        listItem.innerHTML = word;
                        document.querySelector(".autofill").appendChild(listItem);
                    }
                 }
            });
            </script>
    </body>
</html>
