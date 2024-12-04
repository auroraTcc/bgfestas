<?php
    header('Content-Type: application/json');

    if (!$conn) {
        $response = ["success" => false, "message" => "Erro ao conectar com o banco de dados"];
        echo json_encode($response);
        exit;
    }

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $cpf = $_POST['cpf'];
        $senha = $_POST['senha'];
        $func = new Funcionario($conn);
        $response = $func->verificarUsuario($cpf, $senha, $isLocal);
    
        if ($response["success"] || $response["funcionario"] !== ""){
            $_SESSION['funcionario'] = $response["funcionario"];

            echo json_encode($response);
        }else{
            echo json_encode($response);
        }
     }

    