<html>
<?php
/**
 * File containing all functions 
 *
 * @author  TSP team 4 
 * Julianna Cummings, River Dallas, Avery Doherty, Nicky Franklin, Brendan Fuhrman
*/

     
//used to connect to the database, needed to run any mysql queries 
function connectDB() {
    $config = parse_ini_file("Starfinder.ini");
    $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

//authenticates a user log in, returns an arrary of int (1 if login is currect, 0 if it is not) and username
function authenticate($user, $passwd) {
    $dbh = connectDB();
    $statement = $dbh->prepare("SELECT count(*), username FROM t_users "
    ."where username = :username and passwd = sha2(:passwd,256) ");
    $statement->bindParam(":username", $user);
    $statement->bindParam(":passwd", $passwd);
    $result = $statement->execute();
    $row=$statement->fetch();
    $dbh=null;
    return $row;

}

//creates a new account given a username and password, throws an error if the username is taken 
function createUser($user, $passwd) {
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare("INSERT into t_users VALUES ( :username, sha2(:passwd, 256) )");
        $statement->bindParam(":username", $user);
        $statement->bindParam(":passwd", $passwd);
        $statement->execute();
        $dbh = null;

        return $user;
    }
    catch (Exception $e) {
        echo '<p style="color:red">the username "'.$user.'" is already taken, please try another one</p>';
        $dbh = null;
        
    }
}

//updates the password of a user
function updatePassword($user, $passwd) {
    
        $dbh = connectDB();
        $statement = $dbh->prepare("UPDATE t_users SET passwd = :passwd, WHERE username = :username");
        $statement->bindParam(":username", $user);
        $statement->bindParam(":passwd", $passwd);
        $statement->execute();
        $dbh = null;


        return $user;
    

}

//returns data about the named star, or 0 if it's not in the database
function queryStarByName($name) {
    $dbh = connectDB();
    $statement = $dbh->prepare("SELECT * FROM t_stars "
    ."where name = :name");
    $statement->bindParam(":name", $name);
    $result = $statement->execute();
    $row=$statement->fetch();
    $dbh=null;

    if(is_null($row)) {
        return 0;
    }
    else {
        return $row;
    }


}

