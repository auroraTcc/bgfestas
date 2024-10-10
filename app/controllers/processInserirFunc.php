<?php
    require "../config/conexao.php";
    require "../models/funcionario.php";

    if (!$conn) {
        die("Erro ao conectar com o banco de dados: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"]=="POST"){
        //coleta de dados do formulário
        $cpf = $_POST["cpf"];
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = "PrimeiroAcesso".$cpf;
        $cargo = "Funcionário";

        $funcionario = new Funcionario($conn);
        $funcionario->setCPF($cpf);
        $funcionario->setNome($nome);
        $funcionario->setEmail($email);

        $funcionario->inserirFuncionario( $cpf, $nome, $email, $senha, $cargo);

    }