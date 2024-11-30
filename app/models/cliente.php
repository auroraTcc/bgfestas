<?php
    class Cliente {
        function __construct($conn) {
            $this->conn = $conn;
        }            

        private $conn;
        private $nome;
        private $cpf;
        private $contato;

        public function getCPF(){
            return $this->cpf;
        }
        public function setCPF($cpf){
            $this->cpf = $cpf;
        }

        public function getNome(){
            return $this->nome;
        }
        public function setNome($nome){
            $this->nome = $nome;
        }

        public function getContato(){
            return $this->contato;
        }
        public function setContato($contato){
            $this->contato = $contato;
        }

        public function inserirCliente($conn, $cpfCliente, $nome, $telefone) {

            $query = "SELECT * from cliente WHERE cpf = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $cpfCliente);

            $stmt->execute();

            $resultados = $stmt->get_result();

            if($resultados->num_rows == 0 ){
                $query = "INSERT INTO cliente (cpf, nome, telefone) VALUES (?, ?, ?)";
                $stmt = $this->conn->prepare($query);
                $stmt->bind_param('sss', $cpfCliente, $nome, $telefone);

                $stmt->execute();

                $stmt->close();
            }
        }

        public function getAllClientes(){
            $query = "SELECT * from cliente";
            $stmt = $this->conn->prepare($query);
        
            $stmt->execute();
        
            $resultados = $stmt->get_result();
            $updatedResults = [];
        
                if (mysqli_num_rows($resultados) > 0){
                    while ($cliente = mysqli_fetch_assoc($resultados)) {
                        $updatedResults[] = $cliente;
                    }
        
                    return $updatedResults;
                } else {
                    return null;
                }
        }
            public function getNomeClienteByCpf($cpfCliente){
                $query = "SELECT nome from cliente WHERE cpf = ?";
                $stmt = $this->conn->prepare($query);
                $stmt->bind_param('s', $cpfCliente);
        
                $stmt->execute();
        
                $resultados = $stmt->get_result();
                if ($row = $resultados->fetch_assoc()) {
                    return $row['nome'];
                }
            }
        
            public function getClienteByCpf($cpfCliente){
                $query = "SELECT * from cliente WHERE cpf = ?";
                $stmt = $this->conn->prepare($query);
                $stmt->bind_param('s', $cpfCliente);
        
                $stmt->execute();
                $resultados = $stmt->get_result();
                if (mysqli_num_rows($resultados) > 0){
                    while ($cliente = mysqli_fetch_assoc($resultados)) {
                        $updatedResults = $cliente;
                    }
        
                    return $updatedResults;
                } else {
                    return null;
                }
        
        
            }
    }
