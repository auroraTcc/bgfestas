<?php
class Carrinho{
    function __construct($conn){
        $this->conn = $conn;
    }

    public function populate($data) {
        $this->idItem = $data['idItem'] ?? "";
        $this->idPedido = $data['idPedido'];
        $this->idProdt = $data['idProdt'];
        $this->quantidade = $data['quantidade'];
        $this->nome = $data['nome'] ?? "";
        $this->preco = $data['preco'] ?? "";
    }
    
    private $conn;
    private $idItem;
    private $idPedido;
    private $idProdt;
    private $quantidade;
    private $nome;
    private $preco;

    public function getIdItem() {
        return $this->idItem;
    }
    public function setIdItem($idItem) {
        $this->idItem = $idItem;
    }
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
    public function getNome()
    {
        return $this->nome;
    }
    public function setNome($nome) {
        $this->nome = $nome;
    }
    public function getPreco()
    {
        return $this->preco;
    }
    public function setPreco($preco) {
        $this->preco = $preco;
    }
    

    function getItensByIdpedido($idPedido){
        $query = "SELECT * from carrinho WHERE idPedido = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $idPedido);

        $stmt->execute();

        $resultados = $stmt->get_result();
        $carrinho = [];
        if(mysqli_num_rows($resultados)) {
            while ($item = $resultados->fetch_assoc()) {  
                $prod = new produto($this->conn);

                $item['nome'] = $prod->getProdtNameByProdtId( $item['idProdt']);
                $item['preco'] = $prod->getPrecoByProdt($item['nome']);
                $carrinho[] = $item;
            }
            return $carrinho;
        }
    }
    public function inserirCarrinho($produto, $quantidade, $cpfCliente, $dataDeEntrega){
        //consulta id pedido
        $idProdt = 0;

        $pedido = new Pedido($this->conn);
        $idPedido = $pedido->getIdPedidoByCpfAndDate($cpfCliente, $dataDeEntrega);

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