<?php
    header('Content-Type: application/json');

    $response = [];

    if (!$conn) {
        $response = ["success" => false, "message" => "Erro ao conectar com o banco de dados"];
        echo json_encode($response);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $pedido = $_POST['pedido'];

        if (empty($pedido)) {
            echo json_encode(["success" => false, "message" => "Campos obrigatórios faltando"]);
            exit;
        }

        $order = new Pedido($conn);
        
        if ($order->atualizarSttsPedido($pedido)) {
            echo json_encode(["success" => true, "message" => "Atualização realizada com sucesso"]);
        } else {
            echo json_encode(["success" => false, "message" => "Problemas ao atualizar o status do pedido"]);
        }
        exit; 
    }
