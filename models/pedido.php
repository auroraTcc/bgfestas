<?php
    require "../config/conexao.php";
    class Pedido {
        private $cep;
        private $endereco;
        private $numero;
        private $complemento;
        private $bairro;
        private $data_entrega;
        private $horario_entrega;
        private $data_retirada;
        private $horario_retirada;
        private $cpf_cliente;
        private $contato;


        public function __construct($conn, $cep, $endereco, $numero, $complemento, $bairro, $data_entrega, $horario_entrega, $data_retirada, $horario_retirada, $cpf_cliente, $contato) {
            $this->conn = $conn;
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
            $this->cpf_cliente = $cpf_cliente;
            $this->contato = $contato;
        }

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
            return $this->complemento;
        }
        public function setBairro($bairro){
            $this->bairro = $bairro
        }

        public function getDataEntrega(){
            return $this->data_entrega;
        }
        public function setDataEntrega($data_entrega){
            $this->data_entrega = $data_entrega
        }

        public function getHoraEntrega(){
            return $this->hora_entrega;
        }
        public function setHoraEntrega($hora_entrega){
            $this->hora_entrega = $hora_entrega
        }

        public function getDataRetirada(){
            return $this->data_retirada;
        }
        public function setDataRetirada($data_retirada){
            $this->data_retirada = $data_retirada
        }

        public function getHoraRetirada(){
            return $this->hora_retirada;
        }
        public function setHoraRetirada($hora_retirada){
            $this->hora_retirada = $hora_retirada
        }

        public function getCpfCliente(){
            return $this->cpf_cliente;
        }
        public function setCpfCliente($cpf_cliente){
            $this->cpf_cliente = $cpf_cliente
        }

        public function getContato(){
            return $this->contato;
        }
        public function setContato($contato){
            $this->contato = $contato
        }

    }
?>
