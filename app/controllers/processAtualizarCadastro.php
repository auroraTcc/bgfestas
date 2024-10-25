<?php
    require_once "../config/conexao.php";
    require_once "../actions/funcionario.php";

    if (!$conn) {
        $response = ["success" => false, "message" => "Erro ao conectar com o banco de dados"];
        echo json_encode($response);
        exit;
    }

    if($_SERVER['REQUEST_METHOD']=="POST"){
        $idFunc = getCpfFuncionarioByNome($conn, $nome);
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $cargo = $_POST["cargo"];

        $allFuncs = getAllFuncs($conn);

        atualizarCadastroFunc($conn, $idFunc, $nome, $email, $cargo);
        $response = ["success" => true, "message" => "", "funcionarios" => $allFuncs];
        echo json_encode($response);
    }

