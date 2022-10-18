
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

             function testjan2200True() {
                $expectedValue = '1';
                 $testDate = strtotime('02-01-2000');
                 $realValue = daysSince2000($testDate);
                 return assert($expectedValue == $realValue);
             }

             function testjan22000False() {
                $expectedValue = '-730';
                 $testDate = strtotime('02-01-2000');
                 $realValue = daysSince2000($testDate);
                 return assert($expectedValue != $realValue);
             }

             function testoctober282001True() {
                $expectedValue = '666';
                 $testDate = strtotime('28-10-2001');
                 $realValue = daysSince2000($testDate);
                 return assert($expectedValue == $realValue);
             }

             function testoct282001False() {
                $expectedValue = '-730';
                $testDate = strtotime('28-10-2001');
                $realValue = daysSince2000($testDate);
                 return assert($expectedValue != $realValue);
             }

             function testapr42022True() {
                $expectedValue = '8129';
                 $testDate = strtotime('04-04-2022');
                 $realValue = daysSince2000($testDate);
                 return assert($expectedValue == $realValue);
             }

             function testapr42022False() {
                $expectedValue = '-730';
                 $testDate = strtotime('04-04-2022');
                 $realValue = daysSince2000($testDate);
                 return assert($expectedValue != $realValue);
             }

             function testLSTJan12000() {
               
             }
        ?>
        <?php
            $testDate = date("Y m d h i s");
            echo "Test 1:". testjan12000();
            echo "<br>". "Test 2:". testjan11998False();
            echo "<br>". "Test 3:". testjan11998True();
            echo "<br>". "Test 4:". testjan2200True();
            echo "<br>". "Test 5:". testjan22000False();
            echo "<br>". "Test 6:". testoctober282001True();
            echo "<br>". "Test 7:". testoct282001False();
            echo "<br>". "Test 8:". testapr42022True();
            echo "<br>". "Test 9:". testapr42022False();
            echo "<br>". "test 10: ". lstWhenGivenDate($testDate);
            echo "<br>". "test 10.5: ". lstWhenNotGivenDate();
            echo "<br>". "Test 11: ". hourAngleWhenGivenRa(88.79);
            echo "<br>". "Test 12: ". altitudeWhenGivenCoords(88.79, 111.11);
            echo "<br>". "Test 13: ". azimuthWhenGivenCoords(88.79, 111.11);
        ?>
    </body>
</html>