
<!DOCTYPE html>
<html lang="eng">
    <body>
        <?php
             require "db.php"
        ?>
        <?php
            echo "<br>". "Test 1: ". lstWhenNotGivenDate();
            echo "<br>". "Test 1.5: ". lstWhenGivenDate('now');
            echo "<br>". "Test 2: ". hourAngleWhenGivenRa(88.79, 'now');
            echo "<br>". "Test 3: ". (altitudeWhenGivenCoords(88.79, 7.40855, 'now')* (180/(pi())));
            echo "<br>". "Test 4: ". (azimuthWhenGivenCoords(88.79, 7.40855, 'now')* (180/(pi())));
            //Alt and Azimuth of betelguese on 1-1-2021 at 8 am
            $date2021 = '1-1-2021 08:00:00'; 
            //Doesn't work unless I got to 3 am that day
            echo "<br>". "Test 5.5: ". lstWhenGivenDate($date2021) . "= 207.85";
            echo "<br>". "Test 5 Alt: ". altitudeWhenGivenCoords(88.79, 7.40855, $date2021) * (180/(pi())). " = -13 18' 43.4''";
            echo "<br>". "Test 6 Az: ". azimuthWhenGivenCoords(88.79, 7.40855, $date2021) * (180/(pi())). " =  296 42' 45.2''";
            //Alt and Azimuth of betelguese on 5-6-1998 at 6pm
            $date1998 = '5-6-1998 18:00:00';
            echo "<br>". "Test 7.5: ". lstWhenGivenDate($date1998);
            echo "<br>". "Test 7 Alt: ". altitudeWhenGivenCoords(88.79, 7.40855, $date1998) * (180/(pi())). " = 33 48' 10.1''";           
            echo "<br>". "Test 8 Az: ". azimuthWhenGivenCoords(88.79, 7.40855, $date1998) * (180/(pi())). " = 240 27' 36.8''";
             //Alt and Azimuth of betelguese on 19-8-2032 at noon
             $date2032 = '19-8-2032 12:00:00';
             echo "<br>". "Test 9.5: ". lstWhenGivenDate($date2032). "";
             echo "<br>". "Test 9 Alt: ". altitudeWhenGivenCoords(88.79, 7.40855, $date2032) * (180/(pi())). " = 42 24' 34.4''";             
             echo "<br>". "Test 10 Az: ". azimuthWhenGivenCoords(88.79, 7.40855, $date2032) * (180/(pi())). " = 223 23' 40.5''";    
             


             echo "<br>" . (strtotime($date2021) - strtotime('1-1-2000 12:00:00'))/86400;

             
             ?>
    </body>
</html>