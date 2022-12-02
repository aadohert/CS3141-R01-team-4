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
                            echo '<table><tr>
                            <form name="'.$star.'" method="POST" action="admin.php">
                            <td><p>Name: '.$starInfo[0].'</p></td>
                            <td><p>RA: '.$starInfo[1].'</p></td>
                            <td><p>DEC: '.$starInfo[2].'</p></td>';
                            if(!is_null($starInfo[3])) echo '<td><p>Constellation: '.$starInfo[3].' </p></td>';
                            echo '<td><p> Desc: '.$starInfo[4].'</p></td>
                            <td><input type="submit" name="'.$star.'Confirm"></td>'.'
                            </div>
                            </form>
                            </tr>
                            ';
                        }
                        echo '</table>';

                        foreach($stars as $star){
                            if(isset($_POST[$star."Confirm"])){
                                $starInfo = getCustomStarInfo($star);
                                addStar($starInfo[0], $starInfo[1], $starInfo[2], $starInfo[3], $starInfo[4]);
                            }
                        }
                    ?>
                    </td>
                </tr>
            </table>
    </body>
</html>