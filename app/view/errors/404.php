<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Página não encontrada</title>
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
        <style>
            html, body {
                height: 100%;
            }
            @media screen and (min-width: 576px) {
                .imgContainer {
                    min-width: 540px;
                    max-width: 540px;
                }
            }

            .errorContainer {
                max-width: 960px;
            }

            .errorContainer > * {
                flex: 1 1 0;
            }
        </style>
    </head>
    <body>
        <div class="w-100 h-100 d-flex align-items-center justify-content-center">
            <div class="errorContainer container d-md-flex align-items-center">
                <div class="imgContainer mx-auto">
                    <img
                        class="w-100"
                        src="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/imgs/404.svg" alt="404">
                </div>
                <div class="text-md-start text-center">
                    <h1 class="text-primary">OOPS! PÁGINA NÃO ENCONTRADA</h1>
                    <p>A página que você está procurando talvez tenha sido removida, tenha tido seu nome mudado ou está temporariamente indisponível</p>
                    <a  class="btn btn-primary d-block"
                        href=<?=$isLocal ? "/bgfestas" : "/"?>>Voltar para Segurança</a>
                </div>

            </div>
        </div>
    </body>
</html>
