<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Admin</title>
        <link rel="stylesheet" href="../../../public/assets/css/dashboard.css" />
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
        <script src="../../../node_modules/@iconfu/svg-inject/dist/svg-inject.min.js"></script>
    </head>
    <body>

        <?php 
            require_once "../../../app/config/conexao.php";
            require_once "../../../app/actions/pedido.php";
            $resultados = getAllPedidos($conn);

        if ($resultados[0][""] == "") {
            echo 'sem pedidos';
        }
            print_r($resultados);
        ?>

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
                <span class="logo">bgfestas</span>
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
                <div>
                    <h6>Admin</h6>
                    <ul>
                        <li>
                            <a href="../../../app/view/admin/funcionarios">
                                <i class="fa-regular fa-id-badge"></i>
                                <span>Funcionários</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <main>
            <section class="container" id="highlights">
                <div class="card hello">
                    <div>
                        <h3>Bem-vindo de volta, <span>Gilson</span></h3>
                        <p>painel de controle bgfestas.</p>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <h4>10</h4>
                        <p>Tarefas essa semana.</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-calendar-week"></i>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <h4>32</h4>
                        <p>Novos pedidos.</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-clipboard"></i>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <h4>R$ 2.000,00</h4>
                        <p>Rendimento bruto.</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-money-bills"></i>
                    </div>
                </div>
            </section>
            <section class="container" id="proximasTarefas">
                <h3>Próximas Tarefas</h3>
                <div id="tarefasContainer">
                    <div class="card" data-type="entrega">
                        <div class="card-header">
                            <div>
                                <h4 class="card-title">Mariana Amorim</h4>
                                <p>26 ago. 12:30h</p>
                            </div>
                            <span>entrega</span>
                        </div>

                        <div class="card-body">
                            <p class="card-text">
                                Rua Natingui, 134, Parque Santo Antônio
                            </p>
                            <div>
                                <div class="itemCount">
                                    <img
                                        src="../../../public/assets/imgs/jogo.svg"
                                        onload="SVGInject(this)"
                                    />
                                    <p>8 jogos</p>
                                </div>
                                <div class="itemCount">
                                    <img
                                        src="../../../public/assets/imgs/mesa.svg"
                                        onload="SVGInject(this)"
                                    />
                                    <p>0 mesas</p>
                                </div>
                                <div class="itemCount">
                                    <img
                                        src="../../../public/assets/imgs/cadeira.svg"
                                        onload="SVGInject(this)"
                                    />
                                    <p>0 cadeiras</p>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div>
                                <i class="fa-solid fa-circle-user"></i>
                                <h5>
                                    Responsável:
                                    <span>Gilson</span>
                                </h5>
                            </div>

                            <a href="#">
                                <i class="fa-solid fa-comments"></i>
                            </a>
                        </div>
                    </div>
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
    </body>
</html>
