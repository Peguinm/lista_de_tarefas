<?php

session_start();
include_once "../connect.php";

$taskName = $_POST["taskName"];
$taskDesc = $_POST["taskDesc"];
$taskId = $_POST["taskId"];
$taskPriority = $_POST["taskPriority"];

if(isset($taskName) && isset($taskDesc) && isset($taskId)){
    $stmt = $conn->prepare(
        "UPDATE tasks 
        SET taskname = ?, description = ? , priority = ?
        WHERE taskId = ?"
    );
    $stmt->bind_param("ssii", $taskName, $taskDesc, $taskPriority, $taskId);
    $stmt->execute();

    $msg = "task_edited";
    header("Location: ../userpage.php?success={$msg}");

    $stmt->close();
}else{
    header("Location: ../../index.html");
}

$conn->close();

?>