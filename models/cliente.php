<?php
    class Cliente {
        private $conn;
        private $nome;
        private $cpf;
        private $telefone;

        public function __construct($conn, $nome, $cpf, $telefone) {
            $this->conn = $conn;
            $this->nome = $nome;
            $this->cpf = $cpf;
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
