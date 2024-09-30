<?php

    function getItensByIdpedido($conn, $idPedido){
        $query = "SELECT * from carrinho WHERE idPedido = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $idPedido);

        $stmt->execute();

        $resultados = $stmt->get_result();
        $carrinho = [];
        if(mysqli_num_rows($resultados)) {
            while ($item = $resultados->fetch_assoc()) {  
                $item['nome'] = getProdtNameByProdtId($conn, $item['idProdt']);
                $carrinho[] = $item;
            }
            return $carrinho;
        }
    }
?>