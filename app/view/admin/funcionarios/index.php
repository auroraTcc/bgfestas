<?php
    require_once "../../../../app/config/conexao.php";
    require_once "../../../../app/actions/funcionario.php";
    require "../../../config/isLogged.php";

    if (!$isLogged) {
        header("Location: /bgfestas/app/view/admin/login"); //TODO: DEPLOY: TROCAR PARA /app/view/admin/login
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Funcionários</title>
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
                                        <a href="../../../app/view/admin/funcionarios">
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

        <div
            class="modal fade"
            id="exampleModal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                            Adicionar Novo Funcionário
                        </h1>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <form
                            id="addWorkerForm"
                            class="needs-validation"
                        >
                            <div class="input-group mb-3 has-validation">
                                <span class="input-group-text">cpf:</span>
                                <input
                                    type="text"
                                    class="form-control cpf"
                                    placeholder="insira o CPF do funcionário"
                                    id="cpf"
                                    name="cpf"
                                    aria-label="Username"
                                    aria-describedby="basic-addon1"
                                    autocomplete="off"
                                    required
                                />
                                <div class="invalid-feedback">
                                    CPF inválido!
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text">nome:</span>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="insira o nome do funcionário"
                                    id="nome"
                                    name="nome"
                                    aria-label="Username"
                                    aria-describedby="basic-addon1"
                                    autocomplete="off"
                                    required
                                />
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text">email:</span>
                                <input
                                    type="email"
                                    class="form-control"
                                    placeholder="insira o email do funcionário"
                                    id="email"
                                    name="email"
                                    aria-label="Username"
                                    aria-describedby="basic-addon1"
                                    autocomplete="off"
                                    required
                                />
                            </div>

                            <p class="text-danger" id="errorMessagge"></p>

                            <button id="workersSubtmitBtn" class="btn btn-primary w-100">
                                enviar
                            </button>
                        </form>
                    </div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <main>
            <section class="container">
                <div
                    class="d-md-flex container align-items-center justify-content-between mb-4"
                >
                    <div class="title-container">
                        <h2>Funcionários</h2>
                        <p class="mb-2">
                            Nesta página, você pode adicionar, editar e remover
                            funcionários, além de gerenciar suas atribuições e
                            monitorar suas atividades. Use as opções abaixo para
                            garantir que sua equipe esteja sempre atualizada e
                            pronta para atender aos pedidos de forma eficiente.
                        </p>
                    </div>

                    <button
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#exampleModal"
                    >
                        adiconar novo
                    </button>
                </div>

                <div>
                    

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="table-light">
                                    <th scope="col">#</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Cargo</th>
                                    <th scope="col"></th>
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
            const errorMessaeParagraph = $("#errorMessagge")

            function mostrarFuncionarios(funcionarios) {
                $("tbody").empty();
                let index = 1;

                funcionarios.forEach((funcionario) => {
                    if (funcionario.cpf === "000.000.000-00") {
                        return
                    }
                    
                    const row = document.createElement("tr");
                    
                    row.innerHTML = `
                        <th scope="row">${index}</th>   
                        <td>${funcionario.nome}</td>
                        <td>${funcionario.email}</td>
                        <td>${funcionario.cargo}</td>
                        <td class="d-flex gap-2">
                            <button class="btn delete-btn" data-cpf="${funcionario.cpf}">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                            <button class="btn">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                        </td>
                    `.trim();

                    $("tbody").append(row); 
                    index++
                });
            }

            $.ajax({
                url: "../../../../app/controllers/processGetAllFuncs.php",
                type: "POST",
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        mostrarFuncionarios(response.funcionarios)
                    } else {
                        console.error(response.message)
                    }
                },
                error: function (xhr, status, error) {
                    errorMessaeParagraph.text("Houve um erro: ", error)                   
                },
            })

            $("#workersSubtmitBtn").on("click", function (e) {
                e.preventDefault();
                const dados = $("#addWorkerForm").serialize();

                if(!validarCPF($("input[id='cpf']").val())) {
                    $("input[id='cpf']").addClass("is-invalid").removeClass("is-valid");
                    return
                } else {
                    $("input[id='cpf']").addClass("is-valid").removeClass("is-invalid");
                }
            

                $.ajax({
                    url: "../../../../app/controllers/processInserirFunc.php",
                    type: "POST",
                    dataType: "json",
                    data: dados,
                    success: function (response) {
                        if (response.success) {
                            console.log("Funcionário inserido com sucesso!");

                            mostrarFuncionarios(response.funcionarios)

                            $('#exampleModal').modal('hide');
                            $('#addWorkerForm')[0].reset();
                        } else {
                            errorMessaeParagraph.text(response.message)
                        }
                    },
                    error: function (xhr, status, error) {
                        errorMessaeParagraph.text("Houve um erro: ", error)                   
                    },
                });
            });

            $("tbody").on("click", ".delete-btn", function () {
                const cpf = $(this).data("cpf");

                $.ajax({
                    url: "../../../../app/controllers/processDeleteFunc.php",
                    type: "POST",
                    dataType: "json",
                    data: { cpf: cpf },
                    success: function (response) {
                        if (response.success) {
                            mostrarFuncionarios(response.funcionarios);
                        } else {
                            errorMessaeParagraph.text(response.message)
                        }
                    },
                    error: function (xhr, status, error) {
                        errorMessaeParagraph.text("Houve um erro: ", error)                   
                    },
                });
            });
        </script>
    </body>
</html>
