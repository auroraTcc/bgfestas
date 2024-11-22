<?php
    require "../../config/isLogged.php";

    if (!$isLogged) {
        header("Location: /app/view/admin/login"); 
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
        <title>Admin</title>
        <link rel="stylesheet" href="../../../public/assets/css/admin.css" />
        <script src="../../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script
            src="https://kit.fontawesome.com/4c0a49f720.js"
            crossorigin="anonymous"
        ></script>
        <script src="../../../node_modules/jquery/dist/jquery.min.js"></script>
        <link
            rel="shortcut icon"
            href="/public/assets/imgs/favicon.ico"
            type="image/x-icon"
        />
        <script src="../../../node_modules/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
        <script src="../../../node_modules/@iconfu/svg-inject/dist/svg-inject.min.js"></script>
        <script src="../../../public/assets/js/admin.js" defer></script>
        
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
                            <a href="../../../app/view/admin">
                                <i class="fa-solid fa-chart-gantt"></i>
                                <span>Painel de Controle</span>
                            </a>
                        </li>
                        <li>
                            <a href="../../../app/view/admin/tarefas">
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
                                        <a href="../../../app/view/admin/funcionarios">
                                            <i class="fa-regular fa-id-badge"></i>
                                            <span>Funcionários</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../../../app/view/admin/tarefas/finalizadas">
                                            <i class="fa-regular fa-square-check"></i>
                                            <span>Tarefas Finalizadas</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../../../app/view/admin/clientes">
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
            

            <section class="container" id="highlights">
                <div class="card hello">
                    <div>
                    <h3>Bem-vindo de volta, <span><?=$_SESSION["funcionario"]["nome"]?></span></h3>
                        <p>painel de controle bgfestas.</p>
                    </div>
                </div>
                <div class="card">
                    <!-- <div>
                        <h4>10</h4>
                        <p>Tarefas essa semana.</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-calendar-week"></i>
                    </div> -->
                </div>
                <div class="card">
                    <!-- <div>
                        <h4>32</h4>
                        <p>Novos pedidos.</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-clipboard"></i>
                    </div> -->
                </div>
                <div class="card">
                    <!-- <div>
                        <h4>R$ 2.000,00</h4>
                        <p>Rendimento bruto.</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-money-bills"></i>
                    </div> -->
                </div>
            </section>
            <section class="container" id="proximasTarefas">
                <h3>Próximas Tarefas</h3>
                <div id="tarefasContainer">
                    <?php 
                        require_once "../../../app/config/conexao.php";
                        require_once "../../../app/actions/pedido.php";
                        $resultados;

                        if ($_SESSION['funcionario']['cargo'] === "Gerente" || $_SESSION['funcionario']['cargo'] === "Administrador") {
                            $resultados = getAllPedidos($conn);
                        } else {
                            $resultados = getPedidosByCpfFunc($conn, $_SESSION['funcionario']['cpf']);
                        }

                        if ($resultados) {
                            foreach ($resultados as $pedido) {

                                if($pedido["stts"] === "finalizado") {
                                    continue;
                                }

                                $dataHora = $pedido["data{$abbreviations[$pedido['stts']]}"] . ' ' . $pedido["hora{$abbreviations[$pedido['stts']]}"];
                                $dateTime = new DateTime($dataHora);
                                $formattedDate = $dateFormatter->format($dateTime);
                                $formattedTime = $dateTime->format('H:i') . 'h';
                                $cliente = getClienteByCpf($conn, $pedido["cpfCliente"]);


                                
                                ?>
                                
                                <a  style="text-decoration: none"
                                    class="card pedido d-flex" 
                                    data-type="<?=$pedido['stts']?>"
                                    href="./tarefas/detalhes?id=<?=$pedido['idPedido']?>"
                                >
                                    <div class="card-header">
                                        <div>
                                            <h4 class="card-title"><?=$pedido['nomeCliente']?></h4>
                                            <p><?=$formattedDate?> <?=$formattedTime?></p>
                                        </div>
                                        <span><?=$pedido['stts']?></span>
                                    </div>

                                    <div class="card-body">
                                        <p class="card-text">
                                            <?=$pedido['endereco']?>, <?=$pedido['numero']?><?php if($pedido['complemento']) { echo ", ". $pedido['complemento']; } ?> - <?=$pedido['bairro']?> - <?=$pedido['cidade']?>
                                        </p>
                                        <div>
                                            <?php foreach($pedido['itensCarrinho'] as $item) { ?>
                                                <div class="itemCount">
                                                    <img
                                                        src="../../../public/assets/imgs/<?=$item["nome"]?>.svg"
                                                        onload="SVGInject(this)"
                                                    />
                                                    <p><?=$item["quantidade"]?> <?=$item["nome"]?>(s)</p>
                                                </div>
                                            <?php } ?>
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

                                        <div    class="whatsapp-button bg-primary d-flex align-items-center justify-content-center rounded-pill text-bg-secondary"
                                                style="height: 2.5rem; width: 2.5rem;" 
                                                data-telefone="<?=$cliente['telefone']?>"
                                        >
                                            <i class="fa-solid fa-comments"></i>
                                        </div>
                                    </div>
                                </a>
                                
                                <?php
                            }
                        }
                    ?>
                </div>


                <a
                    href="../../../app/view/admin/tarefas"
                    class="btn btn-outline-primary d-flex ms-auto align-items-center gap-2"
                >
                    <span>Ver Todas</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </section>
        </main>

        <script>
            const whatsappButtons = document.querySelectorAll('.whatsapp-button');

            whatsappButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault()
                    e.stopPropagation(); 
                    const phone = button.getAttribute('data-telefone');
                    if (phone) {
                        const whatsappLink = `https://api.whatsapp.com/send?phone=${phone}&text=Olá! Sou da BGFESTAS. Recentemente você fez um pedido conosco e gostaria de falar contigo.`;
                        window.open(whatsappLink, '_blank'); 
                    }
                });
            });
        </script>
    </body>
</html>
