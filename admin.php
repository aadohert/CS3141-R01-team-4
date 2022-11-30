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
            <table class="admin-page-org" style="width: 100%;">
                <col style="width:50%">
                <col style="width:50%">
                <tr class="admin-star-input">
                    <td>
                        <form>
                            <div class="admin-container">
                                <div class="admin-star-input-data">
                                    <input type="text" placeholder="Star Name" class="admin-star-align" name="adminStarName">
                                </div>
                                <div class="admin-star-input-data">
                                    <input type="text" placeholder="RA" class="admin-star-align" name="adminRA">
                                </div>
                                <div class="admin-star-input-data">
                                    <input type="text" placeholder="DEC" class="admin-star-align" name="adminDEC">
                                </div>
                                <div class="admin-star-input-data">
                                    <input type="text" placeholder="Const" class="admin-star-align" name="adminConst">
                                </div>
                                <div class="admin-star-input-data">
                                    <textarea placeholder="Description" class="admin-star-align admin-description" name="adminDesc"></textarea>
                                </div>
                                <div class="admin-star-input-data">
                                    <input type="submit" placeholder="Submit" class="admin-star-align" name="adminSubmit">
                                </div>
                            </div>
                            <?php
                                if(isset($_POST["adminSubmit"])){
                                    $_POST["adminStarname"];
                                }
                            ?>
                        </form>
                    </td>
                    <td>
                        <div>
                            <p>Test</p>
                        </div>
                    </td>
                </tr>
            </table>
    </body>
</html>