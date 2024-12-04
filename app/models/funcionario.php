<?php
    class Funcionario {
        public function __construct($conn) {
            $this->conn = $conn;
        }            

        public function populate($data) {
            $this->cpf = $data["cpf"];
            $this->nome = $data["nome"];
            $this->email = $data["email"];
            $this->cargo = $data["cargo"];
        }

        private $conn;
        private $cpf;
        private $nome;
        private $email;
        private $cargo;

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

        public function getCargo(){
            return $this->cargo;
        }
        public function setCargo($cargo){
            $this->cargo = $cargo;
        }

        public function setAll($cpf, $nome, $email, $cargo) {
            $this->setCPF($cpf);
            $this->setNome($nome);
            $this->setEmail($email);
            $this->setCargo($cargo);
        }

        public function inserirFuncionario($cpfFunc, $nomeFunc, $emailFunc, $senhaFunc, $cargo){
            $query = "INSERT INTO funcionario (cpf, nome, email, senha, cargo) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('sssss', $cpfFunc, $nomeFunc, $emailFunc, $senhaFunc, $cargo);

            $stmt->execute();

            $stmt->close();
        }

        public function getNomeFuncionarioByCpf($cpfCliente){
            $query = "SELECT nome from funcionario WHERE cpf = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('s', $cpfCliente);
    
            $stmt->execute();
    
            $resultados = $stmt->get_result();
            if ($row = $resultados->fetch_assoc()) {
                return $row['nome'];
            }
        }
    
        public function getFuncionarioByCpf($cpfCliente){
            $query = "SELECT * from funcionario WHERE cpf = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('s', $cpfCliente);
    
            $stmt->execute();
    
            $resultados = $stmt->get_result();
            $funcionario = $resultados->fetch_assoc();
            return $funcionario;
        }
    
        public function getCpfFuncionarioByNome($nome){
            $query = "SELECT cpf from funcionario WHERE nome = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('s', $nome);
    
            $stmt->execute();
    
            $resultados = $stmt->get_result();
            if ($row = $resultados->fetch_assoc()) {
                return $row['cpf'];
            }
        }
    
        public function getAllFuncs(){
            $query =    "SELECT * FROM funcionario 
                        WHERE cpf <> '000.000.000-00' 
                        ORDER BY FIELD(cargo, 'Gerente', 'Administrador', 'Funcionário')";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $resultados = $stmt->get_result();
            $updatedResults = [];
    
            if (mysqli_num_rows($resultados) > 0){
                while ($funcionario = mysqli_fetch_assoc($resultados)) {
                    $updatedResults[] = $funcionario;
                }
    
                return $updatedResults;
            } else {
                return null;
            }
        }
    
        public function deleteFunc($cpf) {
            $query = "DELETE FROM funcionario WHERE cpf = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('s', $cpf);
    
           
            if ($stmt->execute()) {
                $stmt->close(); 
                return true; 
            } else {
                $stmt->close(); 
                return false; 
            }
        }
    
        public function verificarUsuario($cpf, $senha, $isLocal){
            $query = "SELECT * FROM funcionario WHERE cpf = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $cpf);
            $stmt->execute();
            $result = $stmt->get_result();
        
            if($result->num_rows === 1){
                $funcionario = $result->fetch_assoc();
        
                if (password_verify($senha, $funcionario['senha'])) {
                    if (!isset($_SESSION["goTo"]) || $_SESSION["goTo"] === "" || $_SESSION["goTo"] === "/admin/login") {
                        $redirectUrl = $isLocal ? "bgfestas/admin" : "/admin";
                    } else {
                        $redirectUrl = $_SESSION["goTo"];
                    }
                    unset($_SESSION["goTo"]);
                    return ["success" => true, "message" => "Login Realizado com sucesso", "funcionario" => $funcionario, "redirect" => $redirectUrl];
                    
                } else {
                    return [
                        "success" => false,
                        "message" => "Senha incorreta",
                        "funcionario" => ""
                    ];
                }
            }
        
            return ["success" => false, "message" => "Usuário não encontrado", "funcionario" => ""];
        }
    
        public function alterarSenha($cpf, $senha, $isLocal) {
            $query = "UPDATE funcionario SET senha = ?, primAcess = false WHERE cpf = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ss", $senha, $cpf);
            $stmt->execute();


            
            if ($stmt->affected_rows > 0) {
                if (!isset($_SESSION["goTo"]) || $_SESSION["goTo"] === "" || $_SESSION["goTo"] === "/admin/login") {
                    $redirectUrl = $isLocal ? "bgfestas/admin" : "/admin";
                } else {
                    $redirectUrl = $_SESSION["goTo"];
                }
                unset($_SESSION["goTo"]);
                return ["success" => true, "message" => "Senha alterada com sucesso", "redirect" => $redirectUrl];
            } else {
                return ["success" => false, "message" => "Nenhuma alteração feita. Verifique se o CPF está correto."];
            }
        }
    
        public function atualizarCadastroFunc($nome, $email, $cpf) {
            $query = "UPDATE funcionario SET nome = ?, email = ? WHERE cpf = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sss", $nome, $email, $cpf);
            $stmt->execute();
            
            if ($stmt->affected_rows > 0) {
                return ["success" => true, "message" => "Atualização realizada com sucesso"];
            } else {
                return ["success" => false, "message" => "Problemas ao atualizar cadastro."];
            }
        }
        public function resetSenhaPadrao($cpfFunc) {
            $cpfNumbers = preg_replace('/\D/', '', $cpfFunc);
            $senhaPadrao = "PrimeiroAcesso$cpfNumbers";
            $senhaHash = password_hash($senhaPadrao, PASSWORD_DEFAULT);
    
            $checkQuery  = "SELECT * FROM funcionario WHERE cpf = ?";
            $checkStmt = $this->conn->prepare($checkQuery);
            $checkStmt->bind_param("s", $cpfFunc);
            $checkStmt->execute();
            $checkStmt->store_result();
    
            if ($checkStmt->num_rows === 0) {
                return ["success" => false, "message" => "CPF não encontrado."];
            }
        
            $query = "UPDATE funcionario SET senha = ?, primAcess = true WHERE cpf = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ss", $senhaHash, $cpfFunc);
            
            if ($stmt->execute()) {
                return ["success" => true, "message" => "Sua senha foi redefinida para o padrão. Tente logar agora."];
            } else {
                return ["success" => false, "message" => "Ocorreu um erro ao redefinir a senha. Tente novamente."];
            }
        }

    }