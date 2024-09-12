<?php
    require "../config/conexao.php"
    class Cliente {
        private $nome;
        private $cpf;
        private $telefone;

        public function getNome(){
            return $this->nome;
        }
        public function setNome($nome){
            $this->nome = $nome;
        }

        public function getCPF(){
            return $this->cpf;
        }
        public function setCPF($cpf){
            $this->cpf = $cpf;
        }

        public function getTelefone(){
            return $this->telefone;
        }
        public function setTelefone($telefone){
            $this->telefone = $telefone;
        }

        public function inserirCliente() {
            // Verifica se o cliente já existe no banco de dados
            $query_check = "SELECT cpf FROM cliente WHERE cpf = :cpf";
            $stmt_check = $this->conn->prepare($query_check);
            $stmt_check->bindParam(':cpf', $this->cpf);
            $stmt_check->execute();

            if ($stmt_check->rowCount() == 0) {
                // Se o cliente não existe, faz a inserção
                $query = "INSERT INTO cliente (cpf, nome, telefone) VALUES (:cpf, :nome, :telefone)";
                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(':cpf', $this->cpf);
                $stmt->bindParam(':nome', $this->nome);
                $stmt->bindParam(':telefone', $this->telefone);

                return $stmt->execute();
            } else {
                // Se o cliente já existe, não faz inserção e retorna verdadeiro
                return true;
            }
        }
    }
?>
