<?php
    require_once "../../../../app/config/conexao.php";
    require "../../../config/isLogged.php";

    if (!$isLogged) {
        header("Location: /bgfestas/app/view/admin/login");
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Clientes</title>
        <link
                rel="stylesheet"
                href="../../../../public/assets/css/admin.css"
            />
            <script src="../../../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
            <script
                src="https://kit.fontawesome.com/4c0a49f720.js"
                crossorigin="anonymous"
            ></script>
            <script src="../../../../node_modules/jquery/dist/jquery.min.js"></script>
            <link
                rel="shortcut icon"
                href="../../../../public/assets/imgs/favicon.ico"
                type="image/x-icon"
            />
            <script src="../../../../node_modules/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
            <script src="../../../../node_modules/@iconfu/svg-inject/dist/svg-inject.min.js"></script>
            <script src="../../../../public/assets/js/admin.js" defer></script>

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
                                    <li>
                                        <a href="../../../../app/view/admin/tarefas/finalizadas">
                                            <i class="fa-regular fa-square-check"></i>
                                            <span>Tarefas Finalizadas</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../../../../app/view/admin/clientes">
                                            <i class="fa-solid fa-user-tag"></i>
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
                        <h2>Clientes</h2>
                        <p class="mb-2">
                            Nesta página, você pode visualizar e filtrar quaisquer clientes
                            que já fizeram pedidos em seu site.
                        </p>
                    </div>

                   
                </div>

                <div class="mb-2">
                    <div class="btn-group border rounded-pill">
                        <button class="btn btn-sm d-flex align-items-center gap-2" type="button">
                            <i class="fa-solid fa-circle-xmark"></i>
                            Bairro(s):
                        </button>
                        <button type="button" class="btn btn-sm dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="text-primary dropdown-toggle">Gopoúva, Jacuacanga</span>
                        </button>
                        <ul class="dropdown-menu">
                            ...
                        </ul>
                    </div>

                    
                </div>

                <div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="table-light">
                                    <th scope="col">#</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Bairros</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>
        </main>

        <script>
            let allClients;
            let bairrosSelecionados;
            
            function insertClients(clients) {
                $("tbody").empty();
                let index = 1;

                clients.forEach((cliente) => {
                    const row = document.createElement("tr");
                    const telefone = parseInt(cliente.telefone.split(/\D+/).join(""), 10)
                    
                    row.innerHTML = `
                        <th scope="row">${index}</th>   
                        <td class="nome">${cliente.nome}</td>
                        <td class="bairros">
                            ${cliente.bairros 
                                ? cliente.bairros.map(bairro => bairro).join(", ") 
                                : "Não disponível"}
                        </td>
                        <td>
                            <a  href="https://api.whatsapp.com/send?phone=55${telefone}&text=Olá%20${cliente.nome}!%20Sou%20o%20Gilson,%20gerente%20da%20BGFESTAS.%20Recentemente%20você%20fez%20um%20pedido%20conosco%20e%20gostaria%20de%20falar%20contigo."
                                class="badge bg-primary text-bg-secondary rounded-pill d-flex align-items-center gap-1"
                                style="width: fit-content; text-decoration: none"
                                target="_blank"
                            >
                                <i class="fa-solid fa-comments" aria-hidden="true"></i>
                                Enviar Mensagem
                            </a>
                        </td>
                    `.trim();

                    $("tbody").append(row); 
                    index++
                });
            }

            $.ajax({
                url: "../../../../app/controllers/processGetAllClients.php",
                type: "POST",
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        insertClients(response.clientes)
                        allClients = response.clientes
                    } else {
                        console.error(response.message)
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText)                       
                },
                
            })

        </script>
    </body>
</html>