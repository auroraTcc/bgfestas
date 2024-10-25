<?php
    require_once "../config/conexao.php";
    require "../actions/funcionario.php";

    header('Content-Type: application/json');

    if (!$conn) {
        $response = ["success" => false, "message" => "Erro ao conectar com o banco de dados"];
        echo json_encode($response);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $cpf = preg_replace('/\D/', '', $_POST["userCPF"]); // Limpa o CPF do usuário
    
        if (empty($cpf)) {
            echo json_encode(["success" => false, "message" => "O campo CPF é obrigatório"]);
            exit;
        }
    
        $result = resetSenhaPadrao($conn, $cpf);
        echo json_encode($result);
    }