function queryStarByRAandDEC ($RA, $DEC) {
    $dbh = connectDB();
    $statement = $dbh->prepare("SELECT * FROM t_stars WHERE r_ang = :ra AND dec_ang = :dec");
    $statement->bindParam(":ra", $RA);
    $statement->bindParam(":dec", $DEC);
    $result = $statement->execute();
    $row=$statement->fetch();
    $dbh=null;

    if(is_null($row)) {
        return 0;
    }
    else {
        return $row;
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

    if(isset($_SESSION["user"])) echo '<th class="navbar-right-align"><h3><a href="/favorites.php" id="ahrefF" class="a-style">'.$_SESSION["user"].'\'s Favorites</a></h3></th>';
    else echo '<th class="navbar-right-align"><h3><a href="/Login.php" id="ahrefF" class="a-style">Favorites</a></h3></th>';
        
             
    if(isset($_SESSION["user"])) echo '<th class="navbar-right-align"><button onclick="location.href = \'logout.php\';" style="background-image: url(\'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQjrCdY7vbLNb3uuqCixRviazh7zdc0yUSB3Ou2w27iCQRKN6T1ylCGuCs1YXkTOQBTjzM&usqp=CAU\'); color:white; cursor:pointer; width:75px;height:35px;">Log Out</button></th>';
    else echo '<th class="navbar-right-align" style="vertical-align: top;"><button onclick="location.href = \'login.php\';" style="background-image: url(\'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQjrCdY7vbLNb3uuqCixRviazh7zdc0yUSB3Ou2w27iCQRKN6T1ylCGuCs1YXkTOQBTjzM&usqp=CAU\'); color:white; cursor:pointer; width:75px;height:35px;">Login</button></th>';
        
    echo 
            '</tr>
        </table>
    </div>';

}

//This gets the longitude of your location
//For now this is just houghton's longitude
function getLongitude() {
    return -88.5694;
}

//This gets the latitude of your location
//For now this is just houghton's latitude
function getLatitude() {
    return 47.1211;
}

//Since php does not allow function overloading, I have two versions of the hour angle formula
//The hour angle is required for calculating the position of a star in the night sky
function hourAngleWhenGivenRa($givenRa, $date) {
    $HA = lstWhenGivenDate($date) - $givenRa;
    if($HA < 0) {
        $HA = $HA + 360;
    } 
    return $HA;
}

//Since php does not allow function overloading, I have two versions of the hour angle formula
//The hour angle is required for calculating the position of a star in the night sky
function hourAngleWhenGivenName($starName, $date) {
    $HA = lstWhenGivenDate($date) - raWithName($starName);
    if($HA < 0) {
        $HA = $HA + 360;
    } 
    return $HA;
}

//The altitude is the height in the sky that the star is 
function altitudeWhenGivenName($starName, $date) {
    $ra = raWithName($starName);
    $dec = decWithName($starName);
    $givenHa = (hourAngleWhenGivenRa($ra, $date) * ((pi())/180));
    $ra = $ra * ((pi())/180);
    $dec = $dec * ((pi())/180);
    $latitude = getLatitude() * ((pi())/180);
    $alt = (sin($dec) * sin($latitude)) + (cos($dec) * cos($latitude) * cos($givenHa));
    $alt = asin($alt);
    
    return $alt;
}

//The azimuth is the horizontal line that the star is in the night sky
function azimuthWhenGivenName($starName, $date) {
    $givenRa = raWithName($starName);
    $givenDec = decWithName($starName);
    $givenHa = (hourAngleWhenGivenRa($givenRa, $date) * ((pi())/180));
    $givenRa = $givenRa * ((pi())/180);
    $givenDec = $givenDec * ((pi())/180);
    $latitude = getLatitude() * ((pi())/180);
    $alt = (sin($givenDec) * sin($latitude)) + (cos($givenDec) * cos($latitude) * cos($givenHa));
    $alt = asin($alt);
    $azi = (sin($givenDec) - (sin($alt) * sin($latitude))) / ((cos($alt) * cos($latitude)));
    
    if($givenHa > 0) {
        return (2*pi()) - acos($azi);
    }

    else {
        return acos($azi);
    }
}

//The altitude is the height in the sky that the star is 
function altitudeWhenGivenCoords($givenRa, $givenDec, $date) {
    $givenHa = (hourAngleWhenGivenRa($givenRa, $date) * ((pi())/180));
    $givenRa = $givenRa * ((pi())/180);
    $givenDec = $givenDec * ((pi())/180);
    $latitude = getLatitude() * ((pi())/180);
    $alt = (sin($givenDec) * sin($latitude)) + (cos($givenDec) * cos($latitude) * cos($givenHa));
    $alt = asin($alt);
    
    return $alt;
}

//The azimuth is the horizontal line that the star is in the night sky
function azimuthWhenGivenCoords($givenRa, $givenDec, $date) {
    $givenHa = (hourAngleWhenGivenRa($givenRa, $date) * ((pi())/180));
    $givenRa = $givenRa * ((pi())/180);
    $givenDec = $givenDec * ((pi())/180);
    $latitude = getLatitude() * ((pi())/180);
    $alt = (sin($givenDec) * sin($latitude)) + (cos($givenDec) * cos($latitude) * cos($givenHa));
    $alt = asin($alt);
    $azi = (sin($givenDec) - (sin($alt) * sin($latitude))) / ((cos($alt) * cos($latitude)));
    
    if($givenHa > 0) {
        return (2*pi()) - acos($azi);
    }

    else {
        return acos($azi);
    }
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

function lstWhenNotGivenDate() {
    date_default_timezone_set('UTC');
    $d = strtotime('now') - strtotime('1-1-2000 12:00:00');
    $long = -88.5254;
    $UT = (date('H')) + (date('i')/60) + (date('s')/3600);
    $lst = (0.985647 * ($d/86400)) + (15 * $UT) + 100.46 + $long; 
    while($lst > 360) {
        $lst = $lst - 360;
    }
    while($lst < 0) {
        $lst = $lst + 360;
    }
    return $lst;
}

function lstWhenGivenDate($date) {
    date_default_timezone_set('UTC');
    $date = strtotime($date);
    $d = $date - strtotime('1-1-2000 12:00:00');
    $long = -88.5254;
    $UT = (date('H', $date)) + (date('i', $date)/60) + (date('s', $date)/3600);
    $lst = (0.985647 * ($d/86400)) + (15 * $UT) + 100.46 + $long; 
    while($lst > 360) {
        $lst = $lst - 360;
    }
    while($lst < 0) {
        $lst = $lst + 360;
    }
    return $lst;
}

//converts a value in radians to degrees
function radiansToDegrees ($radians) {
    $degrees = $radians * (180/(pi()));
    return $degrees;
}


?>
</html> 
