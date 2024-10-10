<?php
    require "../config/conexao.php";
    class Funcionario {
        function __construct($conn) {
            $this->conn = $conn;
        }            

        private $conn;
        private $cpf;
        private $nome;
        private $email;

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

        public function getEmail(){
            return $this->email;
        }
        public function setEmail($email){
            $this->email = $email;
        }

        public function inserirFuncionario($cpfFunc, $nomeFunc, $emailFunc, $senhaFunc, $cargo){
            $query = "INSERT INTO funcionario (cpf, nome, email, senha, cargo) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('sssss', $cpfFunc, $nomeFunc, $emailFunc, $senhaFunc, $cargo);

            $stmt->execute();

            $stmt->close();
        }

    }