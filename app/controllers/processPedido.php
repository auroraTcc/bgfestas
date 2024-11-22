<?php
require "../config/conexao.php";
require "../models/pedido.php";
require "../models/cliente.php";
require "../models/carrinho.php";
require_once "../actions/pedido.php";

header('Content-Type: application/json'); 

if (!$conn) {
    $response = ["success" => false, "message" => "Erro ao conectar com o banco de dados"];
    echo json_encode($response);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta de dados do formulário
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

    $cliente->inserirCliente($conn, $cpfCliente, $nome, $telefone);

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

    // Inserção no carrinho
    $carrinho = new Carrinho($conn);
    if ($qtdJogos > 0) { $carrinho->inserirCarrinho("jogo", $qtdJogos, $cpfCliente, $dataDeEntrega); }
    if ($qtdMesas > 0) { $carrinho->inserirCarrinho("mesa", $qtdMesas, $cpfCliente, $dataDeEntrega); }
    if ($qtdCadeiras > 0) { $carrinho->inserirCarrinho("cadeira", $qtdCadeiras, $cpfCliente, $dataDeEntrega); }

    atualizarPreco($conn, $cpfCliente, $dataDeEntrega, $qtdJogos, $qtdCadeiras, $qtdMesas);

    echo json_encode(["success" => true, "message" => ""]);

} else {
    echo json_encode(["success" => false, "message" => "Método não permitido. Tente novamente"]);
}
