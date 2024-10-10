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

    function getAllFuncs($conn){
        $query = "SELECT * FROM funcionario";
        $stmt = $conn->prepare($query);

        $stmt->execute();
        $resultados = $stmt->get_result();
        $updatedResults = [];

        if (mysqli_num_rows($resultados) > 0){
            while ($funcionario = mysqli_fetch_assoc($resultados)) {
                $updatedResults[] = $funcionario;
            }

            return $updatedResults;
        } else {
            return null;
        }
    }

    function deleteFunc($conn, $cpf){
        $query = "SELECT * FROM funcionario WHERE cpf = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $cpf);

        $stmt->execute();
    }
?>