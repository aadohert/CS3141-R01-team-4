<!DOCTYPE html>
<html lang="eng">
    <body>
        <?php
            require "db.php";
            /**$hour = gmdate("H");
            $minute = gmdate("i") / 60;
            $second = gmdate("s") / 3600;
            $allTime = $hour + $minute + $second;
            echo $allTime;**/
            $stars = getStars();

            foreach($stars as $star) {
                echo $star . "<br>";
            }
        ?>
    </body>
</html>