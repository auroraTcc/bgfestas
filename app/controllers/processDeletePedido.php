<?php
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

        $order = new Pedido($conn);

        if ($order->excluirPedido($pedido)) {
            $redirectUrl = $isLocal ? "bgfestas/admin" : "admin";
            echo json_encode(["success" => true, "message" => "Atualização realizada com sucesso", "redirect" => $redirectUrl]);
        } else {
            echo json_encode(["success" => false, "message" => "Problemas ao alterar o responsável."]);
        }
    }