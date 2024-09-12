<?php
    require "../config/conexao.php";
    require "../models/pedido.php";
    require "../models/cliente.php";

    if ($_SERVER["REQUEST_METHOD"]=="POST"){
        $cep = $_POST["cep"];
        $endereco = $_POST["endereco"];
        $numero = $_POST["numero"];
        $complemento = $_POST["complemento"];
        $bairro = $_POST["bairro"];
        $cidade = $_POST["cidade"];
        $dataDeEntrega = $_POST["dataDeEntrega"];
        $horarioDaEntrega = $_POST["horarioDaEntrega"];
        $dataDeRetirada = $_POST["dataDeRetirada"];
        $horarioDaRetirada = $_POST["horarioDaRetirada"];
        //carrinho c/ produtos
        $cpfCliente = $_POST["cpf"];
        $nome = $_POST["nome"];
        $telefone = $_POST["telefone"];

        $cliente = new Cliente($conn);
        $cliente->setCPF($cpfCliente);
        $cliente->setNome($nome);
        $cliente->setContato($telefone);

        $cliente->inserirCliente($cpfCliente, $nome, $telefone);


        $pedido = new Pedido($conn);
    }
    
?>