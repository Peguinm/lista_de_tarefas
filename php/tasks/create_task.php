<?php

session_start();
include_once "../connect.php";

$userId = $_SESSION["userId"];

echo $userId;

?>