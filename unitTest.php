
<!DOCTYPE html>
<html lang="eng">
    <body>
        <?php
             require "db.php";
             //testing days since 2000 function
         
             //days since january 1st 2000 as compared to 1/1/2000
             function testjan12000() {
                $expectedValue = '0';
                 $testDate = strtotime('01-02-2000');
                 $realValue = daysSince2000($testDate);
                 return assert($expectedValue == $realValue);
             }
        ?>
        <?php
            echo testjan12000();
            
        ?>
    </body>
</html>