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
        console.log("hi");
    });
});
