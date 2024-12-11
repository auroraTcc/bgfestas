<?php
    $abbreviations = [
        "entrega" => "Entg",
        "retirada" => "Ret"
    ];

    
    setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'pt_BR.utf8');
    $dateFormatter = new IntlDateFormatter(
        'pt_BR', 
        IntlDateFormatter::LONG, 
        IntlDateFormatter::NONE 
    );
    $dateFormatter->setPattern('dd MMM');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tarefas finalizadas</title>
        <link
            rel="stylesheet"
            href="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/css/admin.css"
        />
        <script src="<?=$isLocal ? "/bgfestas" : ""?>/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script
            src="https://kit.fontawesome.com/4c0a49f720.js"
            crossorigin="anonymous"
        ></script>
        <script src="/node_modules/jquery/dist/jquery.min.js"></script>
        <link
            rel="shortcut icon"
            href="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/imgs/favicon.ico"
            type="image/x-icon"
        />
        <script src="<?=$isLocal ? "/bgfestas" : ""?>/node_modules/@iconfu/svg-inject/dist/svg-inject.min.js"></script>
        <style>
            .item-titles {
                display: grid;
                gap: 0.5rem;
                grid-template-columns: 4rem auto;
            }
        </style>
    </head>
    <body>
        <?php
            include_once "$rootPath/app/components/header.php";
        ?>

            <?php
                ;
            ?>

        <?php
           if ($user->getCargo() !== "Gerente" && $user->getCargo() !== "Administrador") {
                ?>
                    <main class="container h-100 d-flex align-items-center justify-content-center">

                        <h2>Você não tem permissão para acessar essa página.</h2>
                    </main>
                <?php
                exit;
            }
        ?>

        <main>
            <section class="container">
                <div
                    class="d-md-flex container align-items-center justify-content-between mb-4"
                >
                    <div class="title-container">
                        <h2>Pedidos Concluídos</h2>
                        <p class="mb-2">
                            Nesta página, você pode visualizar os pedidos que já foram cluídos,
                            criar e enviar recibos, conforme necessário
                        </p>
                    </div>

                   
                </div>

                <?php
                    $order = new Pedido($conn);
                    $pedidos = $order->getPedidosFinalizados();

                    if (!$pedidos) {
                        ?>
                            <div class="container">
                                <h3>Ainda Não Há Nenhum Pedido Finalizado</h3>
                            </div>
                        
                        <?php
                        return;
                    }
                ?>
                

                <div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="table-light">
                                    <th scope="col">#</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Data de conclusão</th>
                                    <th scope="col">Endereço</th>
                                    <th scope="col">Preço total</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    foreach ($pedidos as $order) {
                                        $pedido = new Pedido($conn);
                                        $pedido->populate($order);

                                        $subtotal = 0;
                                        $frete = 0;
                                        $total = 0;
                                       
                                        foreach($pedido->getItensCarrinho() as $item) { 
                                            $produto = new Carrinho($conn);
                                            $produto->populate($item);
                                            $subtotal += $produto->getPreco() * $produto->getQuantidade();
                                        }

                                        $frete = $subtotal >= 50 ? 0 : 50 - $subtotal;
                                        $total = $subtotal + $frete;
                                        
                                        $totalFormatted = number_format($total, 2, ',', '.');
                                        $dataRetOriginal = $pedido->getDataRetirada();
                                        $dataRetFormatada = (new DateTime($dataRetOriginal))->format('d/m/Y');
                                
                                ?>
                                        <tr>
                                            <th scope="row"><?=$i?></th>
                                            <td><?=$pedido->getNomeCliente()?></td>
                                            <td><?=$dataRetFormatada?></td>
                                            <td><?=$pedido->getEndereco()?>, <?=$pedido->getNumero()?> <?php if($pedido->getComplemento()) {
                                                        echo ", ". $pedido->getComplemento();
                                                    } ?> - <?=$pedido->getBairro()?> - <?=$pedido->getCidade()?></td>
                                            <td>R$ <?=$totalFormatted?></td>
                                            <td>
                                                <a  style="text-decoration: none;"
                                                    href="<?=$isLocal ? "/bgfestas" : ""?>/recibo/<?=$pedido->getIdPedido()?>"
                                                    target="_blank"
                                                    class="badge bg-primary text-bg-secondary rounded-pill"
                                                >gerar recibo</a>
                                                <a  href="https://api.whatsapp.com/send?phone=55<?=$pedido->getTelefone()?>&text=Olá%20<?=$pedido->getNomeCliente()?>!%20Sou%20o%20Gilson,%20gerente%20da%20BGFESTAS.%20Recentemente%20você%20fez%20um%20pedido%20conosco%20e%20gostaria%20de%20falar%20contigo."
                                                    class="badge bg-primary text-bg-secondary rounded-pill"
                                                    style="width: fit-content; text-decoration: none"
                                                    target="_blank"
                                                >
                                                    Enviar Mensagem
                                                </a>
                                            </td>
                                        </tr>
                                <?php
                                        $i++;    
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>