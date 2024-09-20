<?php
require_once "../config/conexao.php";
require "../models/pedido.php";
require "../models/cliente.php";
require "../models/carrinho.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    $prodt1 = $_POST["jogos"];
    $prodt2 = $_POST["mesas"];
    $prodt3 = $_POST["cadeiras"];
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

    $idPedido = $conn->insert_id;

    // IDs dos produtos no banco de dados
    $idJogos = 151;
    $idMesas = 152;
    $idCadeiras = 153;

    // Inserir Jogos
    if ($prodt1 > 0) {
        $queryItem = "INSERT INTO carrinho (idPedido, idProdt, quantidade) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($queryItem);
        $stmt->bind_param('iii', $idPedido, $idJogos, $prodt1);
        $stmt->execute();
    }

    // Inserir Mesas
    if ($prodt2 > 0) {
        $stmt = $conn->prepare($queryItem);
        $stmt->bind_param('iii', $idPedido, $idMesas, $prodt2);
        $stmt->execute();
    }

    // Inserir Cadeiras
    if ($prodt3 > 0) {
        $stmt = $conn->prepare($queryItem); 
        $stmt->bind_param('iii', $idPedido, $idCadeiras, $prodt3);
        $stmt->execute();
    }

    // Fechar statement
    $stmt->close();

}
