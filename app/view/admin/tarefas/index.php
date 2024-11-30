<?php
    $abbreviations = [
        "entrega" => "Entg",
        "retirada" => "Ret"
    ];
    setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'pt_BR.utf8');
    $dateFormatter = new IntlDateFormatter(
        'pt_BR', 
        IntlDateFormatter::LONG, 
        IntlDateFormatter::NONE 
    );
    $dateFormatter->setPattern('dd MMM');
?>


<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Tarefas</title>
        <link rel="stylesheet" href="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/css/admin.css" />
        <script src="<?=$isLocal ? "/bgfestas" : ""?>/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script
            src="https://kit.fontawesome.com/4c0a49f720.js"
            crossorigin="anonymous"
        ></script>
        <script src="<?=$isLocal ? "/bgfestas" : ""?>/node_modules/jquery/dist/jquery.min.js"></script>
        <script src="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/js/admin.js"></script>
        <link
            rel="shortcut icon"
            href="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/imgs/favicon.ico"
            type="image/x-icon"
        />
        <script src="<?=$isLocal ? "/bgfestas" : ""?>/node_modules/@iconfu/svg-inject/dist/svg-inject.min.js"></script>
    </head>
    <body>
        <?php
            include_once "$rootPath/app/components/header.php";
        ?>


        <main>
            <section class="container">
                <div
                    class="d-md-flex container align-items-center justify-content-between mb-4"
                >
                    <div class="title-container">
                        <h2>Tarefas</h2>
                        <p class="mb-2">
                            Gerencie todas as entregas e atividades dos
                            funcionários de forma centralizada. Aqui, você pode
                            adicionar novas tarefas, atribuí-las a funcionários,
                            acompanhar o progresso e atualizar o status das
                            entregas em tempo real. Utilize as funcionalidades
                            abaixo para garantir que todas as suas tarefas sejam
                            realizadas de forma eficiente e sem falhas.
                        </p>
                    </div>
                </div>

                <section class="container" id="proximasTarefas">
                    <div id="tarefasContainer">
                    <?php 
                        $resultados;
                        $order = new Pedido($conn);
                        $client = new Cliente($conn);

                        if ($user->getCargo() === "Gerente" || $user->getCargo() === "Administrador") {
                            $resultados = $order->getAllPedidos();
                        } else {
                            $resultados =  $order->getPedidosByCpfFunc($user->getCPF());
                        }

                        if ($resultados) {
                            foreach ($resultados as $pedido) {
                                
                                $order = new Pedido($conn);
                                $order->populate($pedido);
                                
                                if($order->getStts() === "finalizado") {
                                    continue;
                                }

                                $dataHora = $pedido["data" . $abbreviations[$pedido['stts']]] . ' ' . $pedido["hora" . $abbreviations[$pedido['stts']]];
                                $dateTime = new DateTime($dataHora);
                                $formattedDate = $dateFormatter->format($dateTime);
                                $formattedTime = $dateTime->format('H:i') . 'h';
                                $cliente = $client->getClienteByCpf($pedido["cpfCliente"]);
                                
                                ?>
                                
                                <a  style="text-decoration: none"
                                    class="card pedido d-flex" 
                                    data-type="<?=$order->getStts()?>"
                                    href="<?=$isLocal ? "/bgfestas" : ""?>/admin/tarefas/<?=$order->getIdPedido()?>"
                                >
                                    <div class="card-header">
                                        <div>
                                            <h4 class="card-title"><?=$order->getNomeCliente()?></h4> 
                                            <p><?=$formattedDate?> <?=$formattedTime?></p>
                                        </div>
                                        <span><?=$order->getStts()?></span>
                                    </div>

                                    <div class="card-body">
                                        <p class="card-text">
                                            <?=$order->getEndereco()?>, <?=$order->getNumero()?><?php if($order->getComplemento()) { echo ", ". $order->getComplemento(); } ?> - <?=$order->getBairro()?> - <?=$order->getCidade()?>
                                        </p>
                                        <div>
                                            <?php foreach($order->getItensCarrinho() as $item) { ?>
                                                <div class="itemCount">
                                                    <img
                                                        src="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/imgs/<?=$item["nome"]?>.svg"
                                                        onload="SVGInject(this)"
                                                    />
                                                    <p><?=$item["quantidade"]?> <?=$item["nome"]?>(s)</p>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <div>
                                            <i class="fa-solid fa-circle-user"></i>
                                            <h5>
                                                Responsável:
                                                <span><?=$order->getNomeFuncionario()?></span> 
                                            </h5>
                                        </div>

                                        <div class="whatsapp-button bg-primary d-flex align-items-center justify-content-center rounded-pill text-bg-secondary"
                                            style="height: 2.5rem; width: 2.5rem;" 
                                            data-telefone="<?=$cliente['telefone']?>"
                                        >
                                            <i class="fa-solid fa-comments"></i>
                                        </div>
                                    </div>
                                </a>

                                
                                <?php
                            }
                        } else {
                            echo "<h4>Ainda não há pedidos</h4>";
                        }
                    ?>
                    </div>
                </section>
            </section>

            
        </main>

        <script>
            const whatsappButtons = document.querySelectorAll('.whatsapp-button');

            whatsappButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault()
                    e.stopPropagation(); 
                    const phone = button.getAttribute('data-telefone');
                    if (phone) {
                        const whatsappLink = `https://api.whatsapp.com/send?phone=${phone}&text=Olá! Sou da BGFESTAS. Recentemente você fez um pedido conosco e gostaria de falar contigo.`;
                        window.open(whatsappLink, '_blank'); 
                    }
                });
            });
        </script>
    </body>
</html>
