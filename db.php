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
    $config = parse_ini_file("StarfinderTest.ini");
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

//checks if user has favorited a star, returns a boolean
function hasBeenFavorited($user, $starName) {

    $dbh = connectDB();

    $statement = $dbh->prepare("SELECT count(*) FROM t_favorites WHERE f_username = :username and f_star = :star");
    $statement->bindParam(":username", $user);
    $statement->bindParam(":star", $starName);
    $result = $statement->execute();
    $row=$statement->fetch();

    $dbh = null;

    return $row[0];
}

function addFavorite($user, $starName) {

    $dbh = connectDB();

    $booleap = hasBeenFavorited($user, $starName);

    if($booleap == 0) {
        $statement = $dbh->prepare("INSERT into t_favorites VALUES (:username , :star)");
        $statement->bindParam(":username", $user);
        $statement->bindParam(":star", $starName);
        $result = $statement->execute();
 
    }
    //this is a test statement - user should not be able to double favorite a star once more code is fully implemented 
    else echo "this star has been favorited already";

    $dbh = null;


}

function removeFavorite ($user, $starName) {

    $dbh = connectDB();

    $booleap = hasBeenFavorited($user, $starName);

    if($booleap != 0) {
        $statement = $dbh->prepare("DELETE from t_favorites where f_username = :username and f_star = :star");
        $statement->bindParam(":username", $user);
        $statement->bindParam(":star", $starName);
        $result = $statement->execute();
 
    }
    //this is a test statement - user should not be able to double unfavorite a star once code is fully implemented 
    else echo "this star hasn't been favorited yet";

    $dbh = null;

}

function viewFavorites ($user) {
    $dbh = connectDB();

    $statement = $dbh->prepare("SELECT distinct name, r_ang, dec_ang, const, description FROM (t_stars join t_favorites on name = f_star) WHERE f_username = :username ORDER BY name");
    $statement->bindParam(":username", $user);
    $result = $statement->execute();
    $stars = $statement->fetchAll();

    return $stars; 

}

//creates a new account given a username and password, throws an error if the username is taken 
function createUser($user, $passwd) {
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare("INSERT into t_users VALUES ( :username, sha2(:passwd, 256), 0, 0 )");
        $statement->bindParam(":username", $user);
        $statement->bindParam(":passwd", $passwd);
        $statement->execute();
        $dbh = null;

        return $user;
    }
    catch (Exception $e) {
        $username = str_replace("<", "&lt", $user);
        $username = str_replace(">", "&gt", $username);
        echo '<p style="color:red">the username "'.$username.'" is already taken, please try another one</p>';
        $dbh = null;
        
    }
}

function checkUsername($user)
{
    $dbh = connectDB();
    $statement = $dbh->prepare("SELECT EXISTS(SELECT * from t_users WHERE username= :user)");
    $statement->bindParam(":user", $user);
    $result = $statement->execute();
    $check=$statement->fetch();
    return $check;
}

function addCount($user)
{
    $dbh = connectDB();
        $statement = $dbh->prepare("UPDATE t_users SET counter = counter + 1 WHERE username = :user");
        $statement->bindParam(":user", $user);
        $statement->execute();
        $statement2 = $dbh->prepare("SELECT counter FROM t_users WHERE username = :user");
        $statement2->bindParam(":user", $user);
        $count = $statement2->execute();
        $row=$statement2->fetch();
        $dbh = null;
        return $row;
}

function checkCount($user)
{
    $dbh = connectDB();
        $count = $dbh->prepare("SELECT counter FROM t_users WHERE username = :user");
        $count->bindParam(":user", $user);
        $result = $count->execute();
        $row=$count->fetch();
        $dbh = null;
        return $row;
        
}


function countZero($user)
{
    $dbh = connectDB();
        $statement = $dbh->prepare("UPDATE t_users SET counter = 0 WHERE username = :user");
        $statement->bindParam(":user", $user);
        $statement->execute();
        $dbh = null;
}



//updates the password of a user
function updatePassword($user, $passwd) {
    
        $dbh = connectDB();
        $statement = $dbh->prepare("UPDATE t_users SET passwd = sha2(:passwd, 256) WHERE username = :user");
        $statement->bindParam(":user", $user);
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


    return $row;


}

function queryStarByRAandDEC ($RA, $DEC) {
    $dbh = connectDB();
    $statement = $dbh->prepare("SELECT * FROM t_stars WHERE r_ang = :ra AND dec_ang = :dec");
    $statement->bindParam(":ra", $RA);
    $statement->bindParam(":dec", $DEC);
    $result = $statement->execute();
    $row=$statement->fetch();
    $dbh=null;

    return $row;


}


