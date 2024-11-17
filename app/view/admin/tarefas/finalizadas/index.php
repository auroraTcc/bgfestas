<?php

    require "../../../../config/isLogged.php";
    require_once "../../../../config/conexao.php";


    if (!$isLogged) {
        header("Location: /bgfestas/app/view/admin/login"); 
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


    require_once "../../../../../app/config/conexao.php";
    require_once "../../../../../app/actions/pedido.php"; 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tarefas finalizadas</title>
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
                            <button id="logOutBtn" class="btn d-flex align-items-center gap-2 w-100">
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
                            <a href="../../../../../app/view/admin">
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
                <?php
                    if ($_SESSION['funcionario']['cargo'] === "Gerente"
                            ||
                        $_SESSION['funcionario']['cargo'] === "Administrador") {
                        ?>
                            <div>
                                <h6>Admin</h6>
                                <ul>
                                    <li>
                                        <a href="../../../../../app/view/admin/funcionarios">
                                            <i class="fa-regular fa-id-badge"></i>
                                            <span>Funcionários</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../../../../../app/view/admin/tarefas/finalizadas">
                                            <i class="fa-regular fa-square-check"></i>
                                            <span>Tarefas Finalizadas</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../../../../../app/view/admin/clientes">
                                            <i class="fa-regular fa-address-card"></i>
                                            <span>Clientes</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        <?php
                    }
                ?>
                
            </nav>
        </div>

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
                                    $pedidos = getPedidosFinalizados($conn);
                                    foreach ($pedidos as $pedido) {
                                        $i = 1;
                                        $pedido['subtotal'] = 0;
                                        foreach($pedido['itensCarrinho'] as $item) { 
                                            $pedido['subtotal'] = $pedido['subtotal'] + $item['preco'] * $item['quantidade'];
                                        }
                                        
                                        if ($pedido['subtotal'] < 50.00) {
                                            $pedido['frete'] = 50.00 - $pedido['subtotal'];
                                        } else {
                                            $pedido['frete'] = 0;
                                        }
                                        $total = $pedido['subtotal'] + $pedido['frete'];
                                        $totalFormatted = number_format($total, 2, ',', '.');
                                ?>
                                        <tr>
                                            <th scope="row"><?=$i?></th>
                                            <td><?=$pedido["nomeCliente"]?></td>
                                            <td><?=$pedido["dataRet"]?></td>
                                            <td><?=$pedido['endereco']?>, <?=$pedido['numero']?> <?php if($pedido['complemento']) {
                                                        echo ", ". $pedido['complemento'];
                                                    } ?> - <?=$pedido['bairro']?> - <?=$pedido['cidade']?></td>
                                            <td>R$ <?=$totalFormatted?></td>
                                            <td>
                                                <a href="../../../../controllers/processGerarRecibo.php?id=<?=$pedido['idPedido']?>" target="_blank" class="badge bg-primary text-bg-secondary rounded-pill">gerar recibo</a>
                                                <span class="badge bg-primary text-bg-secondary rounded-pill">Enviar mensáem</span>
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