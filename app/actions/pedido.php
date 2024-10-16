<?php
    
    require "produto.php";
    require "carrinho.php";
    require "cliente.php";
    require 'funcionario.php';

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

    /* function getPedidosByCpfFunc($conn, $cpfFunc){
        $query = "SELECT * from pedido WHERE cpfResponsavel = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $cpfFunc);

        $stmt->execute();

        $resultados = $stmt->get_result();
        if ($row = $resultados->fetch_assoc()) {
            return $row['idPedido'];
        }
    } */

    //Seleciona todos os pedidos
    function getAllPedidos($conn){
        $query = "SELECT * from pedido ORDER BY dataEntg, horaEntg, dataRet, horaRet";
        $stmt = $conn->prepare($query);

        $stmt->execute();
        $resultados = $stmt->get_result();
        $updatedResults = [];

        if (mysqli_num_rows($resultados) > 0){
            while ($pedido = mysqli_fetch_assoc($resultados)) {
                $pedido['nomeCliente'] = getNomeClienteByCpf($conn, $pedido['cpfCliente']);
                $pedido['nomeFuncionario'] = getNomeFuncionarioByCpf($conn, $pedido['cpfResponsavel']);
                $pedido['itensCarrinho'] = getItensByIdpedido($conn, $pedido['idPedido']);
                $updatedResults[] = $pedido;
            }

            return $updatedResults;
        } else {
            return null;
        }
    }

    //Seleciona pedidos individualmente
    function getPedidoById($conn, $idPedido){
        $query = "SELECT * FROM pedido WHERE idPedido = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $idPedido);

        $stmt->execute();
        $resultados = $stmt->get_result();
        $updatedResults = [];

        if (mysqli_num_rows($resultados) > 0){
            while ($pedido = mysqli_fetch_assoc($resultados)) {
                $pedido['nomeCliente'] = getNomeClienteByCpf($conn, $pedido['cpfCliente']);
                $pedido['nomeFuncionario'] = getNomeFuncionarioByCpf($conn, $pedido['cpfResponsavel']);
                $pedido['itensCarrinho'] = getItensByIdpedido($conn, $pedido['idPedido']);
                $updatedResults[] = $pedido;
            }

            return $updatedResults;
        } else {
            return null;
        }
    }

    //Calcula e insere o preço na tabela
    function atualizarPreco($conn, $cpfCliente, $dataDeEntrega, $qtdJogos, $qtdCadeiras, $qtdMesas){
        $idPedido = getIdPedidoByCpfAndDate($conn, $cpfCliente, $dataDeEntrega);
        $precoJogos = getPrecoByProdt($conn, 'jogo');
        $precoCadeiras = getPrecoByProdt($conn, 'cadeira');
        $precoMesas = getPrecoByProdt($conn, 'mesa');
        
        $totalProdts = ($precoJogos*$qtdJogos) + ($precoCadeiras*$qtdCadeiras) + ($precoMesas*$qtdMesas);

        //Pedido mínino de R$50,00
        if($totalProdts < 50.00){
            $frete = 50.00 - $totalProdts;
            echo $frete;
        }else{
            $frete = 0;
            echo $frete;
        }

        $totalPedido = $totalProdts + $frete;

        $query = "UPDATE pedido SET preco = ? WHERE idPedido = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("di", $totalPedido, $idPedido);
        $stmt->execute();
    }

        //Atualizar o funcionario responsavel
        function setFunc($conn, $){
            $idPedido = $_GET['id'];
            $idFunc = $funcionario['cpf'];
            $query = "UPDATE pedido SET cpfResponsavel = $idFunc WHERE idPedido = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $idPedido);
            $stmt->execute();
        }

?>