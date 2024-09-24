<?php
    require "../config/conexao.php";
    require "../models/pedido.php";
    require "../models/cliente.php";
    require "../models/carrinho.php";

    if (!$conn) {
        die("Erro ao conectar com o banco de dados: " . mysqli_connect_error());
    }

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
        
        $qtdJogos = $_POST["jogos"];
        $qtdMesas = $_POST["mesas"];
        $qtdCadeiras = $_POST["cadeiras"];

        $cpfCliente = $_POST["cpf"];
        $nome = $_POST["nome"];
        $telefone = $_POST["telefone"];

        $cliente = new Cliente($conn);
        $cliente->setCPF($cpfCliente);
        $cliente->setNome($nome);
        $cliente->setContato($telefone);

        $cliente->inserirCliente($cpfCliente, $nome, $telefone);
 
        $pedido = new Pedido($conn);
        $pedido->setCep($cep);
        $pedido->setEndereco($endereco);
        $pedido->setNumero($numero);
        $pedido->setComplemento($complemento);
        $pedido->setBairro($bairro);
        $pedido->setCidade($cidade);
        $pedido->setDataEntrega($dataDeEntrega);
        $pedido->setHoraEntrega($horarioDaEntrega);
        $pedido->setDataRetirada($dataDeRetirada);
        $pedido->setHoraRetirada($horarioDaRetirada);
        $pedido->setCpfCliente($cpfCliente);
        $pedido->setTelefone($telefone);

        $pedido->inserirPedido($cep, $endereco, $numero, $complemento, $bairro, $cidade, $dataDeEntrega, $horarioDaEntrega, $dataDeRetirada, $horarioDaRetirada, $cpfCliente, $telefone);
    
        $carrinho = new Carrinho($conn);

        if($qtdJogos > 0) {
            $carrinho->inserirCarrinho("Jogo completo", $qtdJogos, $cpfCliente, $dataDeEntrega);
        }

        if($qtdMesas > 0) {
            $carrinho->inserirCarrinho("Mesa avulsa", $qtdMesas, $cpfCliente, $dataDeEntrega);
        }
        if($qtdCadeiras > 0) {
            $carrinho->inserirCarrinho("Cadeira avulsa", $qtdCadeiras, $cpfCliente, $dataDeEntrega);
        }
    }
    