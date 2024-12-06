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
<html lang="pt-br">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Pedido</title>
        <link
            rel="stylesheet"
            href="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/css/admin.css"
        />
        <script src="<?=$isLocal ? "/bgfestas" : ""?>/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script
            src="https://kit.fontawesome.com/4c0a49f720.js"
            crossorigin="anonymous"
        ></script>
        <script src="<?=$isLocal ? "/bgfestas" : ""?>/node_modules/jquery/dist/jquery.min.js"></script>
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
            $idPedido = $_GET['id'];
            $pedido = new Pedido($conn);
        
            $resultado =  $pedido->getPedidoById( $idPedido);

            if (!$resultado) {
                ?>
                    <main class="container h-100 d-flex align-items-center justify-content-center">
                        <h2>Pedido não encontrado</h2>
                    </main>
                <?php return;
            }
        
            $resultado= $resultado[0];
            $pedido->populate($resultado);
        ?>
        

        <?php
            if ($pedido->getStts() === "finalizado") {
                
                ?>
                    <main class="container h-100 d-flex align-items-center justify-content-center">
                        <h2>Esse pedido já está finalizado</h2>
                    </main>
                <?php return;
            }
        ?>

        <?php 
            if (!isset($abbreviations[$pedido->getStts()])) {
                throw new Exception("Status inválido");
            }
        ?>

        

        <main class="container" data-type=<?=$pedido->getStts()?>>
            <section
                class="d-flex flex-column-reverse gap-3 flex-md-row justify-content-between align-md-items-center align-items-start"
            >
                <div>
                    <?php
                       
                       echo "<script>const pedido = " . json_encode($resultado) . ";</script>";
                            $dataHora = $resultado["data{$abbreviations[$resultado['stts']]}"] . ' ' . $resultado["hora{$abbreviations[$resultado['stts']]}"];
                            try {
                                $dateTime = new DateTime($dataHora);
                            } catch (Exception $e) {
                                echo "Erro ao processar a data: " . $e->getMessage();
                                return;
                            }
                            $formattedDate = $dateFormatter->format($dateTime);
                            $formattedTime = $dateTime->format('H:i') . 'h';
                            $subtotal = 0;
                            $frete = 0;
                            $total = 0;
                    ?>

                    <h3><?=$pedido->getNomeCliente()?></h3>
                    <div class="d-flex flex-column gap-2">
                        <p class="d-flex align-items-center gap-2 mb-0">
                            <i class="fa-regular fa-calendar"></i><?=$formattedDate?> <?=$formattedTime?>
                        </p>
                        <p class="d-flex align-items-center gap-2 mb-0">
                            <i class="fa-solid fa-map-pin"></i><?=$pedido->getEndereco()?>, <?=$pedido->getNumero()?> <?php if($pedido->getComplemento()) {echo ", ". $pedido->getComplemento(); } ?> - <?=$pedido->getBairro()?> - <?=$pedido->getCidade()?>
                        </p>
                        <p class="d-flex align-items-center gap-2 mb-0">
                            <i class="fa-solid fa-circle-user"></i>
                            <?php
                                if($user->getCargo() === "Gerente"
                                ||
                                $user->getCargo() === "Administrador") {
                                    ?>
                                    <select
                                            class="form-select"
                                            id="selectFunc"
                                            aria-label="Default select example"
                                        >
                                            <?php
                                                $func = new Funcionario($conn);
                                                $resultados = $func->getAllFuncs();

                                            if ($resultados) {
                                                foreach ($resultados as $funcionario) {
                                                $func->populate($funcionario);
                                            ?>
                                            <option value="<?=$func->getCPF()?>" <?php
                                                if ($pedido->getCpfResponsavel() === $func->getCPF()) {
                                                    echo "selected";
                                                }
                                            ?>> <?=$func->getNome();?></option><?php
                                                };
                                            }?>
                                            
                                        </select>
                                    <?php
                                } else {
                                    $funcionario = $func->getNomeFuncionarioByCpf($pedido->getCpfResponsavel());

                                    echo $funcionario;
                                }
                            ?>
                        </p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-6">
                    <span
                        class="badge bg-main text-bg-main rounded-pill fs-6 fw-normal lh-base ps-4 pe-4"
                    >
                        <?=$pedido->getStts()?>
                    </span>
                    <button id="deleteBtn" class="btn"><i class="fa-solid fa-trash"></i> Deletar Pedido</button>
                </div>
            </section>

            <section class="border shadow-sm rounded">
                <div class="p-3 border-bottom">
                    <h4>Produtos</h4>
                </div>
                <div class="p-3 d-flex flex-column gap-3">
                    <?php
                    foreach($pedido->getItensCarrinho() as $item) { 
                        $produto = new Carrinho($conn);
                        $produto->populate($item);
                        $subtotal += $produto->getPreco() * $produto->getQuantidade();
                    ?>
                    <div
                        class="d-flex justify-content-between align-items-center"
                    >
                        <div class="item-titles align-items-center">
                            <div class="d-flex justify-content-center">
                                <img
                                    src="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/imgs/<?=$produto->getNome()?>.svg"
                                    onload="SVGInject(this)"
                                    class="text-main"
                                    height="2rem"
                                    fill="currentColor"
                                />
                            </div>
                            <h5 class="text-secondary-color"><?=$produto->getNome()?></h5>
                        </div>
                        <div class="d-flex gap-1 align-items-center">
                            <p class="mb-0"><?=$produto->getQuantidade()?> x <?=number_format($produto->getPreco(), 2, ',', '.') ?> =</p>
                            <p class="fw-bold mb-0">R$ <?=number_format($produto->getQuantidade() * $produto->getPreco(), 2, ',', '.') ?></p> 
                        </div>
                    </div>
                    <?php 
                        } ?>
                </div>
            </section>

            <section class="border shadow-sm rounded">
                <div class="p-3 border-bottom">
                    <h4>Pagamento</h4>
                </div>
                <?php
                    $frete = $subtotal >= 50 ? 0 : 50 - $subtotal;

                    $subtotalFormatted = number_format($subtotal, 2, ',', '.');
                    $freteFormatted = number_format($frete, 2, ',', '.');

                    $total = $subtotal + $frete;
                    $totalFormatted = number_format($total, 2, ',', '.');
                
                ?>
                <div class="p-3 d-flex flex-column gap-3">
                    <div>
                        <div class="d-flex justify-content-between pb-1">
                            <span>Subtotal</span>
                            <span>R$ <?=$subtotalFormatted?></span>
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <span>Frete</span>
                            <span>R$ <?=$freteFormatted?></span>
                        </div>
                        <div class="d-flex justify-content-between border-top border-main pt-3 pb-3">
                            <strong>Total</strong>
                            <strong>R$ <?=$totalFormatted?></strong>
                        </div>
                    </div>
                </div>
            </section>

            <section
                class="d-md-flex text-center justify-content-between align-items-center border shadow-sm rounded p-3"
            >
                <p class="mb-0">
                    <?php
                        if ($pedido->getStts() === "entrega") {
                            echo "Receba o pagamento antes de prosseguir com a entrega";
                        } else {
                            echo "Verifique a condição dos itens antes de prosseguir com a retirada";
                        }
                    ?>
                    
                </p>
                <button id="confirmBtn" class="btn btn-main ms-auto">
                    <?php
                        if ($pedido->getStts() === "entrega") {
                            echo "Confirmar Pagamento";
                        } else {
                            echo "Confirmar retirada";
                        }
                    ?>
                </button>
            </section>
        </main>

        <script>
            $("#deleteBtn").on("click", function () {
                const idPedido = pedido.idPedido;

                if (confirm("Tem certeza de que deseja excluir este pedido?")) {
                    $.ajax({
                    url: "<?=$isLocal ? "/bgfestas" : ""?>/controllers/processDeletePedido",
                    type: "POST",
                    dataType: "json",
                    data: { pedido: idPedido },
                    success: function (response) {
                        if (response.success) {
                            window.location.href = "<?=$isLocal ? "/bgfestas" : ""?>/admin";
                        } else {
                            console.log("Falha ao alterar as coisas:", response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log("Erro ao processar a solicitação:", error);
                    },
                });
                }
            })

            $("#confirmBtn").on("click", function () {
                const idPedido = pedido.idPedido;

                $.ajax({
                    url: "<?=$isLocal ? "/bgfestas" : ""?>/controllers/processAtualizarStatusDoPedido",
                    type: "POST",
                    dataType: "json",
                    data: { pedido: idPedido },
                    success: function (response) {
                        if (response.success) {
                            window.location.href = "<?=$isLocal ? "/bgfestas" : ""?>/admin";
                        } else {
                            console.log("Falha ao alterar as coisas:", response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log("Erro ao processar a solicitação:", xhr);
                    },
                });
            });

            $("#selectFunc").on("change", function () {
                const cpf = $(this).val();
                const idPedido = pedido.idPedido;

                $.ajax({
                    url: "<?=$isLocal ? "/bgfestas" : ""?>/controllers/processAlterarFuncResponsavel",
                    type: "POST",
                    dataType: "json",
                    data: { cpf: cpf, pedido: idPedido },
                    success: function (response) {
                        if (response.success) {
                            console.log("Alteração realizada com sucesso");
                        } else {
                            console.log("Falha ao alterar o responsável");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log("Erro ao processar a solicitação:", error);
                    },
                });
            })
        </script>
    </body>
</html>
