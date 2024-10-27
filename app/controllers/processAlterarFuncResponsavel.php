<?php
    require_once "../config/conexao.php";
    require "../actions/pedido.php";

    header('Content-Type: application/json');

    $response = "";

    if (!$conn) {
        $response = ["success" => false, "message" => "Erro ao conectar com o banco de dados"];
        echo json_encode($response);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cpf = $_POST['cpf'];
        $pedido = $_POST['pedido'];

        if (empty($cpf) || empty($pedido)) {
            echo json_encode(["success" => false, "message" => "Campos obrigatórios faltando"]);
            exit;
        }

        if (setFunc($conn, $cpf, $pedido)) {
            echo json_encode(["success" => true, "message" => "Atualização realizada com sucesso"]);
        } else {
            echo json_encode(["success" => false, "message" => "Problemas ao alterar o responsável."]);
        }
    }
