<?php
    header('Content-Type: application/json');
    
    if (!$conn) {
        $response = ["success" => false, "message" => "Erro ao conectar com o banco de dados"];
        echo json_encode($response);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"]=="POST"){
        $order = new Pedido($conn);
        $allBairros = $order->getAllBairros();
        $response = ["success" => true, "message" => "", "bairros" => $allBairros];
        echo json_encode($response);
    }