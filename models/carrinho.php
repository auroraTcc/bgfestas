<?php
require_once "../config/conexao.php";

class Carrinho
{
    function __construct($conn)
    {
        $this->conn = $conn;
    }
    private $idPedido;
    private $idProdt;
    private $quantidade;

    public function getIdPedido()
    {
        return $this->idPedido;
    }
    public function setIdPedido($idPedido)
    {
        $this->IdPedido = $idPedido;
    }

    public function getIdProdt()
    {
        return $this->idProdt;
    }
    public function setIdProdt($idProdt)
    {
        $this->IdProdt = $idProdt;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
    }

}
?>