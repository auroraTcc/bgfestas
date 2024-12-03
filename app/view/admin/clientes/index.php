
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Clientes</title>
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
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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
                        <button id="emptySelectedBairros" style="display: none;" class="btn btn-sm align-items-center gap-2" type="button">
                            <i class="bi bi-x-circle"></i>
                            Bairro(s):
                        </button>
                        <button type="button" class="btn btn-sm dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <span id="selectBairrosText" class="d-flex align-items-center gap-2">
                                <i class="bi bi-plus-circle"></i>
                                Bairros
                            </span>
                        </button>
                        <ul id="selectBairros" class="dropdown-menu p-2">
                            
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
            const originalSelectBairrosHTML = $("#selectBairrosText").html();
            const originalSelectBairrosClasses = $("#selectBairrosText").attr("class"); 

            function getSelectedBairros() {
                const bairros = [];
                $(".form-check-input:checked").each(function () {
                    bairros.push($(this).val());
                });
                return bairros;
            }

          
            function filterClientsByBairros(selectedBairros) {
                if (selectedBairros.length === 0) {
                    insertClients(allClients);
                    return;
                }
                const filteredClients = allClients.filter(cliente => {
                    return cliente.bairros && cliente.bairros.some(bairro => selectedBairros.includes(bairro));
                });

                insertClients(filteredClients);
            }

            function displaySelectedBairros(selectedBairros) {
                if (selectedBairros.length === 0) {
                    $("#emptySelectedBairros").hide()
                    $("#selectBairrosText") .html(originalSelectBairrosHTML)
                                            .attr("class", originalSelectBairrosClasses);
                    return
                }

                let bairros = getSelectedBairros()

                $("#selectBairrosText") .empty()
                                        .text(bairros.map(bairro => bairro).join(", "))
                                        .addClass("text-primary fw-semibold dropdown-toggle")


                $("#emptySelectedBairros").css("display", "flex")
            }
            
            
            function insertBairros(bairros) {
                $("#selectBairros").empty(); 

                bairros.forEach((bairro) => {
                    const item = document.createElement("li"); 
                    item.innerHTML = `
                        <label>
                            <input class="form-check-input" type="checkbox" value="${bairro}" id="flexCheckDefault">
                            ${bairro}
                        </label>
                    `.trim(); 
                    $("#selectBairros").append(item); 
                });
            }

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

            $(".dropdown-menu").on('click', function (e) {
                e.stopPropagation();
            });

            $("#selectBairros").on("change", ".form-check-input", function () {
                const selectedBairros = getSelectedBairros(); 
                filterClientsByBairros(selectedBairros);
                displaySelectedBairros(selectedBairros)
            });

            $("#emptySelectedBairros").on("click", function () {
                $(".form-check-input").each(function() {
                    $(this).prop('checked', false)
                })
                filterClientsByBairros([])
                displaySelectedBairros([])
            })

            $.ajax({
                url: "<?=$isLocal ? "/bgfestas" : ""?>/controllers/processGetAllClients",
                type: "POST",
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        console.log(response.clientes);
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

            
            $.ajax({
                url: "<?=$isLocal ? "/bgfestas" : ""?>/controllers/processGetAllBairros",
                type: "POST",
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        insertBairros(response.bairros)
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