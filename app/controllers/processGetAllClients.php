<?php
    header('Content-Type: application/json');
    
    if (!$conn) {
        $response = ["success" => false, "message" => "Erro ao conectar com o banco de dados"];
        echo json_encode($response);
        exit;
    }

    

    if ($_SERVER["REQUEST_METHOD"]=="POST"){
        $client = new Cliente($conn);
        $clientes = $client->getAllClientes();

        foreach ($clientes as $index => $cliente) {
            $order = new Pedido($conn);
            $clientes[$index]['bairros'] = $order->getBairroByCpfCliente($cliente['cpf']);
        }

        $response = ["success" => true, "message" => "", "clientes" => $clientes];
        echo json_encode($response);
    }