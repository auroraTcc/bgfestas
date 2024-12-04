<?php
    header('Content-Type: application/json');

    if (!$conn) {
        $response = ["success" => false, "message" => "Erro ao conectar com o banco de dados"];
        echo json_encode($response);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $cpf =  $_POST["userCPF"];
    
        if (empty($cpf)) {
            echo json_encode(["success" => false, "message" => "O campo CPF é obrigatório"]);
            exit;
        }

        $func= new Funcionario($conn);
    
        $result = $func->resetSenhaPadrao($cpf);
        echo json_encode($result);
    }