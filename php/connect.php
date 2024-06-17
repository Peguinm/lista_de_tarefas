<?php

    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "tasklist";

    $conn = mysqli_connect($host, $user, $password, $database);

    //connection status 
    if($conn->connect_error){
        die("Connection Error: " . $conn->connect_error);
    }

?>


