<?php

include_once "../connect.php";

$userId = $_POST["taskId"];

if(isset($userId)){
    $stmt = $conn->prepare(
        "DELETE FROM tasks 
        WHERE taskId = ?"
    );
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    $msg = "task_deleted";
    header("Location: ../userpage.php?success={$msg}");

    $stmt->close();
}else{
    header("Location: ../../index.html");
}

$conn->close();

?>