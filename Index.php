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
            </div></div> <a href="/changePassword.php">Change Password<a>
            <hr>
            
            <table>
                <tr>
                    <td>
                        <!-- star name form -->
                            <form action = "Index.php">
                                <div class="form-group">
                                    <input class="form-control" type="text" id="starName" name="starName" placeholder="Star Name" style="width: 150px">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="submit" value="Calculate" name="Calculate"> 
                                </div>
                            </form>
                            <br>
                        <!-- RA and DEC form -->
                            <form action = "Index.php">
                            <div class="form-group">
                                <input class="form-control" type="text" id="RA" name="RA" placeholder="RA" style="width: 150px">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" id="DEC" name="DEC" placeholder="DEC" style="width: 150px">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="submit" value="Calculate" name="Calculate"> 
                            </div>  
                            </form>

                    </td>
                    <td>
                        <?php 
                            if(!isset($_GET["Calculate"])) {
                                echo "<h1> Welcome to the Starfinder site!</h1>
                                <p> Put a star's name or its right ascension and declination to find where it is relative to Houghton, Michigan </p>";
                            }
                            else {
                                //call query, return info 
                            }
                        ?>

                    </td>
                </tr>

                </div>

            </table>

            <script src="jsfunc.js"></script>
    </body>
</html>
