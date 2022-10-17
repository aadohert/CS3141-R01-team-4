<?php 

     /**
     * page to log a user out - sends user back to index on being logged out
     *
     * @author  TSP team 4 
     * Julianna Cummings, River Dallas, Avery Doherty, Nicky Franklin, Brendan Fuhrman
     */

        require "db.php";

        session_start();

        session_destroy();

        header("LOCATION:Index.php")

?>