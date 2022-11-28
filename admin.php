<!DOCTYPE html>
<html lang="eng">
<?php
    session_start();
    require "db.php";
    
    
?>    
    <head>
        <link rel="stylesheet" href="style.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <script src="jsfunc.js"></script>

    </head>

    <body class="light-mode" onload="themeChecker()">
            <?php 
                printTopBanner();
            ?>
            <hr>
            <table class="admin-page-org">
                <col style="width:50%">
                <col style="width: 50%;"
                <tr class="admin-star-input">
                    <td>
                        <form>
                            <div class="admin-container">
                                <div class="admin-star-input-data">
                                    <input type="text" placeholder="Star Name">
                                </div>
                                <div class="admin-star-input-data">
                                    <input type="text" placeholder="RA">
                                </div>
                                <div class="admin-star-input-data">
                                    <input type="text" placeholder="DEC">
                                </div>
                                <div class="admin-star-input-data">
                                    <input type="text" placeholder="Constellation">
                                </div>
                                <div class="admin-star-input-data">
                                    <input type="text" placeholder="Description">
                                </div>
                                <div class="admin-star-input-data">
                                    <input type="submit" name="submit" placeholder="Submit">
                                </div>
                            </div>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>

                    </td>
                </tr>
            </table>
    </body>
</html>