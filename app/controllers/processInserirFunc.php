<?php
    require "../config/conexao.php";
    require "../models/funcionario.php";

    if (!$conn) {
        die("Erro ao conectar com o banco de dados: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"]=="POST"){
        //coleta de dados do formulário
        $cpf = $_POST["cpfFunc"];
        $nome = $_POST["nomeFunc"];
        $email = $_POST["emailFunc"];
        $senha = $_POST[""];

        $funcionario = new Funcionario($conn);
        $funcionario->setCPF($cpf);
        $funcionario->setNome($nome);
        $funcionario->setEmail($email);

        $funcionario->inserirFuncionario( $cpfFunc, $nomeFunc, $emailFunc);

    }