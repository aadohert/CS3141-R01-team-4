<?php 
        require "db.php";

        session_start();

        session_destroy();

        header("LOCATION:Index.php")

?>