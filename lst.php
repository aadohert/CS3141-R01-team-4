<html>
<?php
date_default_timezone_set('UTC');
//Function should be handed a date string in the format "dd mm YYYY HH:MM:SS"
function UT($date) {
    date_default_timezone_set('UTC');
    $UT = strtotime($date);
    return $UT;
}

function JD($date) {
    $UT = UT($date);
    $Y = date('Y', $UT);
    $m = date('m', $UT);
    $d = date('d', $UT);
    $f = $Y;
    if($m > 2) {
        $f--;
    }
    $g = $m;
    if($m > 2) {
        $g = $g + 12;
    }
    $A = 2 - ($f/100) + ($f/400);

    $JD = ((365.25 * $f) + (30.6001 * ($g + 1)) + $d + $A + 1720994.5);
    return $JD;
}

function GMST($date) {
    $JD = JD($date);
    $d = $JD - 2451545.0;
    $T = $d / 36525;
    $GMST = 24110.54841 + (8640184.812866 * $T) + (0.093104 * ($T * $T))
     - (0.0000062 * ($T * $T * $T));
    return $GMST;
}

function LMST($date) {
    $GMST = GMST($date);
    $LMST = $GMST - 88.5694;
    return $LMST;
}

?>