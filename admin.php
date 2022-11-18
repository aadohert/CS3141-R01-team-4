<?php
    session_start();
    require "db.php";

    if(isAdmin($_SESSION["user"]) == false){
        header("LOCATION: Index.php");
    }
?>