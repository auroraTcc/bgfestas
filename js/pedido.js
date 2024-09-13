const precoJogos = 10;
const precoMesas = 5;
const precoCadeiras = 2;
const pedidoMinimo = 50;

let slideIndex = 0;

let valorTotalDeJogos = 0;
let valorTotalDeMesas = 0;
let valorTotalDeCadeiras = 0;
let frete = 0;
let total = 0;

$("#cep").mask("00000-000");
$("#telefone").mask("(00) 00000-0000");
$("#cpf").mask("000.000.000-00", { reverse: true });

$("#cep").blur(function () {
    let cep = $(this).val().replace(/\D/g, "");

    if (cep != "") {
        var validacep = /^[0-9]{8}$/;

        if (validacep.test(cep)) {
            $("#endereco").val("...");
            $("#bairro").val("...");
            $("#cidade").val("...");
            $("#estado").val("...");

            $.getJSON(
                "https://viacep.com.br/ws/" + cep + "/json/?callback=?",
                function (dados) {
                    if (!("erro" in dados)) {
                        $("#endereco").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#estado").val(dados.estado);
                    } else {
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                }
            );
        } else {
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    }
});

$(".btn-prosseguir").each(function () {
    $(this).on("click", function (event) {
        let valid = true;

        $(this)
            .closest(".formCard")
            .find("input[required], select[required], textarea[required]")
            .each(function () {
                if (!this.checkValidity()) {
                    valid = false;
                    $(this).addClass("is-invalid");
                    $(this).removeClass("is-valid");
                    this.reportValidity();
                } else {
                    if (this.value === "...") {
                        valid = false;
                        $(this).addClass("is-invalid");
                        $(this).removeClass("is-valid");
                        this.reportValidity();
                    } else {
                        $(this).addClass("is-valid");
                        $(this).removeClass("is-invalid");
                    }
                }
            });

        if (slideIndex < 2) {
            event.preventDefault();

            if (valid) {
                slideIndex++;
                $("#slides-container").css(
                    "transform",
                    `translateX(-${100 * slideIndex}%)`
                );
            }
        }
    });
});

function formatarMoeda(valor) {
    return `R$ ${valor.toFixed(2).replace(".", ",")}`;
}

function calcularTotal() {
    let totalDosItens =
        valorTotalDeJogos + valorTotalDeMesas + valorTotalDeCadeiras;

    frete = totalDosItens < pedidoMinimo ? pedidoMinimo - totalDosItens : 0;
    total = totalDosItens + frete;

    $("#freteEManuseio").text(formatarMoeda(frete));
    $("#totalDoPedido").text(formatarMoeda(total));
}

$("#jogos").on("change", function () {
    valorTotalDeJogos = precoJogos * $(this).val();
    $("#totalDosJogos").text(formatarMoeda(valorTotalDeJogos));
    calcularTotal();
});

$("#mesas").on("change", function () {
    valorTotalDeMesas = precoMesas * $(this).val();

    $("#totalDasMesas").text(`R$ ${valorTotalDeMesas},00`);
    calcularTotal();
});

$("#cadeiras").on("change", function () {
    valorTotalDeCadeiras = precoCadeiras * $(this).val();

    $("#totalDasCadeiras").text(`R$ ${valorTotalDeCadeiras},00`);
    calcularTotal();
});
