$(".cpf").mask("000.000.000-00");

$("#logOutBtn").on("click", function () {
    $.ajax({
        url: "/bgfestas/app/controllers/processDesconectar.php",
        type: "POST",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                console.log("Usuário desconectado com sucesso!");
                window.location.href = "/bgfestas/app/view/admin";
            } else {
                console.log("Erro ao desconectar.");
            }
        },
        error: function () {
            console.log("Erro na requisição Ajax:");
        },
    });
});

function validarCPF(value) {
    let cpf = value.replace(/[^\d]+/g, "");

    if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) return false;

    const calcularDigito = (base) => {
        let soma = 0;
        for (let i = 0; i < base; i++) {
            soma += parseInt(cpf.charAt(i)) * (base + 1 - i);
        }
        let resto = soma % 11;
        return resto < 2 ? 0 : 11 - resto;
    };

    let digito1 = calcularDigito(9);
    let digito2 = calcularDigito(10);

    return (
        digito1 === parseInt(cpf.charAt(9)) &&
        digito2 === parseInt(cpf.charAt(10))
    );
}
