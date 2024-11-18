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

    function getPedidosByCpfFunc($conn, $cpfFunc){
        $query = "SELECT * from pedido WHERE cpfResponsavel = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $cpfFunc);

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
        }else{
            $frete = 0;
        }

        $totalPedido = $totalProdts + $frete;

        $query = "UPDATE pedido SET preco = ? WHERE idPedido = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("di", $totalPedido, $idPedido);
        $stmt->execute();
    }

    //Atualizar o funcionario responsavel
    function setFunc($conn, $cpfFunc, $idPedido) {
        $query = "UPDATE pedido SET cpfResponsavel = ? WHERE idPedido = ?";
        $stmt = $conn->prepare($query);
        
        if (!$stmt) {
            return false; 
        }

        $stmt->bind_param("si", $cpfFunc, $idPedido);
        return $stmt->execute();
    }

    function atualizarSttsPedido($conn, $idPedido){
        $pedido = getPedidoById($conn, $idPedido);

        if (!$pedido) {
            return false;
        }

        $newLabel = null;

        if ($pedido[0]["stts"] === "entrega") {
            $newLabel = "retirada";
        } elseif ($pedido[0]["stts"] === "retirada") {
            $newLabel = "finalizado";
        }

        if ($newLabel === null) {
            return false;
        }

        $query = "UPDATE pedido SET stts = ? WHERE idPedido = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            return false; 
        }

        $stmt->bind_param("si", $newLabel, $idPedido);
        return $stmt->execute();
    }

    function excluirPedido($conn, $idPedido) {
 
        $conn->begin_transaction();
    
        try {
           
            $query = "DELETE FROM carrinho WHERE idPedido = ?";
            $stmt = $conn->prepare($query);
            
            if (!$stmt) {
                throw new Exception("Erro ao preparar a exclusão do carrinho.");
            }
    
            $stmt->bind_param("i", $idPedido);
            if (!$stmt->execute()) {
                throw new Exception("Erro ao executar a exclusão do carrinho.");
            }

            $query = "DELETE FROM pedido WHERE idPedido = ?";
            $stmt = $conn->prepare($query);
    
            if (!$stmt) {
                throw new Exception("Erro ao preparar a exclusão do pedido.");
            }
    
            $stmt->bind_param("i", $idPedido);
            if (!$stmt->execute()) {
                throw new Exception("Erro ao executar a exclusão do pedido.");
            }
    
            $conn->commit();
            return true;
    
        } catch (Exception $e) {
            
            $conn->rollback();
            return false;
        }
    }

    function getBairroByCpfCliente($conn, $cpfCliente){
        $query = "SELECT DISTINCT bairro FROM pedido WHERE cpfCliente = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $cpfCliente);

        $stmt->execute();
        $resultados = $stmt->get_result();

        $bairros = [];
        while ($row = $resultados->fetch_assoc()) {
            $bairros[] = $row['bairro'];
        }
        return $bairros;
    }

    function getAllBairros($conn){
        $query = "SELECT DISTINCT bairro FROM pedido";
        $stmt = $conn->prepare($query);

        $stmt->execute();
        $resultados = $stmt->get_result();

        $bairros = [];
        while ($row = $resultados->fetch_assoc()) {
            $bairros[] = $row['bairro'];
        }
        return $bairros;
    }

    function getPedidosFinalizados($conn){
        $query = "SELECT * FROM pedido WHERE stts = 'finalizado'";
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