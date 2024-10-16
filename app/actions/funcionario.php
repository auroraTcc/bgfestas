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

    function deleteFunc($conn, $cpf) {
        $query = "DELETE FROM funcionario WHERE cpf = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $cpf);

       
        if ($stmt->execute()) {
            $stmt->close(); 
            return true; 
        } else {
            $stmt->close(); 
            return false; 
        }
    }
    
    function verificarUsuario($conn, $cpf, $senha){
        $query = "SELECT * FROM funcionario WHERE cpf = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $cpf);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if($result->num_rows === 1){
            $funcionario = $result->fetch_assoc();
    
            // Debug: print senha fornecida e hash esperado
            if (password_verify($senha, $funcionario['senha'])) {
                return ["success" => true, "message" => "", "content" => $funcionario];
            } else {
                return [
                    "success" => false,
                    "message" => "Senha incorreta",
                    "content" => ""
                ];
            }
        }
    
        return ["success" => false, "message" => "Usuário não encontrado", "content" => ""];
    }