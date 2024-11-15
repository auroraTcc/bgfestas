<?php
    require "../config/conexao.php";
    require "../actions/pedido.php";

    header('Content-Type: application/json');
    
    if (!$conn) {
        $response = ["success" => false, "message" => "Erro ao conectar com o banco de dados"];
        echo json_encode($response);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"]=="POST"){
        $clientes = getAllClientes($conn);

        foreach ($clientes as &$cliente) { 
            $cliente['bairros'] = getBairroByCpfCliente($conn, $cliente['cpf']);
        }

        $response = ["success" => true, "message" => "", "clientes" => $clientes];
        echo json_encode($response);
    }