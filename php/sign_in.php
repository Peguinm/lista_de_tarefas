<?php
    session_start();
    include_once "connect.php";

    if(isset($_POST["username"]) && isset($_POST["password"])) 
    {
        $username = $_POST["username"];
        $password = $_POST["password"];

        //checando se o username está disponível
        $stmt = $conn->prepare(
            "SELECT * FROM users WHERE username = ?"
        );
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        
        //se o usuário estiver disponivel ele não é adicionado no db
        if($result->num_rows != 0){
            //direcionando para o index com erro
            $error = "username_not_avaiable";
            header("Location: ../index.html?error={$error}");
        }else{
            //adicionando o user no db
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();

            $userId = $conn->insert_id;

            //redirecionando para  a página de usuário
            $_SESSION["logged"] = true;
            $_SESSION["userId"] = $userId;
            $_SESSION["username"] = $username;
            header("Location: userpage.php");
        }

        $stmt->close();
    }

    $conn->close();

?>