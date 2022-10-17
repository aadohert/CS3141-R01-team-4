
<!DOCTYPE html>
<html lang="eng">
    <body>
        <?php
             require "db.php";
             //testing days since 2000 function
         
             //days since january 1st 2000 as compared to 1/1/2000
             function testjan12000() {
                $expectedValue = '0';
                 $testDate = strtotime('01-01-2000');
                 $realValue = daysSince2000($testDate);
                 return assert($expectedValue == $realValue);
             }

             //days compared to jan 1st 1998
             function testjan11998False() {
                $expectedValue = '0';
                 $testDate = strtotime('01-01-1998');
                 $realValue = daysSince2000($testDate);
                 return assert($expectedValue != $realValue);
             }

             function testjan11998True() {
                $expectedValue = '-730';
                 $testDate = strtotime('01-01-1998');
                 $realValue = daysSince2000($testDate);
                 return assert($expectedValue == $realValue);
             }
        ?>
        <?php
            echo "Test 1:". testjan12000();
            echo "<br>". "Test 2:". testjan11998False();
            echo "<br>". "Test 3:". testjan11998True();
        ?>
    </body>
</html>