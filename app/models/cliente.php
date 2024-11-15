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
    }
