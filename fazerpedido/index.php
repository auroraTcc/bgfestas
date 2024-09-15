<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="../css/fazerpedido.css" />
        <title>Fazer Pedido</title>

        <link
            rel="stylesheet"
            href="../node_modules/bootstrap/dist/css/bootstrap.min.css"
        />
        <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script
            src="https://kit.fontawesome.com/4c0a49f720.js"
            crossorigin="anonymous"
        ></script>
        <script src="../node_modules/jquery/dist/jquery.min.js"></script>
        <script src="../node_modules/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
        <script src="../js/pedido.js" defer></script>
        <link
            rel="shortcut icon"
            href="../imgs/favicon.ico"
            type="image/x-icon"
        />
    </head>

    <body>
        <div class="geral">
            <div class="esquerda">
                <div id="carrossel">
                    <form
                        id="slides-container"
                        method="POST"
                        class="needs-validation"
                        novalidate
                        action="../controllers/processPedido.php"
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
                                    <label for="endereco"><span>*</span>Endereço</label>
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
                                    <label for="numero"><span>*</span>Número</label>
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
                                    <label for="bairro"><span>*</span>Bairro</label>
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
                                    <label for="cidade"><span>*</span>Cidade</label>
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
                            <div class="form-section">
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
                                    />
                                </div>
                            </div>
                            <div class="form-section">
                                <div>
                                    <label for="dataDeRetirada"
                                        ><span>*</span> Data de Retirada</label
                                    >
                                    <input
                                        type="date"
                                        name="dataDeRetirada"
                                        id="dataDeRetirada"
                                        required
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
                                    />
                                </div>
                            </div>

                            <div class="form-carrinho">
                                <h3>Carrinho de compras</h3>
                                <div class="carrinho">
                                    <div class="cart-item">
                                        <label for="jogos">
                                            <span>
                                                <img
                                                    src="../imgs/jogo.svg"
                                                    alt=""
                                                />
                                            </span>
                                            Jogos (1 mesa + 4 cadeiras)
                                        </label>
                                        <select id="jogos" name="jogos">
                                            <?php
                                                for ($i=0; $i <= 5; $i++) {
                                                ?>
                                                    <option value="<?=$i?>">Qtd: <?=$i?></option>
                                                <?php
                                                }
                                            ?>
                                            <option value="">Qtd: 6+</option>
                                        </select>
                                    </div>
                                    <div class="cart-item">
                                        <label for="mesas">
                                            <span>
                                                <img
                                                    src="../imgs/mesa.svg"
                                                    alt=""
                                                />
                                            </span>
                                            Mesas avulsas</label
                                        >
                                        <select id="mesas" name="mesas">
                                            <?php
                                                for ($i=0; $i <= 5; $i++) {
                                                ?>
                                                    <option value="<?=$i?>">Qtd: <?=$i?></option>
                                                <?php
                                                }
                                            ?>
                                            <option value="">Qtd: 6+</option>
                                        </select>
                                    </div>
                                    <div class="cart-item">
                                        <label for="cadeiras"
                                            ><span>
                                                <img
                                                    src="../imgs/cadeira.svg"
                                                    alt=""
                                                />
                                            </span>
                                            Cadeiras avulsas
                                        </label>
                                        <select id="cadeiras" name="cadeiras">
                                            <?php
                                                for ($i=0; $i <= 5; $i++) {
                                                ?>
                                                    <option value="<?=$i?>">Qtd: <?=$i?></option>
                                                <?php
                                                }
                                            ?>
                                            <option value="">Qtd: 6+</option>
                                        </select>
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
                                <button class="btn-prosseguir" type="submit">
                                    Finalizar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="direita">
                <span></span>
            </div>
        </div>
    </body>
</html>