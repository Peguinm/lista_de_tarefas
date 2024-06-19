<?php

session_start();
include_once "../connect.php";

$taskName = $_POST["taskName"];
$taskDesc = $_POST["taskDesc"];
$taskId = $_POST["taskId"];

if(isset($taskName) && isset($taskDesc) && isset($taskId)){
    $stmt = $conn->prepare(
        "UPDATE tasks SET taskname = ?, description = ? WHERE taskId = ?"
    );
    $stmt->bind_param("ssi", $taskName, $taskDesc, $taskId);
    $stmt->execute();

    $msg = "task_edited";
    header("Location: ../userpage.php?success={$msg}");

    $stmt->close();
}else{
    header("Location: ../../index.html");
}

$conn->close();

?>