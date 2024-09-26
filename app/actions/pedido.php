<?php
    require "../config/conexao.php";

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

    function getItensByIdpedido($conn, $idPedido){
        $query = "SELECT * from carrinho WHERE idPedido = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $idPedido);

        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    function getPrecoByProdt($conn, $produto){
        $query = "SELECT preco FROM produto WHERE nome = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $produto);
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['preco']; }
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