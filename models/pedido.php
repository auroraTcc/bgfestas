<?php
    class Pedido {
        private $conn;
        private $cpf_cliente;
        private $cep;
        private $endereco;
        private $numero;
        private $complemento;
        private $bairro;
        private $cidade;
        private $estado;
        private $data_entrega;
        private $horario_entrega;
        private $data_retirada;
        private $horario_retirada;
        private $quantidade;

        public function __construct($conn, $cpf_cliente, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $data_entrega, $horario_entrega, $data_retirada, $horario_retirada, $quantidade) {
            $this->conn = $conn;
            $this->cpf_cliente = $cpf_cliente;
            $this->cep = $cep;
            $this->endereco = $endereco;
            $this->numero = $numero;
            $this->complemento = $complemento;
            $this->bairro = $bairro;
            $this->cidade = $cidade;
            $this->estado = $estado;
            $this->data_entrega = $data_entrega;
            $this->horario_entrega = $horario_entrega;
            $this->data_retirada = $data_retirada;
            $this->horario_retirada = $horario_retirada;
            $this->quantidade = $quantidade;
        }

        public function inserirPedido() {
            $query = "INSERT INTO pedido (cpf_cliente, cep, endereco, numero, complemento, bairro, cidade, estado, data_entrega, horario_entrega, data_retirada, horario_retirada, quantidade) 
                    VALUES (:cpf_cliente, :cep, :endereco, :numero, :complemento, :bairro, :cidade, :estado, :data_entrega, :horario_entrega, :data_retirada, :horario_retirada, :quantidade)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':cpf_cliente', $this->cpf_cliente);
            $stmt->bindParam(':cep', $this->cep);
            $stmt->bindParam(':endereco', $this->endereco);
            $stmt->bindParam(':numero', $this->numero);
            $stmt->bindParam(':complemento', $this->complemento);
            $stmt->bindParam(':bairro', $this->bairro);
            $stmt->bindParam(':cidade', $this->cidade);
            $stmt->bindParam(':estado', $this->estado);
            $stmt->bindParam(':data_entrega', $this->data_entrega);
            $stmt->bindParam(':horario_entrega', $this->horario_entrega);
            $stmt->bindParam(':data_retirada', $this->data_retirada);
            $stmt->bindParam(':horario_retirada', $this->horario_retirada);
            $stmt->bindParam(':quantidade', $this->quantidade);

            return $stmt->execute();
        }
    }
?>
