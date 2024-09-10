const precoJogos = 10;
const precoMesas = 5;
const precoCadeiras = 2;
const pedidoMinimo = 50;

let etapa = 1;
const cards = $(".card");

let valorTotalDeJogos = 0;
let valorTotalDeMesas = 0;
let valorTotalDeCadeiras = 0;
let frete = 0;
let total = 0;

$("#cep").mask("00000-000");
$("#telefone").mask("(00) 00000-0000");
$("#cpf").mask("000.000.000-00", { reverse: true });

$(".btn-prosseguir").on("click", function (event) {
    event.preventDefault();
    if (etapa < cards.length) {
        $(cards[etapa - 1]).removeClass("active");

        $(cards[etapa]).addClass("active");

        etapa++;
    }
});

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
                        //Atualiza os campos com os valores da consulta.
                        $("#endereco").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#estado").val(dados.estado);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                }
            );
        } else {
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    } else {
        limpa_formulário_cep();
    }
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
