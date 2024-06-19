<?php

session_start();
include_once "../connect.php";

$userId = $_SESSION["userId"];
$name = $_POST["taskName"];
$desc = $_POST["taskDesc"];
$priority = $_POST["taskPriority"];

date_default_timezone_set("America/Sao_Paulo");
$date = date("Y-m-d");

if(isset($name) && isset($desc) && isset($userId)){
    $stmt = $conn->prepare(
        "INSERT INTO tasks (taskname, description, date, userKey, priority) 
        VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("sssii", $name, $desc, $date, $userId, $priority);
    $stmt->execute();

    $stmt->close();

    $msg = "task_created";
    header("Location: ../userpage.php?success={$msg}");
}else{
    $error = "creation_error";
    header("Location: ../userpage.php?error={$error}");
}

$conn->close();

?>