<html>
<?php
//used to connect to the database, needed to run any mysql queries 
function connectDB() {
    $config = parse_ini_file("Starfinder.ini");
    $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

//authenticates a user log in, returns 1 if the username and password match, 0 otherwise
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

//creates a new account given a username and password, throws an error if the username is taken 
function createUser($user, $passwd) {
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare("INSERT into t_users VALUES ( :username, sha2(:passwd, 256) )");
        $statement->bindParam(":username", $user);
        $statement->bindParam(":passwd", $passwd);
        $statement->execute();

        return $user;
    }
    catch (Exception $e) {
        echo '<p style="color:red">that username is already taken, please try another one</p>';
    }
}

//prints the navbar on every page 
function printTopBanner() {
    echo 
    '<div> 
        <table class="navbar-table" width="100%">
            <col style = "width: 70%">
            <col style="width: 15%">
            <col style="width: 5%">
            <col style="width: 10%">
            <tr> 
                <th id="Icon"><h1><a href="/Index.php" style="margin-left: 15px;" id="ahrefI" class="a-style">Star Finder</a></h1></th>
                <th class="switch"><form><input type="checkbox" name="sldr" id="slider" onchange="darkmode()"></form></th>';

    if(isset($_SESSION["user"])) echo '<th class="navbar-right-align"><h3><a href="/Favorites.php" id="ahrefF" class="a-style">'.$_SESSION["user"].'\'s Favorites</a></h3></th>';
    else echo '<th class="navbar-right-align"><h3><a href="/Login.php" id="ahrefF" class="a-style">Favorites</a></h3></th>';
        
             
    if(isset($_SESSION["user"])) echo '<th class="navbar-right-align"><button onclick="location.href = \'logout.php\';" style="background-image: url(\'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQjrCdY7vbLNb3uuqCixRviazh7zdc0yUSB3Ou2w27iCQRKN6T1ylCGuCs1YXkTOQBTjzM&usqp=CAU\'); color:white; cursor:pointer; width:75px;height:35px;">Log Out</button></th>';
    else echo '<th class="navbar-right-align" style="vertical-align: top;"><button onclick="location.href = \'login.php\';" style="background-image: url(\'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQjrCdY7vbLNb3uuqCixRviazh7zdc0yUSB3Ou2w27iCQRKN6T1ylCGuCs1YXkTOQBTjzM&usqp=CAU\'); color:white; cursor:pointer; width:75px;height:35px;">Login</button></th>';
        
    echo 
            '</tr>
        </table>
    </div>';

}

//This function determines how many days it has been since January 1st 2000 in order to get the local sidereal day
//May need to be changed to calculate days differently to account for 1200 UT TBD though
function daysSince2000($date) {
    if (isset($date)) {
        $dayToCalculate = $date;
    }
    else {
        $dayToCalculate = strtotime("now");
    }
    
    $days = $dayToCalculate - strtotime('01-01-2000');
    $days = $days / 86400;
    return $days;
}

//This isn't used but might be in the future
function hoursIntoMinutes($hour) {
    return $hour/60;
}

//Finds the local sidereal time which is the true time it is in an area. (An actual day is 4 minutes slower than a sidereal day)
function localSiderealTime() {
    $lst = 100.46 + (0.985647 * daysSince2000(null)) + getLongitude() + (15 * getTimeInHours());
    
    while($lst > 360) {
        $lst = $lst - 360;
    }

    while($lst < 360) {
        $lst = $lst + 360;
    }

    return $lst;
}

//This gets the longitude of your location
//For now this is just houghton's longitude
function getLongitude() {
    return 88.5452;
}

//This gets the latitude of your location
//For now this is just houghton's latitude
function getLatitude() {
    return 47.1150;
}

//Since php does not allow function overloading, I have two versions of the hour angle formula
//The hour angle is required for calculating the position of a star in the night sky
function hourAngleWhenGivenRa($givenRa) {
    $HA = localSiderealTime() - $givenRa;
    if($HA < 0) {
        $HA = $HA + 360;
    } 
    return $HA;
}

//Since php does not allow function overloading, I have two versions of the hour angle formula
//The hour angle is required for calculating the position of a star in the night sky
function hourAngleWhenGivenName($starName) {
    $HA = localSiderealTime() - raWithName($starName);
    if($HA < 0) {
        $HA = $HA + 360;
    } 
    return $HA;
}

//The altitude is the height in the sky that the star is 
function altitudeWhenGivenName($starName) {
    $sinDec = sin(decWithName($starName));
    $sinLat = sin(getLatitude());
    $cosDec = cos(decWithName($starName));
    $cosLat = cos(getLatitude());
    $cosHa = cos(hourAngleWhenGivenName($starName));
    $sinAlt = (($sinDec * $sinLat) + ($cosDec * $cosLat * $cosHa));
    return asin($sinAlt);
}

//The azimuth is the horizontal line that the star is in the night sky
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

//The altitude is the height in the sky that the star is 
function altitudeWhenGivenCoords($givenRa, $givenDec) {
    $sinDec = sin($givenDec);
    $sinLat = sin(getLatitude());
    $cosDec = cos($givenDec);
    $cosLat = cos(getLatitude());
    $cosHa = cos(hourAngleWhenGivenRa($givenRa));
    $sinAlt = (($sinDec * $sinLat) + ($cosDec * $cosLat * $cosHa));
    return asin($sinAlt);
}

//The azimuth is the horizontal line that the star is in the night sky
function azimuthWhenGivenCoords($givenRa, $givenDec) {
    $sinHa = sin(hourAngleWhenGivenRa($givenRa));
    $alt = altitudeWhenGivenCoords($givenRa, $givenDec);
    if($sinHa < 0) {
        return $alt;
    }

    $sinDec = sin($givenDec);
    $sinAlt = sin($alt);
    $sinLat = sin(getLatitude());
    $cosAlt = cos($alt);
    $cosLat = cos(getLatitude());
    $cosAzi = (($sinDec - ($sinAlt * $sinLat)) / ($cosAlt * $cosLat));
    $Azi = acos($cosAzi);
    return $Azi;
}

//The ra is one of the star values needed to calculate its position
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

//The dec is one of the star values needed to calculate its position
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

//The ra is one of the star values needed to calculate its position
function raWhenGivenRa($ra) {
    return $ra;
}

//The dec is one of the star values needed to calculate its position
function decWhenGivenDec($dec) {
    return $dec;
}

//This is needed to calculate the most accurate local sidereal time
function getTimeInHours() {
    $hour = gmdate("H");
    $minute = gmdate("i") / 60;
    $second = gmdate("s") / 3600;
    $allTime = $hour + $minute + $second;
    return $allTime;
}

?>
</html> 
