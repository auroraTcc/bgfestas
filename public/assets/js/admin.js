$("#workersSubtmitBtn").on("click", function (e) {
    e.preventDefault();
    const dados = $("#addWorkerForm").serialize();

    console.log(dados);

    $.ajax({
        url: "../../../../app/controllers/processInserirFunc.php",
        type: "POST",
        dataType: "json",
        data: dados,
        success: function (response) {
            if (response.success) {
                console.log("Funcionário inserido com sucesso!");
                console.log(response);
            } else {
                console.log(response);
                console.log("Erro ao inserir funcionário.");
            }
        },
        error: function (xhr, status, error) {
            console.error("Erro na requisição Ajax:", error);
        },
    });
});

$(".delete-btn").each(function () {
    $(this).on("click", function () {
        const cpf = $(this).data("cpf");

        $.ajax({
            url: "../../../../app/controllers/processDeleteFunc.php",
            type: "POST",
            dataType: "json",
            data: { cpf: cpf },
            success: function (response) {
                if (response.success) {
                    console.log("removido!");
                } else {
                    console.log("erro ao remover.");
                }
            },
            error: function (xhr, status, error) {
                console.error("Erro na requisição Ajax:", error);
            },
        });
    });
});

$(".pedido").each(function () {
    $(this).on("click", function () {
        window.location = `http://localhost/bgfestas/app/view/admin/tarefas/detalhes?id=${$(
            this
        ).data("id")}`;
    });
});

$("#logOutBtn").on("click", function () {
    $.ajax({
        url: "../../../app/controllers/processDesconectar.php",
        type: "POST",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                console.log("Usuário desconectado com sucesso!");
                window.location.href = "/bgfestas/app/view/admin"; //! DEPLOY: TROCAR PARA /app/view/admin
            } else {
                console.log("Erro ao desconectar.");
            }
        },
        error: function () {
            console.log("Erro na requisição Ajax:");
        },
    });
});
