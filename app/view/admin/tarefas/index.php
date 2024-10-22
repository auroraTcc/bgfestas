<?php
    require "../../../config/isLogged.php";

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
        <title>Tarefas</title>
        <link rel="stylesheet" href="../../../../public/assets/css/admin.css" />
        <script src="../../../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script
            src="https://kit.fontawesome.com/4c0a49f720.js"
            crossorigin="anonymous"
        ></script>
        <script src="../../../../node_modules/jquery/dist/jquery.min.js"></script>
        <link
            rel="shortcut icon"
            href="/public/assets/imgs/favicon.ico"
            type="image/x-icon"
        />
        <script src="../../../../node_modules/@iconfu/svg-inject/dist/svg-inject.min.js"></script>
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
                            <a href="../../../../app/view/admin">
                                <i class="fa-solid fa-chart-gantt"></i>
                                <span>Painel de Controle</span>
                            </a>
                        </li>
                        <li>
                            <a href="../../../../app/view/admin/tarefas">
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
                                        <a href="../../../../app/view/admin/funcionarios">
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


        <main>
            <section class="container">
                <div
                    class="d-md-flex container align-items-center justify-content-between mb-4"
                >
                    <div class="title-container">
                        <h2>Tarefas</h2>
                        <p class="mb-2">
                            Gerencie todas as entregas e atividades dos
                            funcionários de forma centralizada. Aqui, você pode
                            adicionar novas tarefas, atribuí-las a funcionários,
                            acompanhar o progresso e atualizar o status das
                            entregas em tempo real. Utilize as funcionalidades
                            abaixo para garantir que todas as suas tarefas sejam
                            realizadas de forma eficiente e sem falhas.
                        </p>
                    </div>
                </div>

                <section class="container" id="proximasTarefas">
                    <div id="tarefasContainer">
                    <?php 
                        require_once "../../../../app/config/conexao.php";
                        require_once "../../../../app/actions/pedido.php";

                        $resultados = getAllPedidos($conn);

                        if ($resultados) {
                            foreach ($resultados as $pedido) {

                                $dataHora = $pedido["data{$abbreviations[$pedido['stts']]}"] . ' ' . $pedido["hora{$abbreviations[$pedido['stts']]}"];
                                $dateTime = new DateTime($dataHora);
                                $formattedDate = $dateFormatter->format($dateTime);
                                $formattedTime = $dateTime->format('H:i') . 'h';

                                ?>
                                    <div class="card" data-type=<?=$pedido['stts']?>>
                                        <div class="card-header">
                                            <div>
                                                <h4 class="card-title"><?=$pedido['nomeCliente']?></h4>
                                                <p><?=$formattedDate?> <?=$formattedTime?></p>
                                            </div>
                                            <span><?=$pedido['stts']?></span>
                                        </div>

                                        <div class="card-body">
                                            <p class="card-text">
                                                <?=$pedido['endereco']?>, <?=$pedido['numero']?> <?php if($pedido['complemento']) {
                                                    echo ", ". $pedido['complemento'];
                                                } ?> - <?=$pedido['bairro']?> - <?=$pedido['cidade']?>
                                            </p>
                                            <div>
                                                <?php
                                                    foreach($pedido['itensCarrinho'] as $item) {
                                                        ?>
                                                            <div class="itemCount">
                                                                <img
                                                                    src="../../../../public/assets/imgs/<?=$item["nome"]?>.svg"
                                                                    onload="SVGInject(this)"
                                                                />
                                                                <p><?=$item["quantidade"]?> <?=$item["nome"]?>(s)</p>
                                                            </div>
                                                        <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="card-footer">
                                            <div>
                                                <i class="fa-solid fa-circle-user"></i>
                                                <h5>
                                                    Responsável:
                                                    <span><?=$pedido['nomeFuncionario']?></span>
                                                </h5>
                                            </div>

                                            <a href="#" class="text-body-bg">
                                                <i class="fa-solid fa-comments"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php
                            }
                        }
                    ?>
                    </div>
                </section>
            </section>

            <nav aria-label="Page nav igation example">
                <ul class="pagination pagination-md justify-content-center">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">Anterior</span>
                        </a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">Próximo</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </main>
    </body>
</html>
