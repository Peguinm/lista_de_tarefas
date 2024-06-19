<?php
    session_start();
    include_once "connect.php";

    $userId = $_SESSION["userId"];
    $username = $_SESSION["username"];

    //redirecinando para o index, caso o login não tenha sido feito
    if(!isset($userId)){
        header("Location: ../index.html");
        exit();
    }

    //filtros
    $filterName = isset($_POST["taskName"]) ? "%".$_POST["taskName"]."%" : "%%";
    $filterDesc = isset($_POST["taskDesc"]) ? "%".$_POST["taskDesc"]."%" : "%%";
    $filterDateBegin = isset($_POST["taskDateBegin"]) ? $_POST["taskDateBegin"] : "";
    $filterDateEnd = isset($_POST["taskDateEnd"]) ? $_POST["taskDateEnd"] : "";
    
    //verificando se foi realizada uma filtragem
    $filtered = false;

    if($filterName != "%%" || $filterDesc != "%%" || 
        $filterDateBegin != "" || $filterDateEnd != ""){
            $filtered = true;
    }

    $sql = "SELECT * FROM tasks 
        WHERE userKey = ? 
        AND taskname LIKE ?
        AND description LIKE ?
    ";
    $paramsType = "iss";
    $params = [$userId, $filterName, $filterDesc];

    //tratando as datas para consulta no banco
    if($filterDateBegin != ""){
        $filterDateBegin = date("Y-m-d", strtotime($filterDateBegin));
        array_push($params, $filterDateBegin);
        $sql .= "AND date >= ? ";
        $paramsType .= "s";
    }

    if($filterDateEnd != ""){
        $filterDateEnd = date("Y-m-d", strtotime($filterDateEnd));
        array_push($params, $filterDateEnd);
        $sql .= "AND date <= ?";
        $paramsType .= "s";
    }

    //armazenando as tarefas do usuário
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($paramsType, ...$params);
    $stmt->execute();

    $result = $stmt->get_result();

    $stmt->close();

    //caso o menu de filtros tenha sido utilizado ele se mantém ativo
    $filterBntlabel = "Mostrar Filtros";
    $filterContainer = "hidden";

    if($filtered){
        $filterBntlabel = "Fechar Filtros";
        $filterContainer = "";
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
    <script src="https://kit.fontawesome.com/da20799651.js" crossorigin="anonymous"></script>
</head>
<body>

    <div class = "userpage-container">
        <div class = "filter-container">
            <div class = "filter-header">
                <button id = "filter_btn" class = "btn btn-secondary"><?php echo $filterBntlabel ?></button>
                <input id = "filter_submit_btn" class = "btn btn-primary" type = "submit" form = "filter_form" value = "Filtrar">
            </div>

            <div class = "filter-box">
                <form id = "filter_form" class = "filter-form <?php echo $filterContainer ?>" method = "post" action = "userpage.php">
                    <label>Nome</label>
                    <input type = "text" name = "taskName" value = "<?php echo  trim($filterName, "%")?>">

                    <label>Descrição</label>
                    <textarea name = "taskDesc"><?php echo  trim($filterDesc, "%")?></textarea>

                    <label>Data início: </label>
                    <input type = "date" name = "taskDateBegin" value = "<?php echo $filterDateBegin;?>">

                    <label>Data fim: </label>
                    <input type = "date" name = "taskDateEnd" value = "<?php echo $filterDateEnd;?>">

                    <input id = "clear_filter_btn" class = "btn btn-warning" type = "button" value = "Limpar" onclick = "location.reload();">
                </form>
            </div>
        </div>

        <div class = "tasks-container">
            <a href = "tasks/create_task.html" class = "create-task-link">
                <button class = "btn btn-submit"><i class="fa-solid fa-plus" style = "color: var(--bgColor);"></i></button>
            </a>

            <div class = "tasks-box">
            <?php 
                //verificando se o usuário não possuí tarefas
                if($result->num_rows == 0){
                    echo "<p class = 'subtitle-text' style = 'text-align: center; margin-top: 2em;'>
                        Nenhuma tarefa encontrada.
                    </p>";
                }

                while($row = $result->fetch_assoc()){
                    $taskId = $row["taskId"];
                    $taskTitle = $row["taskname"];
                    $taskDesc = $row["description"];
                    $date = date("d/m/Y", strtotime($row["date"]));

                    echo '
                        <div class = "task">
                            <div class = "task-header">
                                <p class = "title-text">'.$taskTitle.'</p>
                                <p class = "subtitle-text"> Criação: '.$date.'</p>
                            </div>
                            <p class = "normal-text">'.$taskDesc.'</p>
                            <div class = "btns-container">
                                <form class = "edit-form" method = "post" action = "tasks/edit_task.php">
                                    <input class = "btn btn-secondary" type = "submit" value = "Editar">
                                    <input type = "hidden" name = "taskId" value = "'.$taskId.'">
                                </form>

                                <form class = "delete-form" method = "post" action = "tasks/delete_task.php">
                                    <input class = "btn btn-warning" type = "button" onclick = "confirmDelete(this.form, 0);" value = "Excluir">
                                    <input type = "hidden" name = "taskId" value = "'.$taskId.'">
                                </form>
                            </div>

                            <input type = "hidden" name = "taskId" value = "'.$taskId.'">
                        </div>
                    ';
                }
            ?>
            </div>
        </div>

        <div class = "user-container user-disable" id = "user_details">
            <div class = "user-area">
                <p class = "title-text">Olá, <?php echo $username ?>!</p>
                <form method = "post" action = "delete_account.php">
                    <input type = "button" id = "delete_account" onclick = "confirmDelete(this.form, 1)" value = "Excluir Conta">
                    <input type = "hidden" name = "userId" value = "<?php echo $userId ?>">
                </form>
                <div class = "user-footer">
                    <button class = "btn btn-secondary" id = "logout_btn">Sair</a>
                </div>
            </div>
            <div class = "show-user ">
                <button class = "btn btn-primary" id = "user_btn"><i class="fa-solid fa-user" style = "color: var(--bgColor);"></i></button>
            </div>
        </div>

        <div id = "overlay" class = "overlay hidden"></div>

        <div id = "alert" class = "alert-message hidden">
            <div class = "alert-container">
                <p id = "alert_title" class = "title-text">Aviso!</p>
                <p id = "alert_subtitle" class = "normal-text">Nome de usuário indisponível</p>
                <div class = "btn-container">
                    <button id = "cancel_btn" class = "hidden">Cancelar</button>
                    <button id = "ok_btn" class = "hidden">Ok</button>
                    <button id = "submit_btn" class = "hidden">Confirmar</button>
                    <button id = "delete_btn" class = "hidden">Excluir</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>