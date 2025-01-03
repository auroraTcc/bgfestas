<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Fazer Pedido</title>
        <link rel="stylesheet" href="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/css/fazerpedido.css" />
        <link rel="stylesheet" href="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/css/bootstrap.css" />
        <script src="<?=$isLocal ? "/bgfestas" : ""?>/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script
            src="https://kit.fontawesome.com/4c0a49f720.js"
            crossorigin="anonymous"
        ></script>
        <script src="<?=$isLocal ? "/bgfestas" : ""?>/node_modules/jquery/dist/jquery.min.js"></script>
        <script src="<?=$isLocal ? "/bgfestas" : ""?>/node_modules/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
        <script src="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/js/pedido.js" defer></script>
        <script src="<?=$isLocal ? "/bgfestas" : ""?>/node_modules/@iconfu/svg-inject/dist/svg-inject.min.js"></script>
        <link
            rel="shortcut icon"
            href="/public/imgs/favicon.ico"
            type="image/x-icon"
        />
        <script
            type="text/javascript"
            src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"
        ></script>
        <script
            type="text/javascript"
            src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"
        ></script>
        <link
            rel="stylesheet"
            type="text/css"
            href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"
        />

        <style>
            #confirmation-popup {
                flex: 1 1 0;
            }
        </style>
    </head>

    <body>
        <div class="geral">
            <div class="esquerda" id="container-form">
                <div id="carrossel">
                    <form
                        id="slides-container"
                        method="POST"
                        class="needs-validation"
                        novalidate
                    >
                        <div class="formCard active">
                            <header>
                                <div class="etapa numero-etapa-certa">
                                    <div>1</div>
                                    <h5>Entrega</h5>
                                </div>
                                <div class="etapa numero-etapa">
                                    <div>2</div>
                                    <h5>Pedido</h5>
                                </div>
                                <div class="etapa numero-etapa">
                                    <div>3</div>
                                    <h5>Contato</h5>
                                </div>
                            </header>
                            <div class="form-etapa">
                                <div>
                                    <label for="cep"><span>*</span>CEP</label>
                                    <input
                                        type="text"
                                        id="cep"
                                        name="cep"
                                        placeholder="Ex.: 00000-000"
                                        required
                                        class="form-control"
                                    />
                                    <div class="invalid-feedback">
                                        Insira um CEP válido.
                                    </div>
                                </div>
                                <div>
                                    <label for="endereco"
                                        ><span>*</span>Endereço</label
                                    >
                                    <input
                                        type="text"
                                        id="endereco"
                                        name="endereco"
                                        placeholder=""
                                        required
                                        class="form-control"
                                    />
                                    <div class="invalid-feedback">
                                        Insira um endereço válido.
                                    </div>
                                </div>
                                <div>
                                    <label for="numero"
                                        ><span>*</span>Número</label
                                    >
                                    <input
                                        type="text"
                                        name="numero"
                                        id="numero"
                                        placeholder="número ou s/n"
                                        required
                                        class="form-control"
                                    />
                                    <div class="invalid-feedback">
                                        Insira um número válido ou s/n.
                                    </div>
                                </div>
                                <div>
                                    <label for="complemento">Complemento</label>
                                    <input
                                        type="text"
                                        id="complemento"
                                        name="complemento"
                                        class="form-control"
                                        placeholder="Apartamento, sala, conjunto, edifício, andar, etc."
                                    />
                                </div>
                                <div>
                                    <label for="bairro"
                                        ><span>*</span>Bairro</label
                                    >
                                    <input
                                        type="text"
                                        name="bairro"
                                        id="bairro"
                                        placeholder=""
                                        required
                                        class="form-control"
                                    />
                                    <div class="invalid-feedback">
                                        Insira um bairro válido.
                                    </div>
                                </div>
                                <div>
                                    <label for="cidade"
                                        ><span>*</span>Cidade</label
                                    >
                                    <input
                                        type="text"
                                        id="cidade"
                                        name="cidade"
                                        class="form-control"
                                        placeholder="Insira o CEP acima para preencher a cidade"
                                        required
                                    />
                                    <div class="invalid-feedback">
                                        Insira uma cidade válida.
                                    </div>
                                </div>
                            </div>
                            <button class="btn-prosseguir">Prosseguir</button>
                        </div>

                        <div class="formCard">
                            <header>
                                <div class="numero-etapa">
                                    <div>1</div>
                                    <h5>Entrega</h5>
                                </div>
                                <div class="numero-etapa-certa">
                                    <div>2</div>
                                    <h5>Pedido</h5>
                                </div>
                                <div class="numero-etapa">
                                    <div>3</div>
                                    <h5>Contato</h5>
                                </div>
                            </header>
                            <div class="form-section d-none">
                                <div>
                                    <label for="dataDeEntrega"
                                        ><span>*</span> Data da entrega</label
                                    >
                                    <input
                                        name="dataDeEntrega"
                                        id="dataDeEntrega"
                                        type="date"
                                        required
                                        data-date-split-input="true"
                                        class="form-control"
                                    />
                                </div>
                                <div>
                                    <label for="dataDeEntrega"
                                        ><span>*</span> Horário de
                                        entrega</label
                                    >
                                    <input
                                        type="time"
                                        name="horarioDaEntrega"
                                        id="horarioDaEntrega"
                                        required
                                        class="form-control"
                                    />
                                </div>
                            </div>
                            <div class="form-section d-none">
                                <div>
                                    <label for="dataDeRetirada"
                                        ><span>*</span> Data de Retirada</label
                                    >
                                    <input
                                        type="date"
                                        name="dataDeRetirada"
                                        id="dataDeRetirada"
                                        required
                                        class="form-control"
                                    />
                                </div>
                                <div>
                                    <label for="horarioDaRetirada"
                                        ><span>*</span>Horário de
                                        Retirada</label
                                    >
                                    <input
                                        type="time"
                                        name="horarioDaRetirada"
                                        id="horarioDaRetirada"
                                        required
                                        class="form-control"
                                    />
                                </div>
                            </div>

                            <div class="form-section">
                                <label for="datetimes"
                                    >Período de locação</label
                                >
                                <input type="text" name="datetimes" required />
                            </div>

                            <div class="form-carrinho">
                                <h3>Carrinho de compras</h3>
                                <div class="carrinho">
                                    <div class="cart-item">
                                        <label for="jogos">
                                            <span>
                                                <img
                                                    src="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/imgs/jogo.svg"
                                                    alt=""
                                                    onload="SVGInject(this)"
                                                />
                                            </span>
                                            Jogos (1 mesa + 4 cadeiras)
                                        </label>
                                        <select
                                            id="ateCincoJogos"
                                            name="ateCincoJogos"
                                            required
                                        >
                                            <option value="0">Qtd: 0</option>
                                            <option value="1">Qtd: 1</option>
                                            <option value="2">Qtd: 2</option>
                                            <option value="3">Qtd: 3</option>
                                            <option value="4">Qtd: 4</option>
                                            <option value="5">Qtd: 5</option>
                                            <option value="6">Qtd: 6+</option>
                                        </select>
                                        <input
                                            type="text"
                                            name="jogos"
                                            id="jogos"
                                            value="0"
                                            class="form-control w-25"
                                        />
                                    </div>
                                    <div class="cart-item">
                                        <label for="mesas">
                                            <span>
                                                <img
                                                    src="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/imgs/mesa.svg"
                                                    alt=""
                                                    onload="SVGInject(this)"
                                                />
                                            </span>
                                            Mesas avulsas</label
                                        >
                                        <select
                                            id="ateCincoMesas"
                                            name="ateCincoMesas"
                                            required
                                        >
                                            <option value="0">Qtd: 0</option>
                                            <option value="1">Qtd: 1</option>
                                            <option value="2">Qtd: 2</option>
                                            <option value="3">Qtd: 3</option>
                                            <option value="4">Qtd: 4</option>
                                            <option value="5">Qtd: 5</option>
                                            <option value="6">Qtd: 6+</option>
                                        </select>
                                        <input
                                            type="text"
                                            id="mesas"
                                            name="mesas"
                                            value="0"
                                            class="form-control w-25"
                                        />
                                    </div>
                                    <div class="cart-item">
                                        <label for="cadeiras"
                                            ><span>
                                                <img
                                                    src="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/imgs/cadeira.svg"
                                                    alt=""
                                                    onload="SVGInject(this)"
                                                />
                                            </span>
                                            Cadeiras avulsas
                                        </label>
                                        <select
                                            id="ateCincoCadeiras"
                                            name=""
                                            name="ateCincoCadeiras"
                                            required
                                        >
                                            <option value="0">Qtd: 0</option>
                                            <option value="1">Qtd: 1</option>
                                            <option value="2">Qtd: 2</option>
                                            <option value="3">Qtd: 3</option>
                                            <option value="4">Qtd: 4</option>
                                            <option value="5">Qtd: 5</option>
                                            <option value="6">Qtd: 6+</option>
                                        </select>
                                        <input
                                            type="text"
                                            id="cadeiras"
                                            name="cadeiras"
                                            value="0"
                                            class="form-control w-25"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="order-summary">
                                <h3>Resumo do pedido</h3>
                                <div class="itens-container">
                                    <div class="item">
                                        <span>Jogos:</span>
                                        <span class="valor" id="totalDosJogos"
                                            >R$ 00,00</span
                                        >
                                    </div>
                                    <div class="item">
                                        <span>Mesas avulsas:</span>
                                        <span class="valor" id="totalDasMesas"
                                            >R$ 00,00</span
                                        >
                                    </div>
                                    <div class="item">
                                        <span>Cadeiras avulsas:</span>
                                        <span
                                            class="valor"
                                            id="totalDasCadeiras"
                                            >R$ 00,00</span
                                        >
                                    </div>
                                    <div class="item">
                                        <span>Frete e manuseio:</span>
                                        <span class="valor" id="freteEManuseio"
                                            >R$ 00,00</span
                                        >
                                    </div>
                                </div>
                                <hr />
                                <div class="resumo-pedido">
                                    <div class="total">
                                        <strong>Total do pedido:</strong>
                                        <strong class="valor" id="totalDoPedido"
                                            >R$ 00,00</strong
                                        >
                                    </div>
                                </div>
                            </div>
                            <button class="btn-prosseguir">Prosseguir</button>
                        </div>

                        <div class="formCard">
                            <div class="form-contato">
                                <header>
                                    <div class="numero-etapa">
                                        <div>1</div>
                                        <h5>Pedido</h5>
                                    </div>
                                    <div class="numero-etapa">
                                        <div>2</div>
                                        <h5>Entrega</h5>
                                    </div>
                                    <div class="numero-etapa-certa">
                                        <div>3</div>
                                        <h5>Contato</h5>
                                    </div>
                                </header>
                                <div>
                                    <div>
                                        <label for="cpf"
                                            ><span>*</span> CPF</label
                                        >
                                        <input
                                            type="text"
                                            id="cpf"
                                            name="cpf"
                                            required
                                            class="form-control"
                                            placeholder="Ex.: 000.0000.000-00"
                                        />
                                        <div class="invalid-feedback">
                                            Insira um CPF válido.
                                        </div>
                                    </div>
                                    <div>
                                        <label for="nome"
                                            ><span>*</span> Nome completo</label
                                        >
                                        <input
                                            type="text"
                                            id="nome"
                                            name="nome"
                                            required
                                            class="form-control"
                                            placeholder="Insira seu nome"
                                        />
                                        <div class="invalid-feedback">
                                            Insira seu Nome.
                                        </div>
                                    </div>
                                    <div>
                                        <label for="telefone"
                                            ><span>*</span>Telefone para
                                            contato</label
                                        >
                                        <input
                                            type="text"
                                            id="telefone"
                                            name="telefone"
                                            required
                                            class="form-control"
                                            placeholder="Ex.: (11) 90000-0000"
                                        />
                                    </div>
                                    <div class="invalid-feedback">
                                        Insira seu Telefone.
                                    </div>
                                </div>

                                <div>
                                    <p
                                        id="errorMessaeParagraph"
                                        class="text-danger d-none"
                                    ></p>
                                </div>

                                <button class="btn-prosseguir" type="submit">
                                    Finalizar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div
                id="confirmation-popup"
                style="display: none"
                class="card h-full align-items-center justify-content-center"
            >
                <h1 class="text-center">
                    PEDIDO FEITO <span class="text-primary">COM SUCESSO!</span>
                </h1>
                <p class="text-center w-75">
                    Entraremos em contato no telefone fornecido para quaisquer
                    atualizações em seu pedido!
                </p>
            </div>

            <div class="direita">
                <span></span>
            </div>
        </div>

        <script>
            const errorMessaeParagraph = $("#errorMessaeParagraph");

            $("form#slides-container").on("submit", function (e) {
                e.preventDefault();

                $.ajax({
                    url: "<?=$isLocal ? "/bgfestas" : ""?>/controllers/processPedido",
                    type: "POST",
                    dataType: "json",
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response.success) {
                            $("#container-form").hide();
                            $("#confirmation-popup").css("display", "flex");
                        } else {
                            errorMessaeParagraph.show();
                            errorMessaeParagraph.text(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                        console.log(xhr);
                        console.log(xhr.responseText);

                        errorMessaeParagraph.show();
                        errorMessaeParagraph.text("Houve um erro: " + error);
                    },
                });
            });
        </script>
    </body>
</html>
