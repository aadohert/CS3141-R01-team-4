<?php
    session_start();
    require "db.php";

    printTopBanner();


    if(isset($_POST["create"])) {
        if($_POST["password1"] == $_POST["password2"]) {
            $_SESSION["user"] = createUser($_POST["username"], $_POST["password1"]);
            if(isset($_SESSION["user"])) header('LOCATION:Index.php');
        }
        else echo '<p style="color:red">passwords do not match</p>';
    }

    echo "<p>". $_POST['uwu'] ."</p>";
?>


<form method="post" action="test2.php" class="inline">
  <input type="hidden" name="uwu" value="uwu">
  <button type="submit" name="uwu" value="uwu" class="link-button">
    This is a link that sends a POST request
  </button>
</form>


</form>