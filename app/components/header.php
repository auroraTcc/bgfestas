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
                <a href="<?=$isLocal ? "/bgfestas" : ""?>/admin">
                    <i class="fa-solid fa-chart-gantt"></i>
                    <span>Painel de Controle</span>
                </a>
            </li>
            <li>
                <a href="<?=$isLocal ? "/bgfestas" : ""?>/admin/tarefas">
                    <i class="fa-regular fa-folder-open"></i>
                    <span>Tarefas</span>
                </a>
            </li>
        </ul>
    </div>
    <?php
        if ($user->getCargo() === "Gerente"
                ||
            $user->getCargo() === "Administrador") {
            ?>
                <div>
                    <h6>Admin</h6>
                    <ul>
                        <li>
                            <a href="<?=$isLocal ? "/bgfestas" : ""?>/admin/funcionarios">
                                <i class="fa-regular fa-id-badge"></i>
                                <span>Funcionários</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=$isLocal ? "/bgfestas" : ""?>/admin/tarefas/finalizadas">
                                <i class="fa-regular fa-square-check"></i>
                                <span>Tarefas Finalizadas</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=$isLocal ? "/bgfestas" : ""?>/admin/clientes">
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

<script>
    $("#logOutBtn").on("click", function () {
        $.ajax({
            url: "<?=$isLocal ? "/bgfestas/" : "/"?>controllers/processDesconectar",
            type: "POST",
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    console.log("Usuário desconectado com sucesso!");
                    window.location.href = "/bgfestas/admin/login";
                } else {
                    console.log("Erro ao desconectar.");
                }
            },
            error: function () {
                console.log("Erro na requisição Ajax:");
            },
        });
    }); 
</script>
