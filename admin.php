<!DOCTYPE html>
<html lang="eng">
<?php
    session_start();
    require "db.php";
    if(!(isset($_SESSION["user"])) ){
        header('LOCATION: Index.php');
    }
    else if(isAdmin($_SESSION["user"]) == false){
        header('LOCATION: Index.php');
    }
    
    
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
                <col style="width:25%">
                <col style="width:75%">
                <tr class="admin-star-input">
                    <td>
                        <form method="POST" action="admin.php">
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
                                    addStar($_POST["adminStarName"], $_POST["adminRA"], $_POST["adminDEC"], $_POST["adminConst"], $_POST["adminDesc"]);
                                    header('LOCATION: admin.php');
                                }
                            ?>
                        </form>
                    </td>
                    <td>
                    <?php
                        $stars = getCustomerStars();
                        foreach($stars as $star){
                            $starInfo = getCustomStarInfo($star);
                            echo '<div class="custom-star-input-class">
                            <form name="'.$star.'"><div class="custom-star-input">
                            <p>'.$starInfo[0].'</p>
                            <p>'.$starInfo[1].'</p>
                            <p>'.$starInfo[2].'</p>';
                            if(!is_null($starInfo[3])) echo '<p>Constellation: '.$starInfo[3].' </p>';
                            echo '<p>'.$starInfo[4].'</p>
                            <input type="submit" name="'.$star.'Confirm">'.'
                            </div>
                            </form>
                            </div>';
                        }
                    ?>
                    </td>
                </tr>
            </table>
    </body>
</html>