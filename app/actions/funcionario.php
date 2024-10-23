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

    function getCpfFuncionarioByNome($conn, $nome){
        $query = "SELECT cpf from funcionario WHERE nome = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $nome);

        $stmt->execute();

        $resultados = $stmt->get_result();
        if ($row = $resultados->fetch_assoc()) {
            return $row['cpf'];
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
                return ["success" => true, "message" => "Login Realizado com sucesso", "funcionario" => $funcionario];
            } else {
                return [
                    "success" => false,
                    "message" => "Senha incorreta",
                    "funcionario" => ""
                ];
            }
        }
    
        return ["success" => false, "message" => "Usuário não encontrado", "funcionario" => ""];
    }

    function alterarSenha($conn, $cpf, $senha) {
        $query = "UPDATE funcionario SET senha = ?, primAcess = false WHERE cpf = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $senha, $cpf);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            return ["success" => true, "message" => "Senha alterada com sucesso"];
        } else {
            return ["success" => false, "message" => "Nenhuma alteração feita. Verifique se o CPF está correto."];
        }
    }


    //TODO:criar o pop-up para edição de funcionários.
    //* Importante que os inputs venham preenchidos com as infos atuais
    function atualizarCadastroFunc($conn, $idFunc, $nome, $email, $cargo ){
        $query = "UPDATE funcionario SET nome = ?, email = ?, cargo = ? WHERE cpf = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $nome, $email, $cargo, $idFunc);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            return ["success" => true, "message" => "Atualização realizada com sucesso"];
        } else {
            return ["success" => false, "message" => "Problemas ao atualizar cadastro."];
        }
    }

    //*O cpf solicitado será com pontuação?
    function ResetDefaultSenha($conn, $cpfFunc){
        $query = "UPDATE funcionario SET senha = 'PrimeiroAceso$cpfFunc', primAcess = true WHERE cpf = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $cpfFunc);
        $stmt->execute();
    }