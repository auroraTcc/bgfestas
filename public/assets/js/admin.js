$("#workersSubtmitBtn").on("click", function (e) {
    e.preventDefault();
    const dados = $("#addWorkerForm").serialize();

    $.ajax({
        url: "../../../../app/controllers/processInserirFunc.php",
        type: "POST",
        dataType: "json",
        data: dados,
        success: function (response) {
            if (response.success) {
                console.log("Funcionário inserido com sucesso!");
            } else {
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

$(".card").each(function () {
    $(this).on("click", function () {
        window.location = `http://localhost/bgfestas/app/view/admin/tarefas/detalhes?id=${$(
            this
        ).data("id")}`;
    });
});
