<?php
    require "../config/conexao.php";

    function getIdPedidoByCpfAndDate($conn, $cpfCliente, $dataEntg){
        $query = "SELECT idPedido from pedido WHERE cpfCliente = ? AND dataEntg = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $cpfCliente, $dataDeEntrega);

        $stmt->execute();

        $resultados = $stmt->get_result();
        if ($row = $resultados->fetch_assoc()) {
            return $row['idPedido'];
        }
    }

    function getItensByIdpedido($conn, $idPedido){
        $query = "SELECT * from carrinho WHERE idPedido = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $idPedido);

        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($rows) {
            print_r ($rows);
        }
    }
?>