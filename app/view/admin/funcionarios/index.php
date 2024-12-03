<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Funcionários</title>
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
        <script src="<?=$isLocal ? "/bgfestas" : ""?>/node_modules/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
        <script src="<?=$isLocal ? "/bgfestas" : ""?>/node_modules/@iconfu/svg-inject/dist/svg-inject.min.js"></script>
        <script src="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/js/admin.js" defer></script>

        <style>
            input:read-only {
                background-color: #e9ecef;
                cursor: default ;
                border: none;
            }
            input:read-only:focus {
                background-color: #e9ecef;
                box-shadow: none;
                border: none;
            }
        </style>
    </head>
    <body>
        <?php
            include_once "$rootPath/app/components/header.php";
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
                            Criar/Editar Funcionarios
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

        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="toast" class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">

                <div class="toast-header">
                    <i class="fa-solid fa-bell fs-6 text-primary me-2"></i>
                    
                    <strong class="me-auto">Notificação</strong>
                    <small>1s atrás</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                
                <div class="toast-body">
                    Funcionário Deletado
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
                        id="modalBtn"
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
                    const row = document.createElement("tr");
                    
                    row.innerHTML = `
                        <th scope="row">${index}</th>   
                        <td class="nome">${funcionario.nome}</td>
                        <td class="email">${funcionario.email}</td>
                        <td class="cargo">${funcionario.cargo}</td>
                        <td class="d-flex gap-2">
                            <button class="btn delete-btn" data-cpf="${funcionario.cpf}">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                            <button class="btn edit-btn" data-cpf="${funcionario.cpf}">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                        </td>
                    `.trim();

                    $("tbody").append(row); 
                    index++
                });
            }

            $.ajax({
                url: "<?=$isLocal ? "/bgfestas" : ""?>/controllers/processGetAllFuncs",
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
                    url: "<?=$isLocal ? "/bgfestas" : ""?>/controllers/processInserirFunc",
                    type: "POST",
                    dataType: "json",
                    data: dados,
                    success: function (response) {
                        if (response.success) {
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
                    url: "<?=$isLocal ? "/bgfestas" : ""?>/controllers/processDeleteFunc",
                    type: "POST",
                    dataType: "json",
                    data: { cpf: cpf },
                    success: function (response) {
                        if (response.success) {
                            mostrarFuncionarios(response.funcionarios);
                            $('#toast').toast('show');
                        } else {
                            errorMessaeParagraph.text(response.message)
                        }
                    },
                    error: function (xhr, status, error) {
                        errorMessaeParagraph.text("Houve um erro: ", error)                   
                    },
                });
            });

            $("#modalBtn").on("click", function () {
                $('#addWorkerForm')[0].reset();
                $("#cpf").prop('readonly', false);
            })

            $("tbody").on("click", ".edit-btn", function () {
                const row = $(this).closest("tr");
                $("#exampleModal").modal("show")
                $("#cpf").val($(this).data("cpf")).prop('readonly', true);
                $("#nome").val(row.find(".nome").html());
                $("#email").val(row.find(".email").html());
            });
        </script>
    </body>
</html>
