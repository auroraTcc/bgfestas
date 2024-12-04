<?php
    header('Content-Type: application/json');

    $response = "";

    if (!$conn) {
        $response = ["success" => false, "message" => "Erro ao conectar com o banco de dados"];
        echo json_encode($response);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      
        $cpf = $_POST['cpf'];
        $password = $_POST['newPassword'];
        $passwordRepeat = $_POST['newPasswordRepeat'];

        $senhahash = password_hash($password, PASSWORD_DEFAULT);


        if ($password === "PrimeiroAcesso$cpf") {
            $response = ["success" => false, "message" => "Não utilize a senha básica"];
            echo json_encode($response);
            exit;
        }

        
        if ($password !== $passwordRepeat) {
            $response = ["success" => false, "message" => "As senhas não são iguais"];
            echo json_encode($response);
            exit;
        }

        $func = new Funcionario($conn);

        $response = $func->alterarSenha( $cpf, $senhahash, $isLocal);
        echo json_encode($response);
    }