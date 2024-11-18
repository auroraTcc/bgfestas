<?php
date_default_timezone_set('America/Sao_Paulo');

require "../config/isLogged.php";
require_once "../config/conexao.php";
require_once "../actions/recibo.php"; 
require_once "../actions/pedido.php"; 



if (!$isLogged) {
    header("Location: /bgfestas/app/view/admin/login");
    exit;
}

$idPedido = $_GET['id'] ?? null;

if (!$idPedido) {
    echo "Pedido não encontrado.";
    exit;
}

$pedido = getPedidoById($conn, $idPedido); 


if (!$pedido) {
    echo "Pedido não encontrado.";
    exit;
}

$pedido = $pedido[0];

$pedido['subtotal'] = 0;
foreach ($pedido['itensCarrinho'] as $item) {
    $pedido['subtotal'] += $item['preco'] * $item['quantidade'];
}


if ($pedido['subtotal'] < 50.00) {
    $pedido['frete'] = 50.00 - $pedido['subtotal'];
} else {
    $pedido['frete'] = 0;
}

$total = $pedido['subtotal'] + $pedido['frete'];
$pedido['total'] = $total;

$dados = [
    "data" => date('d/m/Y'),
    "hora" => date('H:i'),
    "nome" => $pedido["nomeCliente"],
    "cpf" => $pedido['cpfCliente'],
    "valor" => $pedido["total"],
    "carrinho" => $pedido["itensCarrinho"],
    "frete" =>  $pedido['frete'],
    "empresa" => [
        "nome" => "BGFESTAS",
        "endereco" => "Viela Pires do Rio, 121 - Gopoúva - Guarulhos / SP",
        "telefone" => "(11) 92005-6929",
        "funcionario" => "Gilson Angelo Mangia"
    ]
];


$pdf = gerarRecibo($dados);

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="recibo-' . $nomeClienteSanitizado . '.pdf"');
echo $pdf;
