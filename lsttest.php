<?php    

    $moment = new moment;
    $moment->moment(gmdate("Y m d H i s"));
    $julianDay = unixtojd();
    $julianDay = $julianDay + ((gmdate('H') / 24) + (gmdate('i') / 1440) + gmdate('s') / 86400);
    $T = (($julianDay - 2451545.0)/36525);
    $era = fmod(pi()*2 * (0.7790572732640 + 0.00273781191135448 * 
    ($julianDay - 2451545.0) + (fmod($julianDay, 1))),  (pi() * 2));
    if($era < 0) {
        $era+=pi()*2;
    }
    $thetacool = 280.46061837 + 360.98564736629 * ($julianDay - 2451545.0) +
    (0.000387933 * $T * $T) - ($T * $T * $T / 38710000.);
    $theta0 = fmod(($era + (0.014506 + 4612.15739966 * $T + 1.39667721 * $T * $T +
    -0.00009344*$T*$T*$T + 0.00001882*$T*$T*$T*$T)/60/60*pi()/180), (pi() * 2));
    while($thetacool < 0) {
        $thetacool+= 360;
    }
    while($thetacool > 360) {
        $thetacool -= 360;
    }
    $theta0 = $theta0 + -88.5452;
    if($theta0 > 360) {
        $thetacool = $thetacool - 360;
    }
    if($theta0 < 360) {
        $theta0 = $theta0 + 360;
    }
    echo($theta0);

    class moment {
        public $year;
        public $month;
        public $day;
        public $hour;
        public $minute;
        public $second;
        public $millisecond;
    
    
        //Takes a time $date that is formatted like "Y m d H i s"
        function moment($date) {
            $this->year = gmdate('Y', strtotime('$date'));
            $this->month = gmdate('m', strtotime('$date'));
            $this->day = gmdate('d', strtotime('$date'));
            $this->hour = gmdate('H', strtotime('$date'));
            $this->minute = gmdate('i', strtotime('$date'));
            $this->second = gmdate('s', strtotime('$date'));
        }
    
        function JulianDay() {
            $Y = $this->year;
            $M = $this->month;
            $gregorianOffset = 0;
            if($M == '1' || '01' || 1 || 01 || '2' || '02' || 2 || 02) {
                $Y--;
                $M = $M + 12;
            }
    
            if($Y > 1583) {
                $gregorianYear = floor($Y / 100);
                $gregorianOffset = 2 - $gregorianYear + floor($gregorianYear/4);
            }
    
            return floor(365.25 * ($Y + 4716) + floor(30.6001 * ($M + 1)) + 
            (($this->day + ($this->hour/24) + ($this->minute/1440) + ($this->second/1000))/86400)
            + $gregorianOffset - 1524.5);
        }
    }



   //$gmtDate = gmdate("Y m d H i s");
   //echo($gmtDate). "<br>";

?>