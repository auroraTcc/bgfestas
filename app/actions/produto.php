<?php
    function getPrecoByProdt($conn, $produto){
        $query = "SELECT preco FROM produto WHERE nome = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $produto);
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['preco'];
        }
    }

    function getProdtNameByProdtId($conn, $idProdt){
        $query = "SELECT nome FROM produto WHERE idProdt = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $idProdt);
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['nome']; }
    }


?>