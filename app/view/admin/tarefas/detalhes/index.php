<?php

    require "../../../../config/isLogged.php";
    require_once "../../../../config/conexao.php";


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


    require_once "../../../../../app/config/conexao.php";
    require_once "../../../../../app/actions/pedido.php"; 
    $idPedido = $_GET['id'];
    $resultados = getPedidoById($conn, $idPedido);
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
        <header class="border-bottom border-main">
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
                                </ul>
                            </div>
                        <?php
                    }
                ?>
                
            </nav>
        </div>


        <main class="container" data-type=<?=$resultados[0]["stts"]?>>
            <section
                class="d-flex flex-column-reverse gap-3 flex-md-row justify-content-between align-md-items-center align-items-start"
            >
                <div>
                    <?php
                        
                        if ($resultados) {
                            foreach ($resultados as $pedido) {

                                echo "<script>const pedido = " . json_encode($pedido) . ";</script>";

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
                            <i class="fa-solid fa-circle-user"></i>
                            <?php
                                if($_SESSION['funcionario']['cargo'] === "Gerente"
                                ||
                                $_SESSION['funcionario']['cargo'] === "Administrador") {
                                    ?>
                                    <select
                                            class="form-select"
                                            id="selectFunc"
                                            aria-label="Default select example"
                                        >
                                            <?php

                                                $resultados = getAllFuncs($conn);

                                            if ($resultados) {
                                                foreach ($resultados as $funcionario) {
                                            ?>
                                            <option value="<?=$funcionario['cpf']?>" <?php
                                                if ($pedido["cpfResponsavel"] === $funcionario["cpf"]) {
                                                    echo "selected";
                                                }
                                            ?>> <?=$funcionario['nome'];?></option><?php
                                                };
                                            }?>
                                            
                                        </select>
                                    <?php
                                } else {
                                    $funcionario = getNomeFuncionarioByCpf($conn, $pedido["cpfResponsavel"]);

                                    echo $funcionario;
                                }
                            ?>
                        </p>
                    </div>
                </div>
                <span
                    class="badge bg-main text-bg-main rounded-pill fs-6 fw-normal lh-base ps-4 pe-4"
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
                            <div class="d-flex justify-content-center">
                                <img
                                    src="../../../../../public/assets/imgs/<?=$item['nome']?>.svg"
                                    onload="SVGInject(this)"
                                    class="text-main"
                                    height="2rem"
                                    fill="currentColor"
                                />
                            </div>
                            <h5 class="text-secondary-color"><?=$item["nome"]?></h5>
                        </div>
                        <div class="d-flex gap-1 align-items-center">
                            <p class="mb-0"><?=$item["quantidade"]?> x <?=number_format($item["preco"], 2, ',', '.') ?> =</p>
                            <p class="fw-bold mb-0">R$ <?=number_format($item["quantidade"] * $item["preco"], 2, ',', '.') ?></p> 
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
                    // Definindo o valor do frete
                    if ($pedido['subtotal'] < 50.00) {
                        $pedido['frete'] = 50.00 - $pedido['subtotal'];
                    } else {
                        $pedido['frete'] = 0; // Garantir que o frete seja 0 se não for necessário
                    }

                    // Formatar subtotal e frete apenas para apresentação
                    $subtotalFormatted = number_format($pedido['subtotal'], 2, ',', '.');
                    $freteFormatted = number_format($pedido['frete'], 2, ',', '.');

                    // Calcular o total (sem formatação)
                    $total = $pedido['subtotal'] + $pedido['frete'];
                    $totalFormatted = number_format($total, 2, ',', '.');
                }
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
                        if ($pedido["stts"] === "entrega") {
                            echo "Receba o pagamento antes de prosseguir com a entrega";
                        } else {
                            echo "Verifique a condição dos itens antes de prosseguir com a retirada";
                        }
                    ?>
                    
                </p>
                <button id="confirmBtn" class="btn btn-main ms-auto">
                    <?php
                        if ($pedido["stts"] === "entrega") {
                            echo "Confirmar Pagamento";
                        } else {
                            echo "Confirmar retirada";
                        }
                    ?>
                </button>

                <?php
                      }
                ?>

            </section>
        </main>

        <script>
            $("#confirmBtn").on("click", function () {
                const idPedido = pedido.idPedido;

                $.ajax({
                    url: "../../../../../app/controllers/processAtualizarStatusDoPedido.php",
                    type: "POST",
                    dataType: "json",
                    data: { pedido: idPedido },
                    success: function (response) {
                        if (response.success) {
                            console.log("Alteração realizada com sucesso");
                        } else {
                            console.log("Falha ao alterar as coisas:", response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log("Erro ao processar a solicitação:", error);
                    },
                });
            });

            $("#selectFunc").on("change", function () {
                const cpf = $(this).val();
                const idPedido = pedido.idPedido;

                $.ajax({
                    url: "../../../../../app/controllers/processAlterarFuncResponsavel.php",
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
