<?php
    header('Content-Type: application/json');
    
    if (!$conn) {
        $response = ["success" => false, "message" => "Erro ao conectar com o banco de dados"];
        echo json_encode($response);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"]=="POST"){
        $func = new Funcionario($conn);
        $allFuncs = $func->getAllFuncs();
        $response = ["success" => true, "message" => "", "funcionarios" => $allFuncs];
        echo json_encode($response);
    }