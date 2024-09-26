<?php
    require_once "../../../app/config/conexao.php";
    function getPrecoByProdt($conn, $produto){
        $query = "SELECT preco FROM produto WHERE nome = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $produto);
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['preco']; }
    }


?>