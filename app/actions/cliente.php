<?php
   function getAllClientes($conn){
    $query = "SELECT * from cliente";
    $stmt = $conn->prepare($query);

    $stmt->execute();

    $resultados = $stmt->get_result();
    $updatedResults = [];

        if (mysqli_num_rows($resultados) > 0){
            while ($cliente = mysqli_fetch_assoc($resultados)) {
                $updatedResults[] = $cliente;
            }

            return $updatedResults;
        } else {
            return null;
        }
}
    function getNomeClienteByCpf($conn, $cpfCliente){
        $query = "SELECT nome from cliente WHERE cpf = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $cpfCliente);

        $stmt->execute();

        $resultados = $stmt->get_result();
        if ($row = $resultados->fetch_assoc()) {
            return $row['nome'];
        }
    }

    function getClienteByCpf($conn, $cpfCliente){
        $query = "SELECT * from cliente WHERE cpf = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $cpfCliente);

        $stmt->execute();
        $resultados = $stmt->get_result();
        if (mysqli_num_rows($resultados) > 0){
            while ($cliente = mysqli_fetch_assoc($resultados)) {
                $updatedResults = $cliente;
            }

            return $updatedResults;
        } else {
            return null;
        }


    }
?>