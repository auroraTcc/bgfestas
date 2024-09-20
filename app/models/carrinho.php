<?php
require "../config/conexao.php";
require "../actions/pedido.php";

class Carrinho{
    function __construct($conn)
    {
        $this->conn = $conn;
    }
    private $conn;
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

    public function inserirCarrinho($produto, $quantidade, $cpfCliente, $dataDeEntrega){
        //consulta id pedido
        $idProdt = 0;
        $idPedido = getIdPedidoByCpfAndDate($this->conn, $cpfCliente, $dataDeEntrega);

        //consulta id prodt
        $query = "SELECT idProdt from produto WHERE nome = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $produto);

        $stmt->execute();

        $resultados = $stmt->get_result();
        if ($row = $resultados->fetch_assoc()) {
            $idProdt = $row['idProdt'];
        }

        //inserção
        $query = "INSERT INTO carrinho (idPedido, idProdt, quantidade) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('iii', $idPedido, $idProdt, $quantidade);

        $stmt->execute();
    }

}
?>