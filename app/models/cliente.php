<?php
    require "../config/conexao.php";
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

        public function inserirCliente($cpfCliente, $nome, $telefone) {
            // $query_check = "SELECT cpf FROM cliente WHERE cpf = ? AND WHERE bairro = ?";
            // $stmt_check = $this->conn->prepare($query_check);
            // $stmt_check->bindParam('s', $this->cpf);
            // $stmt_check->execute();
            // if ($stmt_check->rowCount() == 0) {
            //     // Se o cliente não existe, faz a inserção
                
            // } else {
            //     // Se o cliente já existe, não faz inserção e retorna verdadeiro
            //     return true;
            // }

            $query = "INSERT INTO cliente (cpf, nome, telefone) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);

            $stmt = $this->conn->prepare($query);
            
            if (!$stmt) {
                die("Erro na preparação da query: " . $this->conn->error);
            }

            $stmt->bind_param('sss', $cpfCliente, $nome, $telefone);

            $stmt->execute();

            $stmt->close();
        }
    }

