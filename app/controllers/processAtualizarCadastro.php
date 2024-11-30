<?php
    require_once "../config/conexao.php";
    require_once "../actions/funcionario.php";

    header('Content-Type: application/json');

    if (!$conn) {
        $response = ["success" => false, "message" => "Erro ao conectar com o banco de dados"];
        echo json_encode($response);
        exit;
    }

    if($_SERVER['REQUEST_METHOD']=="POST"){
        $func = new Funcionario($conn);
        $idFunc = $func->getCpfFuncionarioByNome($nome);
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $cargo = $_POST["cargo"];

        $allFuncs = $func->getAllFuncs();

        $func->atualizarCadastroFunc($idFunc, $nome, $email);
        $response = ["success" => true, "message" => "", "funcionarios" => $allFuncs];
        echo json_encode($response);
    }

