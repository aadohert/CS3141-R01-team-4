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
            echo getStars()[0];
        ?>
    </body>
</html>