<?php

include_once "../connect.php";

$taskId = $_POST["taskId"];

if(isset($taskId)){
    $stmt = $conn->prepare(
        "SELECT * FROM tasks WHERE taskId = ?"
    );
    $stmt->bind_param("i", $taskId);
    $stmt->execute();
    $result = $stmt->get_result();

    if($row = $result->fetch_assoc()){
        $taskTitle = $row["taskname"];
        $taskDesc = $row["description"];
    }

    $stmt->close();
}else{
    header("Location: ../../index.html");
}
$conn->close();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasker</title>

    <link rel = "stylesheet" href = "../../css/style.css">
    <script type = "text/javascript" src = "../../js/script.js"></script>
</head>
<body>
    <div class = "change-container">
        <form class = "change-task-form" action = "update_task.php" method = "post">
            <p class = "title-text">Editar Tarefa</p>
            <p class = "subtitle-text">Modifique os valores abaixo para alterar sua tarefa</p>

            <label>Nome</label>
            <input type = "text" name = "taskName" value = "<?php echo $taskTitle ?>" required>
            <label>Descrição</label>
            <textarea name = "taskDesc" maxlength = "500" required><?php echo $taskDesc ?></textarea>

            <input type = "hidden" name = "taskId" value = "<?php echo $taskId ?>">

            <div class = "change-btn-container">
                <button type = "button" class = "btn btn-warning" onclick = "cancelChange();">Cancelar</button>
                <input type = "submit" class = "btn btn-primary" value = "Salvar">
            </div>
        </form>
    </div>

    <script>
        function cancelChange(){
            window.location.href = "../userpage.php";
        }
    </script>
</body>
</html>