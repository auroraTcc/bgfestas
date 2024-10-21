<?php

    require "../../../../config/isLogged.php";

    if (!$isLogged) {
        header("Location: /bgfestas/app/view/admin/login"); //TODO: DEPLOY: TROCAR PARA /app/view/admin/login
    }

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
            href="../../../../../public/assets/css/admin.css"
        />
        <script src="../../../../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script
            src="https://kit.fontawesome.com/4c0a49f720.js"
            crossorigin="anonymous"
        ></script>
        <script src="../../../../../node_modules/jquery/dist/jquery.min.js"></script>
        <link
            rel="shortcut icon"
            href="/public/assets/imgs/favicon.ico"
            type="image/x-icon"
        />
        <script src="../../../../../node_modules/@iconfu/svg-inject/dist/svg-inject.min.js"></script>
        <style>
            .item-titles {
                display: grid;
                gap: 0.5rem;
                grid-template-columns: 4rem auto;
            }
        </style>
    </head>
    <body>
        <header class="border-bottom border-primary">
            <div class="container">
                <button
                    class="btn"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#navbar"
                    aria-controls="navbar"
                >
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-circle-user fs-5"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <button id="logOutBtn" class="btn d-flex align-items-center gap-2">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                Sair
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <div
            class="offcanvas offcanvas-start"
            tabindex="-1"
            id="navbar"
            aria-labelledby="navbarLabel"
        >
            <div class="offcanvas-header">
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="offcanvas"
                    aria-label="Close"
                ></button>
            </div>
            <nav class="offcanvas-body">
                <div>
                    <h6>Geral</h6>
                    <ul>
                        <li>
                            <a href="../../../../../../app/view/admin">
                                <i class="fa-solid fa-chart-gantt"></i>
                                <span>Painel de Controle</span>
                            </a>
                        </li>
                        <li>
                            <a href="../../../../../app/view/admin/tarefas">
                                <i class="fa-regular fa-folder-open"></i>
                                <span>Tarefas</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h6>Admin</h6>
                    <ul>
                        <li>
                            <a
                                href="../../../../../app/view/admin/funcionarios"
                            >
                                <i class="fa-regular fa-id-badge"></i>
                                <span>Funcionários</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <main class="container" data-type="entrega">
            <section
                class="d-flex flex-column-reverse gap-3 flex-md-row justify-content-between align-md-items-center align-items-start"
            >
                <div>
                    <?php 
                        require_once "../../../../../app/config/conexao.php";
                        require_once "../../../../../app/actions/pedido.php"; 
                        $idPedido = $_GET['id'];
                        $resultados = getPedidoById($conn, $idPedido);
                        
                        if ($resultados) {
                            foreach ($resultados as $pedido) {

                                $dataHora = $pedido["data{$abbreviations[$pedido['stts']]}"] . ' ' . $pedido["hora{$abbreviations[$pedido['stts']]}"];
                                $dateTime = new DateTime($dataHora);
                                $formattedDate = $dateFormatter->format($dateTime);
                                $formattedTime = $dateTime->format('H:i') . 'h';
                                $pedido['subtotal'] = 0;
                                $pedido['frete'] = 0;
                                $pedido['total'] = 0;

                                ?>

                    <h3><?=$pedido['nomeCliente']?></h3>
                    <div class="d-flex flex-column gap-2">
                        <p class="d-flex align-items-center gap-2 mb-0">
                            <i class="fa-regular fa-calendar"></i><?=$formattedDate?> <?=$formattedTime?>
                        </p>
                        <p class="d-flex align-items-center gap-2 mb-0">
                            <i class="fa-solid fa-map-pin"></i><?=$pedido['endereco']?>, <?=$pedido['numero']?> <?php if($pedido['complemento']) {echo ", ". $pedido['complemento']; } ?> - <?=$pedido['bairro']?> - <?=$pedido['cidade']?>
                        </p>
                        <p class="d-flex align-items-center gap-2 mb-0">
                            <i class="fa-solid fa-circle-user"></i
                            ><select
                                class="form-select"
                                aria-label="Default select example"
                            >
                                <?php
                                    require_once "../../../../config/conexao.php";

                                    $resultados = getAllFuncs($conn);

                                if ($resultados) {
                                    foreach ($resultados as $funcionario) {
                                ?>
                                <option value="<?=$funcionario['cpf']?>"> <?=$funcionario['nome'];?></option><?php
                                    };
                                }?>
                                
                            </select>
                        </p>
                    </div>
                </div>
                <span
                    class="badge bg-primary text-bg-secondary rounded-pill fs-6 fw-normal lh-base ps-4 pe-4"
                >
                    <?=$pedido['stts']?>
                </span>
            </section>

            <section class="border shadow-sm rounded">
                <div class="p-3 border-bottom">
                    <h4>Produtos</h4>
                </div>
                <div class="p-3 d-flex flex-column gap-3">
                    <?php
                    foreach($pedido['itensCarrinho'] as $item) { 
                        $pedido['subtotal'] = $pedido['subtotal'] + $item['preco'] * $item['quantidade'];
                        ?>
                    <div
                        class="d-flex justify-content-between align-items-center"
                    >
                        <div class="item-titles align-items-center">
                            <!-- FORMATAR AS IMAGENS -->
                            <div class="d-flex justify-content-center">
                                <img
                                    src="../../../../../public/assets/imgs/<?=$item['nome']?>.svg"
                                    onload="SVGInject(this)"
                                    class="text-primary"
                                    height="2rem"
                                />
                            </div>
                            <h5 class="text-secondary-color"><?=$item["nome"]?></h5>
                        </div>
                        <div class="d-flex gap-1 align-items-center">
                            <p class="mb-0"><?=$item["quantidade"]?> x <?=$item["preco"]?> =</p>
                            <p class="fw-bold mb-0">R$ <?=$item["quantidade"]*$item["preco"]?>,00</p> 
                            <!-- FORMATAR EM REAL -->
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
                    if($pedido['subtotal'] < 50.00){
                        $pedido['frete'] = 50.00 - $pedido['subtotal'];
                    }else{
                        $pedido['frete'];
                    }
                    }
                ?>
                <div class="p-3 d-flex flex-column gap-3">
                    <div>
                        <div class="d-flex justify-content-between pb-1">
                            <span>Subtotal</span>
                            <span>R$ <?=$pedido['subtotal']?></span>
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <span>Frete</span>
                            <span>R$ <?=$pedido['frete']?></span>
                        </div>
                        <div
                            class="d-flex justify-content-between border-top border-primary pt-3 pb-3"
                        >
                            <strong>Total</strong>
                            <strong>R$ <?=$pedido['subtotal']+$pedido['frete']?></strong>
                        </div>
                    </div>
                </div>
            </section>

            <section
                class="d-md-flex text-center justify-content-between align-items-center border shadow-sm rounded p-3"
            >
                <p class="mb-0">
                    Receba o pagamento antes de prosseguir com a entrega
                </p>
                <button class="btn btn-primary ms-auto">
                    Confirmar Pagamento
                </button>

                <?php
                      }
                ?>

            </section>
        </main>
    </body>
</html>
