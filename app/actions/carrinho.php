<?php
    require_once "../../../app/config/conexao.php";
    function getItensByIdpedido($conn, $idPedido){
        $query = "SELECT * from carrinho WHERE idPedido = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $idPedido);

        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
?>