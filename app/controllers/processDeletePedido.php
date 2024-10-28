<?php
require_once "../config/conexao.php";
require "../actions/pedido.php";

header('Content-Type: application/json');

if (!$conn) {
    echo json_encode(["success" => false, "message" => "Erro ao conectar com o banco de dados"]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pedido = $_POST['pedido'];

    if (empty($pedido)) {
        echo json_encode(["success" => false, "message" => "Campos obrigatórios faltando"]);
        exit;
    }

    if (excluirPedido($conn, $pedido)) {
        echo json_encode(["success" => true, "message" => "Atualização realizada com sucesso"]);
    } else {
        echo json_encode(["success" => false, "message" => "Problemas ao alterar o responsável."]);
    }
}