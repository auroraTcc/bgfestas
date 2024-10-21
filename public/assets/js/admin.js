$(".cpf").mask("000.000.000-00");

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
