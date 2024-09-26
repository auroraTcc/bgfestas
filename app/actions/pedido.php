<?php
    require "produto.php";
    require "carrinho.php";

    function getIdPedidoByCpfAndDate($conn, $cpfCliente, $dataDeEntrega){
        $query = "SELECT idPedido from pedido WHERE cpfCliente = ? AND dataEntg = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $cpfCliente, $dataDeEntrega);

        $stmt->execute();

        $resultados = $stmt->get_result();
        if ($row = $resultados->fetch_assoc()) {
            return $row['idPedido'];
        }
    }

    function getPedidosByCpfFunc($conn, $cpfFunc){
        $query = "SELECT * from pedido WHERE cpfResponsavel = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $cpfFunc);

        $stmt->execute();

        $resultados = $stmt->get_result();
        if ($row = $resultados->fetch_assoc()) {
            return $row['idPedido'];
        }
    }

    function getAllPedidos($conn){
        $query = "SELECT * from pedido";
        $stmt = $conn->prepare($query);

        $stmt->execute();

        $resultados = $stmt->get_result();
        if ($row = $resultados->fetch_assoc()) {
            return $row['idPedido'];
        }
    }

    function atualizarPreco($conn, $cpfCliente, $dataDeEntrega, $qtdJogos, $qtdCadeiras, $qtdMesas){
        $idPedido = getIdPedidoByCpfAndDate($conn, $cpfCliente, $dataDeEntrega);
        $precoJogos = getPrecoByProdt($conn, 'Jogo completo');
        $precoCadeiras = getPrecoByProdt($conn, 'Cadeira avulsa');
        $precoMesas = getPrecoByProdt($conn, 'Mesa avulsa');
        
        $totalProdts = $precoJogos*$qtdJogos + $precoCadeiras*$qtdCadeiras + $precoMesas*$qtdMesas;
        
        //Pedido mínino de R$50,00
        if($totalProdts < 50.00){
            $frete = 50.00 - $totalProdts;
        }else{
            $frete = 0;
        }

        $totalPedido = $totalProdts + $frete;

        $query = "UPDATE pedido SET preco = ? WHERE idPedido = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("di", $totalPedido, $idPedido);
        $stmt->execute();
    }
?>