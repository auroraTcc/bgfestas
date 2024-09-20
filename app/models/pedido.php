<?php
    require "../config/conexao.php";
    class Pedido {
        function __construct($conn) {
            $this->conn = $conn;
        }
        private $conn;            
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

        public function getCep(){
            return $this->cep;
        }
        public function setCep($cep){
            $this->cep = $cep;
        }

        public function getEndereço(){
            return $this->endereco;
        }
        public function setEndereco($endereco){
            $this->endereco = $endereco;
        }

        public function getNumero(){
            return $this->numero;
        }
        public function setNumero($numero){
            $this->numero = $numero;
        }

        public function getComplemento(){
            return $this->complemento;
        }
        public function setComplemento($complemento){
            $this->complemento = $complemento;
        }

        public function getBairro(){
            return $this->bairro;
        }
        public function setBairro($bairro){
            $this->bairro = $bairro;
        }

        public function getCidade(){
            return $this->cidade;
        }
        public function setCidade($cidade){
            $this->cidade = $cidade;
        }

        public function getDataEntrega(){
            return $this->dataEntg;
        }
        public function setDataEntrega($dataEntg){
            $this->dataEntg = $dataEntg;
        }

        public function getHoraEntrega(){
            return $this->horaEntg;
        }
        public function setHoraEntrega($horaEntg){
            $this->horaEntg = $horaEntg;
        }

        public function getDataRet(){
            return $this->dataRet;
        }
        public function setDataRetirada($dataRet){
            $this->dataRet = $dataRet;
        }

        public function getHoraRetirada(){
            return $this->horaRet;
        }
        public function setHoraRetirada($horaRet){
            $this->horaRet = $horaRet;
        }

        public function getCpfCliente(){
            return $this->cpfCliente;
        }
        public function setCpfCliente($cpfCliente){
            $this->cpfCliente = $cpfCliente;
        }

        public function getTelefone(){
            return $this->telefone;
        }
        public function setTelefone($telefone){
            $this->telefone = $telefone;
        }


        public function inserirPedido($cep, $endereco, $numero, $complemento, $bairro, $cidade, $dataEntg, $horaEntg, $dataRet, $horaRet, $cpfCliente, $telefone) {
            $query = "INSERT INTO pedido(cep, endereco, numero, complemento, bairro, cidade, dataEntg, horaEntg, dataRet, horaRet, cpfCliente, telefone) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ssisssssssss', $cep, $endereco, $numero, $complemento, $bairro, $cidade, $dataEntg, $horaEntg, $dataRet, $horaRet, $cpfCliente, $telefone);

            $stmt->execute();
            /* if ($stmt->execute()) {
                header("Location: /bgfestas/fazerpedido/sucesso"); //PARA HOMOLOGAR: RETIRAR O '/BGFESTAS'
                exit(); 
            } else {
                header("Location: /bgfestas/fazerpedido/erro"); //PARA HOMOLOGAR: RETIRAR O '/BGFESTAS'
            } */

            $stmt->close();
        }

    }
