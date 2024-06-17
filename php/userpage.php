<?php
    session_start();
    include_once "connect.php";

    $userId = $_SESSION["userId"];

    //redirecinando para o index, caso o login não tenha sido feito
    if(!isset($userId)){
        header("Location: ../index.html");
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasker</title>

    <link rel = "stylesheet" href = "../css/style.css">
    <script type = "text/javascript" src = "../js/script.js"></script>
</head>
<body>
    <div class = "tasks-container">
        
    </div>

    <script> 
        alert("<?php echo $userId ?>");
    </script>
</body>
</html>