//prints the navbar on every page 
function printTopBanner() {
    echo 
    '<div> 
        <table class="navbar-table" width="100%">
            <col style = "width: 15%">
            <col style = "width: 55%">
            <col style="width: 10%">
            <col style="width: 5%">
            <col style="width: 5%">
            <col style="width: 10%">
            <tr> 
                <th id="Icon"><h1><a href= \'Index.php\' style="margin-left: 15px;" id="ahrefI" class="a-style">Star Finder</a>    </h1></th>
                <th style="text-align: left;"> <a href = "About.php" ><img src="hukees.png" height="50"> </a></th>
                <th class="switch"><form><input type="checkbox" name="sldr" id="slider" onchange="darkmode()"></form></th>
                <th id="navbar-admin" style="text-align: left"><h3><a href= \'admin.php\' class="a-style">Admin</a></h3></th>
                ';


    if(isset($_SESSION["user"])){
        $username = str_replace("<", "&lt", $_SESSION["user"]);
        $username = str_replace(">", "&gt", $username);
         echo '<th class="navbar-right-align"><h3><a href= \'favorites.php\' id="ahrefF" class="a-style">' .$username.'\'s Favorites</a></h3></th>';
    }
    else echo '<th class="navbar-right-align"><h3><a href=\'login.php\' id="ahrefF" class="a-style">Favorites</a></h3></th>';
        
             
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


//The hour angle is required for calculating the position of a star in the night sky
//When given the date and the Ra of a star, the hour angle can be found
//This function takes advantage of the Local sidereal time function
function hourAngleWhenGivenRa($givenRa, $date) {
    $HA = lstWhenGivenDate($date) - $givenRa;
    if($HA < 0) {
        $HA = $HA + 360;
    } 
    return $HA;
}



//The altitude is the height in the sky that the star is
//The altitude is given in radians and have to be converted to degrees 
//This specific functions takes in the star name in order to get the requisite information
function altitudeWhenGivenName($starName, $date) {
    //the altitude equation is sin(Declination)*sin(lattitude) + cos(Declination) * cos(latitude) * cos(Hour angle)
    //All the angles have to be in radians
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
//The azimuth is given in radians and have to be converted to degrees
//This specific functions takes in the star name in order to get the requisite information
function azimuthWhenGivenName($starName, $date) {
    //The azimuth equation is (sin(declination) - sin(altitude) * sin(latitude)) / (cos(altitude) * cos(latittude))
    //All angles have to be in radians
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
//The altitude is given in radians and needs to be converted into degrees
//This specific function takes in the RA and DEC to get the proper information
function altitudeWhenGivenCoords($givenRa, $givenDec, $date) {
    //the altitude equation is sin(Declination)*sin(lattitude) + cos(Declination) * cos(latitude) * cos(Hour angle)
    //All the angles have to be in radians
    $givenHa = (hourAngleWhenGivenRa($givenRa, $date) * ((pi())/180));
    $givenRa = $givenRa * ((pi())/180);
    $givenDec = $givenDec * ((pi())/180);
    $latitude = getLatitude() * ((pi())/180);
    $alt = (sin($givenDec) * sin($latitude)) + (cos($givenDec) * cos($latitude) * cos($givenHa));
    $alt = asin($alt);
    
    return $alt;
}

//The azimuth is the horizontal line that the star is in the night sky
//The azimumth is given in radians and needs to be converted into degrees
//This specific function takes in the RA and DEC to get the proper information
function azimuthWhenGivenCoords($givenRa, $givenDec, $date) {
    //The azimuth equation is (sin(declination) - sin(altitude) * sin(latitude)) / (cos(altitude) * cos(latittude))
    //All angles have to be in radians
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
//This function takes in a star name and if it is in the system, then it gives the RA of the star
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
//This function takes in a star name and if it is in the system, then it gives the DEC of the star
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

//This function returns the local sidereal time when not given a date
//When used, it takes the date to be the current moment and calculates the data based sidereal time based off of that
function lstWhenNotGivenDate() {
    date_default_timezone_set('UTC');
    //number of days since J2000
    $d = strtotime('now') - strtotime('1-1-2000 12:00:00');
    $long = -88.5254;
    //Universal Time of the day
    $UT = (date('H')) + (date('i')/60) + (date('s')/3600);
    //0.98567 is the length of a sidereal day
    //86400 is the amount of seconds in a day
    //sidereal days + universal time + 100.46 + longitude = local sidereal time
    $lst = (0.985647 * ($d/86400)) + (15 * $UT) + 100.46 + $long; 
    while($lst > 360) {
        $lst = $lst - 360;
    }
    while($lst < 0) {
        $lst = $lst + 360;
    }
    return $lst;
}

//This function returns the local sidereal time when given a date
//When used, it takes the date in the format dd-mm-yyyy hh:ii:ss
function lstWhenGivenDate($date) {
    date_default_timezone_set('UTC');
    $date = strtotime($date);
    //number of days since J2000
    $d = $date - strtotime('1-1-2000 12:00:00');
    $long = -88.5254;
    //Universal Time of the day
    $UT = (date('H', $date)) + (date('i', $date)/60) + (date('s', $date)/3600);
     //0.98567 is the length of a sidereal day
    //86400 is the amount of seconds in a day
    //sidereal days + universal time + 100.46 + longitude = local sidereal time
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

// Gets the stars from the 
function getStars(){
    $dbh = connectDB();
    $statement = $dbh->prepare("SELECT name FROM t_stars");
    $result = $statement->execute();
    $names = $statement->fetchAll();
    $dbh = NULL;

    $stars = array();
    $i = 0;
    foreach($names as $name) {
        $stars[$i] = $name[0];
        $i++;
    }
    sort($stars);
    return ($stars);
}

function isVisible($alt) {
    if($alt < 0) {
        return false;
    }
    return true;
}

function isAdmin($user){
    $dbh = connectDB();
    $statement = $dbh->prepare("SELECT admin FROM t_users WHERE username= :user");
    $statement->bindParam(":user", $user);
    $result = $statement->execute();
    $role = $statement->fetch();
    return $role;
}

?>
</html> 
