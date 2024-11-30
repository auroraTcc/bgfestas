<?php
    class Produto {
        function __construct($conn) {
            $this->conn = $conn;
        }
        private $conn;
        private $idProdt;
        private $nome;
        private $qtdDisp;
        private $qtdTotal;
        private $preco;

        public function getIdProdt() {
            return $this->idProdt;
        }

        public function setIdProdt($idProdt) {
            $this->idProdt = $idProdt;
        }

        // Getter e Setter para nome
        public function getNome() {
            return $this->nome;
        }

        public function setNome($nome) {
            $this->nome = $nome;
        }

        // Getter e Setter para qtdDisp
        public function getQtdDisp() {
            return $this->qtdDisp;
        }

        public function setQtdDisp($qtdDisp) {
            $this->qtdDisp = $qtdDisp;
        }

        // Getter e Setter para qtdTotal
        public function getQtdTotal() {
            return $this->qtdTotal;
        }

        public function setQtdTotal($qtdTotal) {
            $this->qtdTotal = $qtdTotal;
        }

        // Getter e Setter para preco
        public function getPreco() {
            return $this->preco;
        }

        public function setPreco($preco) {
            $this->preco = $preco;
        }

        public function getPrecoByProdt($produto){
            $query = "SELECT preco FROM produto WHERE nome = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('s', $produto);
            
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['preco'];
            }
        }

        public function getProdtNameByProdtId($idProdt){
            $query = "SELECT nome FROM produto WHERE idProdt = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('i', $idProdt);
            
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['nome']; }
        }
    }

