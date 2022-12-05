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
                <tr>
                    <th>
                        <b>
                            Add Star
                        </b>
                    </th>
                    <th>
                        <b>
                            Add User Star
                        </b>
                    </th>
                </tr>
                <tr class="admin-star-input">
                    <td>
                        <form method="POST" action="admin.php">
                            <div class="admin-container">
                                <div class="admin-star-input-data">
                                    <input type="text" placeholder="Star Name" class="admin-star-align const" name="adminStarName">
                                </div>
                                <div class="admin-star-input-data">
                                    <input type="text" placeholder="RA" class="admin-star-align const" name="adminRA">
                                </div>
                                <div class="admin-star-input-data">
                                    <input type="text" placeholder="DEC" class="admin-star-align const" name="adminDEC">
                                </div>
                                <div class="admin-star-input-data">
                                    <input type="text" placeholder="Const" class="admin-star-align const" name="adminConst">
                                </div>
                                <div class="admin-star-input-data">
                                    <textarea placeholder="Description" class="admin-star-align admin-description const" name="adminDesc"></textarea>
                                </div>
                                <div class="admin-star-input-data">
                                    <input type="submit" placeholder="Submit" class="admin-star-align const" name="adminSubmit">
                                </div>
                            </div>
                            <?php
                                if(isset($_POST["adminSubmit"])){
                                    if(!exists($_POST["adminStarName"]) && !empty($_POST["adminStarName"]) && !empty($_POST["adminRA"]) && !empty($_POST["adminDEC"]) && !empty($_POST["adminConst"]) && !empty($_POST["adminDesc"])){
                                        addStar($_POST["adminStarName"], $_POST["adminRA"], $_POST["adminDEC"], $_POST["adminConst"], $_POST["adminDesc"]);
                                    }
                                    header('LOCATION: admin.php');
                                }
                            ?>
                        </form>
                    </td>
                    <td style="vertical-align: top;">
                    <table style="position: absolute;">
                            <col style="width: 15%;">
                            <col style="width: 10%;">
                            <col style="width: 10%;">
                            <col style="width: 15%;">
                            <col style="width: 40%;">
                            <col style="width: 5%;">
                            <col style="width: 5%">
                            <tr>
                                <th style="text-align: left;">
                                    Name
                                </th>
                                <th style="text-align: left;">
                                    RA
                                </th>
                                <th style="text-align: left;">
                                    Dec
                                </th>
                                <th style="text-align: left;">
                                    Constellation
                                </th>
                                <th style="text-align: left;">
                                    Description
                                </th>
                                <th style="text-align: left;">
                                    Add Star
                                </th>
                                <th style="text-align: left;">
                                    Remove Star
                                </th>
                            </tr>
                    <?php
                        $stars = getCustomerStars();
                        foreach($stars as $star){
                            $starInfo = getCustomStarInfo($star);
                            echo '<tr>
                            <form name="'.$star.'" method="POST" action="admin.php">
                            <td class="custom-star-margin"><p>Name: '.$starInfo[0].'</p></td>
                            <td class="custom-star-margin"><p>RA: '.$starInfo[1].'</p></td>
                            <td class="custom-star-margin"><p>DEC: '.$starInfo[2].'</p></td>';
                            if(!is_null($starInfo[3])) echo '<td class="custom-star-margin"><p>Constellation: '.$starInfo[3].' </p></td>';
                            echo '<td class="custom-star-margin"><p> Desc: '.$starInfo[4].'</p></td>
                            <td class="custom-star-margin"><input type="submit" name="'.$star.'Confirm" class="const"></td>'.'
                            <td class="custom-star-margin"><input type="submit" name="'.$star.'Remove" class="const"></td>
                            </div>
                            </form>
                            </tr>
                            ';
                        }
                        echo '</table>';

                        foreach($stars as $star){
                            if(isset($_POST[$star."Confirm"])){
                                $starInfo = getCustomStarInfo($star);
                                if(!exists($star)){
                                    addStar($starInfo[0], $starInfo[1], $starInfo[2], $starInfo[3], $starInfo[4]);
                                }
                                else{
                                    removeCustomStar($star);
                                }
                            }
                            if(isset($_POST[$star."Remove"])){
                                removeCustomStar($star);
                            }
                        }
                    ?>
                    </td>
                </tr>
            </table>
    </body>
</html>