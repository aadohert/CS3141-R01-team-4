<html>
<?php
function connectDB() {
    $config = parse_ini_file("db.ini");
    $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

function findStar() {

}

function daysSince2000() {

}

function hoursIntoMinutes() {

}

function localSiderealTime() {

}

function getLongitude() {

}


?>
</html> 
