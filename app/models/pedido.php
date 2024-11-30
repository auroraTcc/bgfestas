<?php
    class Pedido {
        function __construct($conn) {
            $this->conn = $conn;
        }
        public function populate($data) {
            $this->cep = $data['cep'];
            $this->idPedido = $data['idPedido'];
            $this->endereco = $data['endereco'];
            $this->numero = $data['numero'];
            $this->complemento = $data['complemento'];
            $this->bairro = $data['bairro'];
            $this->cidade = $data['cidade'];
            $this->dataEntg = $data['dataEntg'];
            $this->horaEntg = $data['horaEntg'];
            $this->dataRet = $data['dataRet'];
            $this->horaRet = $data['horaRet'];
            $this->cpfCliente = $data['cpfCliente'];
            $this->telefone = $data['telefone'];
            $this->nomeCliente = $data['nomeCliente'];
            $this->nomeFuncionario = $data['nomeFuncionario'];
            $this->itensCarrinho = $data['itensCarrinho'] ?? [];
            $this->stts = $data['stts'];
            $this->cpfResponsavel = $data['cpfResponsavel'];
        }
        private $conn;
        private $idPedido;         
        private $cep;
        private $endereco;
        private $numero;
        private $complemento;
        private $bairro;
        private $cidade;
        private $dataEntg;
        private $horaEntg;
        private $dataRet;
        private $horaRet;
        private $cpfCliente;
        private $telefone;
        private $stts;
        private $nomeCliente;
        private $nomeFuncionario;
        private $cpfResponsavel;
        private $itensCarrinho;

        public function getCep() { return $this->cep; }
        public function setCep($cep) { $this->cep = $cep; }

        public function getIdPedido() { return $this->idPedido; }
        public function setIdPedido($idPedido) { $this->idPedido = $idPedido; }

        public function getEndereco() { return $this->endereco; }
        public function setEndereco($endereco) { $this->endereco = $endereco; }

        public function getNumero() { return $this->numero; }
        public function setNumero($numero) { $this->numero = $numero; }

        public function getComplemento() { return $this->complemento; }
        public function setComplemento($complemento) { $this->complemento = $complemento; }

        public function getBairro() { return $this->bairro; }
        public function setBairro($bairro) { $this->bairro = $bairro; }

        public function getCidade() { return $this->cidade; }
        public function setCidade($cidade) { $this->cidade = $cidade; }

        public function getDataEntrega() { return $this->dataEntg; }
        public function setDataEntrega($dataEntg) { $this->dataEntg = $dataEntg; }

        public function getHoraEntrega() { return $this->horaEntg; }
        public function setHoraEntrega($horaEntg) { $this->horaEntg = $horaEntg; }

        public function getDataRetirada() { return $this->dataRet; }
        public function setDataRetirada($dataRet) { $this->dataRet = $dataRet; }

        public function getHoraRetirada() { return $this->horaRet; }
        public function setHoraRetirada($horaRet) { $this->horaRet = $horaRet; }

        public function getCpfCliente() { return $this->cpfCliente; }
        public function setCpfCliente($cpfCliente) { $this->cpfCliente = $cpfCliente; }

        public function getTelefone() { return $this->telefone; }
        public function setTelefone($telefone) { $this->telefone = $telefone; }

        public function getNomeCliente() { return $this->nomeCliente; }
        public function setNomeCliente($nomeCliente) { $this->nomeCliente = $nomeCliente; }

        public function getNomeFuncionario() { return $this->nomeFuncionario; }
        public function setNomeFuncionario($nomeFuncionario) { $this->nomeFuncionario = $nomeFuncionario; }

        public function getCpfResponsavel() { return $this->nomeFuncionario; }
        public function setCpfResponsavel($cpfResponsavel) { $this->cpfResponsavel = $cpfResponsavel; }

        public function getItensCarrinho() { return $this->itensCarrinho; }
        public function setItensCarrinho($itensCarrinho) { $this->itensCarrinho = $itensCarrinho; }

        public function getStts() { return $this->stts; }
        public function setStts($stts) { $this->stts = $stts; }

        public function inserirPedido($cep, $endereco, $numero, $complemento, $bairro, $cidade, $dataEntg, $horaEntg, $dataRet, $horaRet, $cpfCliente, $telefone) {
            $query = "INSERT INTO pedido(cep, endereco, numero, complemento, bairro, cidade, dataEntg, horaEntg, dataRet, horaRet, cpfCliente, telefone) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ssisssssssss', $cep, $endereco, $numero, $complemento, $bairro, $cidade, $dataEntg, $horaEntg, $dataRet, $horaRet, $cpfCliente, $telefone);

            $stmt->execute();

            $stmt->close();
        }

        public function getIdPedidoByCpfAndDate($cpfCliente, $dataDeEntrega){
            $query = "SELECT idPedido from pedido WHERE cpfCliente = ? AND dataEntg = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ss', $cpfCliente, $dataDeEntrega);
    
            $stmt->execute();
    
            $resultados = $stmt->get_result();
            if ($row = $resultados->fetch_assoc()) {
                return $row['idPedido'];
            }
        }
    
        public function getPedidosByCpfFunc($cpfFunc){
            $query = "SELECT * from pedido WHERE cpfResponsavel = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('s', $cpfFunc);
    
            $stmt->execute();
            $resultados = $stmt->get_result();
            $updatedResults = [];
    
            if (mysqli_num_rows($resultados) > 0){
                while ($pedido = mysqli_fetch_assoc($resultados)) {
                    
                    $client = new Cliente($this->conn);
                    $func = new Funcionario($this->conn);
                    $cart = new Carrinho($this->conn);

                    $pedido['nomeCliente'] = $client->getNomeClienteByCpf($pedido['cpfCliente']);
                    $pedido['nomeFuncionario'] = $func->getNomeFuncionarioByCpf($pedido['cpfResponsavel']);
                    $pedido['itensCarrinho'] = $cart->getItensByIdpedido($pedido['idPedido']);
                    $updatedResults[] = $pedido;
                }
    
                return $updatedResults;
            } else {
                return null;
            }
        }
    
        //Seleciona todos os pedidos
        public function getAllPedidos(){
            $query = "SELECT * from pedido ORDER BY dataEntg, horaEntg, dataRet, horaRet";
            $stmt = $this->conn->prepare($query);
    
            $stmt->execute();
            $resultados = $stmt->get_result();
            $updatedResults = [];
    
            if (mysqli_num_rows($resultados) > 0){
                while ($pedido = mysqli_fetch_assoc($resultados)) {
                    $client = new Cliente($this->conn);
                    $func = new Funcionario($this->conn);
                    $cart = new Carrinho($this->conn);

                    $pedido['nomeCliente'] = $client->getNomeClienteByCpf($pedido['cpfCliente']);
                    $pedido['nomeFuncionario'] = $func->getNomeFuncionarioByCpf($pedido['cpfResponsavel']);
                    $pedido['itensCarrinho'] = $cart->getItensByIdpedido($pedido['idPedido']);
                    $updatedResults[] = $pedido;
                }
    
                return $updatedResults;
            } else {
                return null;
            }
        }
    
        //Seleciona pedidos individualmente
        public function getPedidoById($idPedido){
            $query = "SELECT * FROM pedido WHERE idPedido = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('i', $idPedido);
    
            $stmt->execute();
            $resultados = $stmt->get_result();
            $updatedResults = [];
    
            if (mysqli_num_rows($resultados) > 0){
                while ($pedido = mysqli_fetch_assoc($resultados)) {
                    $client = new Cliente($this->conn);
                    $func = new Funcionario($this->conn);
                    $cart = new Carrinho($this->conn);

                    $pedido['nomeCliente'] = $client->getNomeClienteByCpf($pedido['cpfCliente']);
                    $pedido['nomeFuncionario'] = $func->getNomeFuncionarioByCpf($pedido['cpfResponsavel']);
                    $pedido['itensCarrinho'] = $cart->getItensByIdpedido($pedido['idPedido']);
                    $updatedResults[] = $pedido;
                }
    
                return $updatedResults;
            } else {
                return null;
            }
        }
    
        //Calcula e insere o preço na tabela
        public function atualizarPreco($cpfCliente, $dataDeEntrega, $qtdJogos, $qtdCadeiras, $qtdMesas){
            $order = new Pedido($this->conn);
            $product = new Produto($this->conn);

            $idPedido = $order->getIdPedidoByCpfAndDate($cpfCliente, $dataDeEntrega);
            $precoJogos = $product->getPrecoByProdt('jogo');
            $precoCadeiras = $product->getPrecoByProdt('cadeira');
            $precoMesas = $product->getPrecoByProdt('mesa');
            
            $totalProdts = ($precoJogos*$qtdJogos) + ($precoCadeiras*$qtdCadeiras) + ($precoMesas*$qtdMesas);
    
            //Pedido mínino de R$50,00
            if($totalProdts < 50.00){
                $frete = 50.00 - $totalProdts;
            }else{
                $frete = 0;
            }
    
            $totalPedido = $totalProdts + $frete;
    
            $query = "UPDATE pedido SET preco = ? WHERE idPedido = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("di", $totalPedido, $idPedido);
            $stmt->execute();
        }
    
        //Atualizar o funcionario responsavel
        public function setFunc($cpfFunc, $idPedido) {
            $query = "UPDATE pedido SET cpfResponsavel = ? WHERE idPedido = ?";
            $stmt = $this->conn->prepare($query);
            
            if (!$stmt) {
                return false; 
            }
    
            $stmt->bind_param("si", $cpfFunc, $idPedido);
            return $stmt->execute();
        }
    
        public function atualizarSttsPedido($idPedido){
            $pedido = $this->getPedidoById($idPedido);
    
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
            $stmt = $this->conn->prepare($query);
    
            if (!$stmt) {
                return false; 
            }
    
            $stmt->bind_param("si", $newLabel, $idPedido);
            return $stmt->execute();
        }
    
        public function excluirPedido($idPedido) {
     
            $this->conn->begin_transaction();
        
            try {
               
                $query = "DELETE FROM carrinho WHERE idPedido = ?";
                $stmt = $this->conn->prepare($query);
                
                if (!$stmt) {
                    throw new Exception("Erro ao preparar a exclusão do carrinho.");
                }
        
                $stmt->bind_param("i", $idPedido);
                if (!$stmt->execute()) {
                    throw new Exception("Erro ao executar a exclusão do carrinho.");
                }
    
                $query = "DELETE FROM pedido WHERE idPedido = ?";
                $stmt = $this->conn->prepare($query);
        
                if (!$stmt) {
                    throw new Exception("Erro ao preparar a exclusão do pedido.");
                }
        
                $stmt->bind_param("i", $idPedido);
                if (!$stmt->execute()) {
                    throw new Exception("Erro ao executar a exclusão do pedido.");
                }
        
                $this->conn->commit();
                return true;
        
            } catch (Exception $e) {
                
                $this->conn->rollback();
                return false;
            }
        }
    
        public function getBairroByCpfCliente($cpfCliente){
            $query = "SELECT DISTINCT bairro FROM pedido WHERE cpfCliente = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('s', $cpfCliente);
    
            $stmt->execute();
            $resultados = $stmt->get_result();
    
            $bairros = [];
            while ($row = $resultados->fetch_assoc()) {
                $bairros[] = $row['bairro'];
            }
            return $bairros;
        }
    
        public function getAllBairros(){
            $query = "SELECT DISTINCT bairro FROM pedido";
            $stmt = $this->conn->prepare($query);
    
            $stmt->execute();
            $resultados = $stmt->get_result();
    
            $bairros = [];
            while ($row = $resultados->fetch_assoc()) {
                $bairros[] = $row['bairro'];
            }
            return $bairros;
        }
    
        public function getPedidosFinalizados(){
            $query = "SELECT * FROM pedido WHERE stts = 'finalizado'";
            $stmt = $this->conn->prepare($query);
    
            $stmt->execute();
            $resultados = $stmt->get_result();
            $updatedResults = [];
    
            if (mysqli_num_rows($resultados) > 0){
                while ($pedido = mysqli_fetch_assoc($resultados)) {
                    $client = new Cliente($this->conn);
                    $func = new Funcionario($this->conn);
                    $cart = new Carrinho($this->conn);

                    $pedido['nomeCliente'] = $client->getNomeClienteByCpf($pedido['cpfCliente']);
                    $pedido['nomeFuncionario'] = $func->getNomeFuncionarioByCpf($pedido['cpfResponsavel']);
                    $pedido['itensCarrinho'] = $cart->getItensByIdpedido($pedido['idPedido']);
                    $updatedResults[] = $pedido;
                }
    
                return $updatedResults;
            } else {
                return null;
            }
        }

    }
