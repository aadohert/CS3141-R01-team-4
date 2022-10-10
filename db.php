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
    $firstDate = '01-01-2000';
    $today = date('d-m-y', strtotime("now"));
    $days = strtotime($today) - strtotime($firstDate);
    return abs(round($days));
}

function hoursIntoMinutes($hour) {
    return $hour/60;
}

function localSiderealTime() {

}

function getLongitude() {
    return 88.5452;
}

function getLatitude() {
    return 47.1150;
}

function getUniversalTime() {
    return gmdate("M d Y H:i:s");
}

function hourAngle() {

}

function altitude() {

}

function azimuth() {

}

?>
</html> 
