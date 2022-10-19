
<!DOCTYPE html>
<html lang="eng">
    <body>
        <?php
             require "db.php"
        ?>
        <?php
            echo "<br>". "Test 1: ". lstWhenNotGivenDate();
            echo "<br>". "Test 2: ". hourAngleWhenGivenRa(88.79);
            echo "<br>". "Test 3: ". (altitudeWhenGivenCoords(88.79, 7.40855)* (180/(pi())));
            echo "<br>". "Test 4: ". (azimuthWhenGivenCoords(88.79, 7.40855)* (180/(pi())));
        ?>
    </body>
</html>