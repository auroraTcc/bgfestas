<?php
    function getNomeFuncionarioByCpf($conn, $cpfCliente){
        $query = "SELECT nome from funcionario WHERE cpf = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $cpfCliente);

        $stmt->execute();

        $resultados = $stmt->get_result();
        if ($row = $resultados->fetch_assoc()) {
            return $row['nome'];
        }
    }
?>