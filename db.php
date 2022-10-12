<html>
<?php
function connectDB() {
    $config = parse_ini_file("Starfinder.ini");
    $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

function authenticate($user, $passwd) {
    $dbh = connectDB();
    $statement = $dbh->prepare("SELECT count(*) FROM t_users "
    ."where username = :username and passwd = sha2(:passwd,256) ");
    $statement->bindParam(":username", $user);
    $statement->bindParam(":passwd", $passwd);
    $result = $statement->execute();
    $row=$statement->fetch();
    $dbh=null;
    return $row[0];

}

function printTopBanner() {
    echo '
    <div> 
        <table class="navbar-table" width="100%">
            <col style = "width: 70%">
            <col style="width: 20%">
            <col style="width: 10%">
            <tr> 
                <th id="Icon"><h1><a href="/Index.php" style="margin-left: 15px;">Star Finder</a></h1></th>
            ';

    if(isset($_SESSION["user"])) echo '<th class="navbar-right-align"><h3><a href="/Favorites.php">'.$_SESSION["user"].'\'s Favorites</a></h3></th>';
    else echo '<th class="navbar-right-align"><h3><a href="/Login.php">Favorites</a></h3></th>';
        
             
    if(isset($_SESSION["user"])) echo '<th class="navbar-right-align"><button onclick="location.href = \'logout.php\';" style="background-image: url(\'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQjrCdY7vbLNb3uuqCixRviazh7zdc0yUSB3Ou2w27iCQRKN6T1ylCGuCs1YXkTOQBTjzM&usqp=CAU\'); color:white; cursor:pointer; width:75px;height:35px;">Log Out</button></th>';
    else echo '<th class="navbar-right-align"><button onclick="location.href = \'login.php\';" style="background-image: url(\'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQjrCdY7vbLNb3uuqCixRviazh7zdc0yUSB3Ou2w27iCQRKN6T1ylCGuCs1YXkTOQBTjzM&usqp=CAU\'); color:white; cursor:pointer; width:75px;height:35px;">Login</button></th>';
        
    echo '
            </tr>
        </table>
    </div>
    ';

}

function daysSince2000() {
    $days = strtotime("now") - strtotime('01-01-2000');
    $days = $days / 86400;
    return $days;
}

function hoursIntoMinutes($hour) {
    return $hour/60;
}

function localSiderealTime() {
    $lst = 100.46 + (0.985647 * daysSince2000()) + getLongitude() + (15 * getTimeInHours());
    
    while($lst > 360) {
        $lst = $lst - 360;
    }

    while($lst < 360) {
        $lst = $lst + 360;
    }

    return $lst;
}

function getLongitude() {
    return 88.5452;
}

function getLatitude() {
    return 47.1150;
}

function hourAngleWhenGivenRa($givenRa) {
    $HA = localSiderealTime() - $givenRa;
    if($HA < 0) {
        $HA = $HA + 360;
    } 
    return $HA;
}

function hourAngleWhenGivenName($starName) {
    $HA = localSiderealTime() - raWithName($starName);
    if($HA < 0) {
        $HA = $HA + 360;
    } 
    return $HA;
}

function altitudeWhenGivenName($starName) {
    $sinDec = sin(decWithName($starName));
    $sinLat = sin(getLatitude());
    $cosDec = cos(decWithName($starName));
    $cosLat = cos(getLatitude());
    $cosHa = cos(hourAngleWhenGivenName($starName));
    $sinAlt = (($sinDec * $sinLat) + ($cosDec * $cosLat * $cosHa));
    return asin($sinAlt);
}

function azimuthWhenGivenName($starName) {
    $sinHa = sin(hourAngleWhenGivenName($starName));
    $alt = altitudeWhenGivenName($starName);
    if($sinHa < 0) {
        return $alt;
    }

    $sinDec = sin(decWithName($starName));
    $sinAlt = sin($alt);
    $sinLat = sin(getLatitude());
    $cosAlt = cos($alt);
    $cosLat = cos(getLatitude());
    $cosAzi = (($sinDec - ($sinAlt * $sinLat)) / ($cosAlt * $cosLat));
    $Azi = acos($cosAzi);
    return $Azi;
}

function altitudeWhenGivenCoords($givenRa, $givenDec) {

}

function azimuthWhenGivenCoords($givenRa, $givenDec) {

}

function raWithName($starName) {
    $dbh = connectDB();
    $statement = $dbh->prepare("SELECT r_ang FROM t_stars "
    ."where name = :name");
    $statement->bindParam(":name", $starName);
    $result = $statement->execute();
    $row=$statement->fetch();
    $dbh=null;
    return $row[0];
}

function decWithName($starName) {
    $dbh = connectDB();
    $statement = $dbh->prepare("SELECT dec_ang FROM t_stars "
    ."where name = :name");
    $statement->bindParam(":name", $starName);
    $result = $statement->execute();
    $row=$statement->fetch();
    $dbh=null;
    return $row[0];
}

function raWhenGivenRa($ra) {
    return $ra;
}

function decWhenGivenDec($dec) {
    return $dec;
}

function getTimeInHours() {
    $hour = gmdate("H");
    $minute = gmdate("i") / 60;
    $second = gmdate("s") / 3600;
    $allTime = $hour + $minute + $second;
    return $allTime;
}

?>
</html> 
