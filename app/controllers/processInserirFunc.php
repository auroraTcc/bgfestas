<?php
    header('Content-Type: application/json');

    if (!$conn) {
        $response = ["success" => false, "message" => "Erro ao conectar com o banco de dados"];
        echo json_encode($response);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"]=="POST"){
        //coleta de dados do formulário
        $cpf = $_POST["cpf"];
        $cpfNumbers = preg_replace('/[^0-9]/', '', $cpf);
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = "PrimeiroAcesso$cpfNumbers";
        $senhahash = password_hash($senha, PASSWORD_DEFAULT);
        $cargo = "Funcionário";

        if (empty($cpf) || empty($nome) || empty($email)) {
            $response = ["success" => false, "message" => "Campos obrigatórios estão faltando"];
            echo json_encode($response);
            exit;
        }

        $funcionario = new Funcionario($conn);
        $funcionario->setCPF($cpf);
        $funcionario->setNome($nome);
        $funcionario->setEmail($email);

        $func = new Funcionario($conn);

        $selectedFunc = $func->getFuncionarioByCpf($cpf);

        if ($selectedFunc) {
            $func->atualizarCadastroFunc($nome, $email, $cpf);
        } else {
            $funcionario->inserirFuncionario($cpf, $nome, $email, $senhahash, $cargo);
        }

        
        $allFuncs = $func->getAllFuncs();
        $response = ["success" => true, "message" => "Funcionário inserido com sucesso", "funcionarios" => $allFuncs];
        echo json_encode($response);
        
    }  else {
        $response = ["success" => false, "message" => "Método não permitido"];
        echo json_encode($response);
    }