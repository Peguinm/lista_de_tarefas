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

    <div class = "userpage-container">
        <div class = "filter-container">
            <button id = "filter_btn" class = "btn btn-secondary">Mostrar Filtros</button>

            <form id = "filter_form" class = "filter-form hidden">
                <label>Nome</label>
                <input type = "text" name = "taskName">

                <label>Descrição</label>
                <textarea name = "taskDesc"></textarea>

                <label>Data início: </label>
                <input type = "date" name = "taskDateBegin">

                <label>Data fim: </label>
                <input type = "date" name = "taskDateEnd">
                <input class = "btn btn-secondary" type = "submit" value = "Filtrar">
            </form>
        </div>

        <div class = "tasks-container">
            <a href = "tasks/create_task.php" class = "create-task-link">
                <button class = "btn btn-primary">Criar</button>
            </a>
        
            <div class = "tasks-box">
                <div class = "task">
                    <div class = "task-header">
                        <p class = "title-text">Lavar meu carro irado</p>
                        <p class = "subtitle-text">31/12/2005</p>
                    </div>
                    <p class = "normal-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto, ipsam fugiat in, vel officia ab, molestiae architecto pariatur sapiente debitis at! Iure quaerat velit eius libero ipsum praesentium quo nihil.</p>
                    <div class = "btns-container">
                        <form class = "edit-form">
                            <input class = "btn btn-secondary" type = "submit" value = "Editar">
                        </form>

                        <form class = "delete-form">
                            <input class = "btn btn-warning" type = "submit" value = "Excluir">
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>