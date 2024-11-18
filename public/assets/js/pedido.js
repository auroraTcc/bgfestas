const today = new Date().toISOString().split("T")[0];

const precos = {
    jogos: 10,
    mesas: 5,
    cadeiras: 2,
};

const pedidoMinimo = 50;

let slideIndex = 0;

let valorTotal = {
    jogos: 0,
    mesas: 0,
    cadeiras: 0,
};

let frete = 0;
let total = 0;

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

$("#dataDeEntrega").attr("min", today);
$("#dataDeRetirada").attr("min", today);

$("#cep").mask("00000-000");
$("#telefone").mask("(00) 00000-0000");
$("#cpf").mask("000.000.000-00");

$("#cep").on("blur", function () {
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

$(".etapa").each(function (i = i - 1) {
    $(this).on("click", function () {
        if (i <= slideIndex) {
            slideIndex = i;
            $("#slides-container").css(
                "transform",
                `translateX(-${100 * slideIndex}%)`
            );
        }
    });
});

$(".btn-prosseguir").each(function () {
    $(this).on("click", function (event) {
        let valid = true;

        $(this)
            .closest(".formCard")
            .find("input[required], select[required], textarea[required]")
            .each(function () {
                if (!this.checkValidity() || this.value === "...") {
                    valid = false;
                    $(this).addClass("is-invalid").removeClass("is-valid");
                    this.reportValidity();
                } else if (this.name === "cpf" && !validarCPF(this.value)) {
                    valid = false;
                    $(this).addClass("is-invalid").removeClass("is-valid");
                } else {
                    $(this).addClass("is-valid").removeClass("is-invalid");
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
        } else if (!valid) {
            event.preventDefault();
        }
    });
});

function formatarMoeda(valor) {
    return `R$ ${valor.toFixed(2).replace(".", ",")}`;
}

function calcularTotal() {
    let totalDosItens =
        valorTotal.jogos + valorTotal.mesas + valorTotal.cadeiras;

    frete = totalDosItens < pedidoMinimo ? pedidoMinimo - totalDosItens : 0;
    total = totalDosItens + frete;

    $("#freteEManuseio").text(formatarMoeda(frete));
    $("#totalDoPedido").text(formatarMoeda(total));
}

function configurarEventoDeMudanca(
    item,
    defaultInput,
    moreInput,
    displayTotalElement
) {
    moreInput.hide();

    defaultInput.on("change", function () {
        let selectedValue = parseInt($(this).val());
        $(moreInput).val(selectedValue);

        if (selectedValue >= 6) {
            $(this).hide();
            $(moreInput).show();
        }

        const preco = precos[item];
        valorTotal[item] = preco * selectedValue;

        displayTotalElement.text(formatarMoeda(valorTotal[item]));
        calcularTotal();
    });

    moreInput.on("change", function () {
        let selectedValue = parseInt($(this).val());

        if (selectedValue < 6) {
            $(this).hide();
            $(defaultInput).show();
            $(defaultInput).val(selectedValue);
        }

        const preco = precos[item];
        valorTotal[item] = preco * selectedValue;

        displayTotalElement.text(formatarMoeda(valorTotal[item]));
        calcularTotal();
    });
}

$('input[name="datetimes"]').daterangepicker({
    timePicker: true,
    minDate: moment(),
    startDate: moment().startOf('hour'),
    endDate: moment().startOf('hour').add(32, 'hour'),
    locale: {
        format: 'DD/MM hh:mm A'
    }
}).on('apply.daterangepicker', function(ev, picker) {
    let startDate = new Date(picker.startDate.format('MM/DD/YYYY')).toISOString().slice(0, 10)
    let endDate = new Date(picker.endDate.format('MM/DD/YYYY')).toISOString().slice(0, 10)
    let startTime = picker.startDate.format('HH:mm');
    let endTime = picker.endDate.format('HH:mm');

    $("input[name='dataDeEntrega']").val(startDate)
    $("input[name='dataDeRetirada']").val(endDate)
    $("input[name='horarioDaEntrega']").val(startTime)
    $("input[name='horarioDaRetirada']").val(endTime)
});

configurarEventoDeMudanca(
    "jogos",
    $("#ateCincoJogos"),
    $("#jogos"),
    $("#totalDosJogos")
);

configurarEventoDeMudanca(
    "mesas",
    $("#ateCincoMesas"),
    $("#mesas"),
    $("#totalDasMesas")
);

configurarEventoDeMudanca(
    "cadeiras",
    $("#ateCincoCadeiras"),
    $("#cadeiras"),
    $("#totalDasCadeiras")
);

