<?php
    require_once "../config/conexao.php";
    require "../actions/funcionario.php";

    header('Content-Type: application/json');

    if (!$conn) {
        $response = ["success" => false, "message" => "Erro ao conectar com o banco de dados"];
        echo json_encode($response);
        exit;
    }

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $cpf = $_POST['cpf'];
        $senha = $_POST['senha'];
        $response = verificarUsuario($conn, $cpf, $senha);
    
        if ($response["success"] || $response["funcionario"] !== ""){
            session_start();
            $_SESSION['funcionario'] = $response["funcionario"];

            echo json_encode($response);
        }else{
            echo json_encode($response);
        }
     }

    