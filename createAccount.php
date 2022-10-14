<?php
    session_start();
    require "db.php";
?>
    
<!-- css here -->

<?php
    printTopBanner();
    if(isset($_POST["create"])) {
        if($_POST["password1"] == $_POST["password2"]) {
            $_SESSION["user"] = createUser($_POST["username"], $_POST["password1"]);
            if(isset($_SESSION["user"])) header('LOCATION:Index.php');
        }
        else echo '<p style="color:red">passwords do not match</p>';
    }
?>

<form method="post" action="createAccount.php">

<label for="username"><strong>username:<br> </strong></label> 
<input type="text" id="username" name="username"> 
<br> <br>

<label for="password"><strong>password:<br> </strong></label> 
<input type="password" id="password1" name="password1">
<br> <br>

<label for="password2"><strong>confirm password:<br> </strong></label> 
<input type="password" id="password2" name="password2">
<br> <br>

<input type="submit" name="create" value="create">


</form>

