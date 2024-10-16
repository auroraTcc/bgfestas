<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Login</title>
        <link rel="stylesheet" href="../../../../public/assets/css/admin.css" />
        <script src="../../../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script
            src="https://kit.fontawesome.com/4c0a49f720.js"
            crossorigin="anonymous"
        ></script>
        <script src="../../../../node_modules/jquery/dist/jquery.min.js"></script>
        <link
            rel="shortcut icon"
            href="../../../../public/assets/imgs/favicon.ico"
            type="image/x-icon"
        />
        <script src="../../../../node_modules/@iconfu/svg-inject/dist/svg-inject.min.js"></script>
        <script src="../../../../public/assets/js/admin.js" defer></script>
        <style>
            html,
            body {
                min-height: 100svh;
            }

            #carrousselSlider {
                transition: transform .4s ease-in-out;
            }

            @media screen and (min-width: 768px) {
               .carousselSlideWidth {
                    min-width: 720px;
                    max-width: 720px;
               }
            }
        </style>
    </head>
    <body style="background-color: #ede8e1;" class="d-flex align-items-center justify-content-center">
        <div id="carroussel" style="background-color: #fbf7f4;"  class="carousselSlideWidth overflow-hidden rounded shadow-sm border pe-0 ps-0">
            <div id="carrousselSlider" class="w-100 d-flex carousselSlideWidth ">
                <div class="w-100  p-3 bg-primary-bg carousselSlideWidth">
                    <div class="d-flex flex-column gap-1">
                        <h4 class="fw-semibold d-flex gap-2 align-items-center"><i class="fa-solid fa-right-to-bracket text-primary"></i> Bem-vindo de volta! :)</h4>
                        <p>Antes de acessar sua área, por favor, preencha o formulário abaixo para verificarmos sua identidade.</p>
                    </div>
                    <form class="d-flex flex-column gap-3 needs-validation" id="loginForm" novalidate>
                        <div>
                            <label for="cpf" class="d-flex align-items-center fw-bold gap-1"><span class="text-primary">*</span>CPF</label>
                            <div>
                                <input name="cpf" id="cpf" required type="text" class="form-control" placeholder="Digite seu CPF">
                                <div class="invalid-feedback">
                                    Insira seu CPF.
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="senha" class="d-flex align-items-center fw-bold gap-1"><span class="text-primary">*</span>Senha</label>
                            <div>
                                <input name="senha" id="senha" required type="password" class="form-control"  placeholder="Insira sua senha">
                                <div class="invalid-feedback">
                                    Insira sua senha.
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Entrar</button>
                    </form>
                </div>

                <div class="w-100 p-3 bg-primary-bg carousselSlideWidth" >
                    <div class="d-flex flex-column gap-1">
                        <h4 class="fw-semibold d-flex gap-2 align-items-center"><i class="fa-solid fa-address-card text-primary"></i>É seu primeiro acesso?</h4>
                        <p>Vamos alterar a sua senha para garantir sua segurança!</p>
                    </div>

                    <form class="d-flex flex-column gap-3 needs-validation" id="loginForm" novalidate>
                        <div>
                            <label for="newPassword" class="d-flex align-items-center fw-bold gap-1"><span class="text-primary">*</span>Insira uma nova senha</label>
                            <div>
                                <input name="newPassword" id="newPassword" required type="password" class="form-control" placeholder="Digite sua nova senha">
                                <div class="invalid-feedback">
                                    Insira uma nova senha.
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="newPasswordRepeat" class="d-flex align-items-center fw-bold gap-1"><span class="text-primary">*</span>Repita sua senha</label>
                            <div>
                                <input name="newPasswordRepeat" id="newPasswordRepeat" required type="password" class="form-control" placeholder="Digite sua nova senha novamente">
                                <div class="invalid-feedback">
                                    Insira novamente a sua senha
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Entrar</button>
                    </form>
                </div>
            </div>
        </div>

        <script>
            let isFirstAcess = true;

            $("form#loginForm").on("submit", function (e) {
                e.preventDefault();

                if (isFirstAcess) {
                    $("#carrousselSlider").css(
                        "transform",
                        "translateX(-100%)"
                    );
                }
            })
        </script>
    </body>
</html>
