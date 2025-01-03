<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <title>BGFESTAS</title>
        <link rel="stylesheet" href="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/css/landingpage.css" />
        <script src="<?=$isLocal ? "/bgfestas" : ""?>/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script
            src="https://kit.fontawesome.com/4c0a49f720.js"
            crossorigin="anonymous"
        ></script>
        <script src="<?=$isLocal ? "/bgfestas" : ""?>/node_modules/jquery/dist/jquery.min.js"></script>
        <script src="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/js/questions.js" defer></script>
        <link
            rel="shortcut icon"
            href="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/imgs/favicon.ico"
            type="image/x-icon"
        />
    </head>
    <body>
        <section id="hero" d="blue">
            <div>
                <h1>Alugue mesas e cadeiras <span>sem complicações</span></h1>
                <p>
                    Há mais de dez anos sendo a solução ideal para seus eventos!
                    Agendamento ágil, entrega pontual.
                </p>
                <a href="fazerpedido">
                    <button type="button" class="btn btn-primary">
                        Faça Sua Reserva
                    </button>
                </a>
            </div>
            <div id="heroImgContainer">
                <span></span>
            </div>
        </section>

        <section id="prices" class="container section-padding section">
            <h2 class="title">nossos preços</h2>

            <div>
                <div class="card shadow-sm">
                    <img
                        src="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/imgs/jogo.jpg"
                        class="card-img-top"
                        alt="jogo de mesas e cadeiras"
                    />
                    <div class="card-body">
                        <h5 class="card-title">Jogo (1 mesa + 4 cadeiras)</h5>
                        <p class="card-text"><span>R$ </span>10,00</p>
                    </div>
                </div>
                <div class="card shadow-sm">
                    <img
                        src="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/imgs/mesa.jpg"
                        class="card-img-top"
                        alt="mesas"
                    />
                    <div class="card-body">
                        <h5 class="card-title">Mesa Avulsa</h5>
                        <p class="card-text"><span>R$ </span>5,00</p>
                    </div>
                </div>
                <div class="card shadow-sm">
                    <img
                        src="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/imgs/cadeira.jpg"
                        class="card-img-top"
                        alt="cadeiras"
                    />
                    <div class="card-body">
                        <h5 class="card-title">Cadeira Avulsa</h5>
                        <p class="card-text"><span>R$ </span>2,00</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="promisses" class="section-padding section">
            <div class="container">
                <div>
                    <h2 class="title">
                        Nossas Promessas para o Seu Evento Perfeito
                    </h2>

                    <ul>
                        <li>Pontualidade</li>
                        <li>Profissionalismo</li>
                        <li>Respeito ao Cliente</li>
                        <li>Atendimento Especializado</li>
                    </ul>

                    <a href="fazerpedido">
                        <button type="button" class="btn btn-primary">
                            Faça Sua Reserva
                        </button>
                    </a>
                </div>
                <div class="grid">
                    <div class="promisse">
                        <div class="promisse-header">
                            <i class="fa fa-calendar-o" aria-hidden="true"></i>
                            <h5>Reserva</h5>
                        </div>
                        <p>
                            Reservamos sem sinal! Pague apenas quando receber os
                            produtos.
                        </p>
                    </div>

                    <div class="promisse">
                        <div class="promisse-header">
                            <i class="fa-regular fa-money-bill-1"></i>
                            <h5>Pagamento</h5>
                        </div>

                        <p>Aceitamos Pix e Dinheiro.</p>
                    </div>

                    <div class="promisse">
                        <div class="promisse-header">
                            <i class="fa-solid fa-arrows-turn-to-dots"></i>
                            <h5>Entregas e Retiradas</h5>
                        </div>

                        <p>
                            Pontualidade e respeito ao horário combinado para
                            que não haja atraso no seu evento.
                        </p>
                    </div>

                    <div class="promisse">
                        <div class="promisse-header">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                            <h5>Atendimento Rápido</h5>
                        </div>

                        <p>Ficou alguma dúvida? Entre em contato conosco!</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="feedback" class="section-padding container section">
            <h2 class="title">O Que Nossos Clientes Dizem</h2>
            <div>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="profile"></div>
                            <h5>Maria S.</h5>
                        </div>
                        <p class="card-text">
                            "A equipe foi incrível! Desde o primeiro contato até
                            a retirada dos itens, tudo foi impecável. Meu evento
                            não poderia ter sido melhor!"
                        </p>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="profile"></div>
                            <h5>Carlos M.</h5>
                        </div>
                        <p class="card-text">
                            "O serviço de atendimento ao cliente foi excelente.
                            Fizeram de tudo para que minha festa fosse um
                            sucesso, e entregaram exatamente no horário
                            combinado. Recomendo!"
                        </p>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="profile"></div>
                            <h5>Fernanda R.</h5>
                        </div>
                        <p class="card-text">
                            "A pontualidade e o profissionalismo me
                            surpreenderam. Os produtos estavam em perfeito
                            estado, e a experiência foi tranquila e sem
                            preocupações."
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section id="faq" class="section-padding section">
            <div class="container">
                <div>
                    <h2 class="title">Respostas para suas perguntas</h2>
                </div>
                <div>
                    <div class="question border-bottom border-2 border-primary">
                        <div class="question-header">
                            <h5>Como funciona o cálculo do preço?</h5>
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <div class="question-body">
                            <p>
                                Todos os pedidos têm um valor mínimo de R$
                                50,00. Se o pedido incluir, por exemplo, três
                                jogos de mesa e cadeiras, o valor será R$ 50,00,
                                composto por R$ 30,00 pelos jogos e R$ 20,00
                                pelo frete. Se o valor dos itens for maior ou
                                igual a R$ 50,00, o frete será gratuito, e você
                                pagará apenas pelos itens escolhidos.
                            </p>
                        </div>
                    </div>
                    <div class="question border-bottom border-2 border-primary">
                        <div class="question-header">
                            <h5>
                                Como faço para cancelar ou modificar um pedido?
                            </h5>
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <div class="question-body">
                            <p>
                                Você pode cancelar ou modificar seu pedido até
                                24 horas antes da data de entrega. Entre em
                                contato conosco pelo WhatsApp (11)92005-6929
                                para realizar qualquer alteração.
                            </p>
                        </div>
                    </div>
                    <div class="question border-bottom border-2 border-primary">
                        <div class="question-header">
                            <h5>Quais são as formas de pagamento aceitas?</h5>
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <div class="question-body">
                            <p>
                                Aceitamos pagamento via Pix ou dinheiro. O
                                pagamento será feito na entrega.
                            </p>
                        </div>
                    </div>
                    <div class="question border-bottom border-2 border-primary">
                        <div class="question-header">
                            <h5>
                                O que acontece se algum item estiver danificado
                                após o uso?
                            </h5>
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <div class="question-body">
                            <p>
                                Caso algum item esteja danificado após o uso,
                                faremos uma avaliação para determinar os custos
                                de reparo ou substituição. O valor será cobrado
                                conforme o nível de dano.
                            </p>
                        </div>
                    </div>
                    <div class="question border-bottom border-2 border-primary">
                        <div class="question-header">
                            <h5>Como posso pedir meu recibo?</h5>
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <div class="question-body">
                            <p>
                                Você pode solicitar o seu recibo após a retirada
                                dos produtos. Ele será enviado no WhatsApp que
                                forneceu para contato no formulário de reserva.
                            </p>
                        </div>
                    </div>
                    <div class="question border-bottom border-2 border-primary">
                        <div class="question-header">
                            <h5>
                                Onde vocês estão localizados e quais regiões
                                atendem?
                            </h5>
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <div class="question-body">
                            <p>
                                Nossa sede está no bairro Gopoúva. Atualmente,
                                realizamos entregas exclusivamente na região
                                central de Guarulhos.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="cta" class="section">
            <div class="container">
                <h2>Garanta a Melhor Experiência para Seus Convidados!</h2>
                <a href="fazerpedido">
                    <button type="button" class="btn btn-primary">
                        Faça Sua Reserva
                    </button>
                </a>
            </div>
        </section>

        <footer class="border-top border-2 border-primary">
            <div class="container">
                <div class="footer-content">
                    <span class="logo">bgfestas</span>
                    <p id="copyright">©Copyright 2024 BGFESTAS</p>
                </div>
                <div class="footer-content">
                    <p>
                        Viela Pires do Rio, 121, Gopoúva, Guarulhos-SP, 07091250
                    </p>
                    <p>(11) 92005-6929</p>
                </div>
            </div>
        </footer>
    </body>
</html>
