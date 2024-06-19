<?php

include_once "connect.php";

$userId = $_POST["userId"];

if(isset($userId)){
    $stmtUser = $conn->prepare(
        "DELETE FROM users WHERE userId = ?"
    );
    $stmtUser->bind_param("i", $userId);
    $stmtUser->execute();

    $stmtTask = $conn->prepare(
        "DELETE FROM tasks WHERE userKey = ?"
    );
    $stmtTask->bind_param("i", $userId);
    $stmtTask->execute();
}

header("Location: ../index.html");

?>