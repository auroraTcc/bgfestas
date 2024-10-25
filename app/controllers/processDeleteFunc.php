<?php
    require "../config/conexao.php";
    require "../actions/funcionario.php";

    header('Content-Type: application/json');

    if (!$conn) {
        $response = ["success" => false, "message" => "Erro ao conectar com o banco de dados"];
        echo json_encode($response);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"]=="POST"){
        $cpf = $_POST["cpf"];

        if (empty($cpf)) {
            $response = ["success" => false, "message" => "Campos obrigatórios estão faltando"];
            echo json_encode($response);
            exit;
        }

        if (deleteFunc($conn, $cpf)) {
            $allFuncs = getAllFuncs($conn);
            $response = ["success" => true, "message" => "Funcionário inserido com sucesso", "funcionarios" => $allFuncs];
            echo json_encode($response);
        } else {
            $response = ["success" => false, "message" => "Ocorreu um erro"];
            echo json_encode($response);
        }
    }