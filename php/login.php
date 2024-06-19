<?php
    session_start();
    include_once "connect.php";

    //verificando se os campos foram definidos
    if(isset($_POST["username"]) && isset($_POST["password"])){
        $username = $_POST["username"];
        $password = $_POST["password"];
    
        //executando a consulta no db
        $stmt = $conn->prepare(
            "SELECT * FROM users 
            WHERE username = ? AND password = ?"
        );
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();

        //armazenando o resultado da consulta
    $result = $stmt->get_result();

        //se um usuário com o username e senha for econtrado, armazerá os dados da consulta em $row
        if($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            //se a senha for similar a do db a sessãp armazenará o status de logged como true
            if($password === $row["password"]){
                //redirecionando para  a página de usuário
                $_SESSION["logged"] = true;
                $_SESSION["userId"] = $row["userId"];
                $_SESSION["username"] = $row["username"];
                header("Location: userpage.php");
            }
        }else{
            //direcionando para o index com erro
            $error = "wrong_username_or_password";
            header("Location: ../index.html?error={$error}");
        }
        $stmt->close();
    }else{
        header("Location: ../index.html");
    }
    $conn->close();
?>
