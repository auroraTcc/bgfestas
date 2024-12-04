<?php
    $isPasswordReset = isset($_GET["resetarSenha"]);
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Login</title>
        <link rel="stylesheet" href="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/css/admin.css" />
        <script src="<?=$isLocal ? "/bgfestas" : ""?>/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script
            src="https://kit.fontawesome.com/4c0a49f720.js"
            crossorigin="anonymous"
        ></script>
        <script src="<?=$isLocal ? "/bgfestas" : ""?>/node_modules/jquery/dist/jquery.min.js"></script>
        <link
            rel="shortcut icon"
            href="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/imgs/favicon.ico"
            type="image/x-icon"
        />
        <script src="<?=$isLocal ? "/bgfestas" : ""?>/node_modules/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
        <script src="<?=$isLocal ? "/bgfestas" : ""?>/node_modules/@iconfu/svg-inject/dist/svg-inject.min.js"></script>
        <script src="<?=$isLocal ? "/bgfestas" : ""?>/public/assets/js/admin.js" defer></script>
        <style>
            html,
            body {
                min-height: 100svh;
            }

            #carrousselSlider {
                transition: transform 0.4s ease-in-out;
            }

            #carroussel {
                height: 100svh;
            }

            .carousselSlideWidth {
                min-width: 100vw;
                max-width: 100vw;
            }

            @media screen and (min-width: 768px) {
                #carroussel {
                    height: unset;
                }

                .carousselSlideWidth {
                    min-width: 720px;
                    max-width: 720px;
                }
            }
        </style>
    </head>
    <body
        style="background-color: #ede8e1"
        class="d-flex align-items-center justify-content-center"
    >
        <div
            id="carroussel"
            style="background-color: #fbf7f4"
            class="carousselSlideWidth overflow-hidden rounded shadow-sm border pe-0 ps-0"
        >
            <div id="carrousselSlider"
                style=" <?php
                    echo $isPasswordReset
                        ? "transform: translateX(-200%)"
                        : ""
                ?>"
            class="w-100 d-flex carousselSlideWidth">
                <div class="w-100 p-md-3 p-4 bg-primary-bg carousselSlideWidth">
                    <div class="d-flex flex-column gap-1">
                        <h4 class="fw-semibold d-flex gap-2 align-items-center">
                            <i
                                class="fa-solid fa-right-to-bracket text-primary"
                            ></i>
                            Bem-vindo de volta! :)
                        </h4>
                        <p>
                            Antes de acessar sua área, por favor, preencha o
                            formulário abaixo para verificarmos sua identidade.
                        </p>
                    </div>
                    <form
                        class="d-flex flex-column gap-3 needs-validation"
                        id="loginForm"
                        novalidate
                    >
                        <div>
                            <label
                                for="cpf"
                                class="d-flex align-items-center fw-bold gap-1"
                                ><span class="text-primary cpf">*</span>CPF</label
                            >
                            <div>
                                <input
                                    name="cpf"
                                    id="cpf"
                                    required
                                    type="text"
                                    class="form-control cpf"
                                    placeholder="Digite seu CPF"
                                />
                                <div class="invalid-feedback">
                                    Insira seu CPF.
                                </div>
                            </div>
                        </div>
                        <div>
                            <label
                                for="senha"
                                class="d-flex align-items-center fw-bold gap-1"
                                ><span class="text-primary">*</span>Senha</label
                            >
                            <div>
                                <input
                                    name="senha"
                                    id="senha"
                                    required
                                    type="password"
                                    class="form-control"
                                    placeholder="Insira sua senha"
                                />
                                <div class="invalid-feedback">
                                    Insira sua senha.
                                </div>
                            </div>
                        </div>

                        <div>
                            <p class="text-danger" id="loginErrorMessage"></p>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Entrar
                        </button>

                        <div>
                            <a href="?resetarSenha" class="text-decoration-none">
                                Esqueceu a senha?
                            </a>
                        </div>
                    </form>
                </div>

                <div class="w-100 p-md-3 p-4 bg-primary-bg carousselSlideWidth">
                    <div class="d-flex flex-column gap-1">
                        <h4 class="fw-semibold d-flex gap-2 align-items-center">
                            <i class="fa-solid fa-address-card text-primary"></i
                            >É seu primeiro acesso?
                        </h4>
                        <p>
                            Vamos alterar a sua senha para garantir sua
                            segurança!
                        </p>
                    </div>

                    <form
                        class="d-flex flex-column gap-3 needs-validation"
                        id="UpdatePassword"
                        novalidate
                    >
                        <div>
                            <label
                                for="newPassword"
                                class="d-flex align-items-center fw-bold gap-1"
                                ><span class="text-primary">*</span>Insira uma
                                nova senha</label
                            >
                            <div>
                                <input
                                    name="newPassword"
                                    id="newPassword"
                                    required
                                    type="password"
                                    class="form-control"
                                    placeholder="Digite sua nova senha"
                                />
                                <div class="invalid-feedback">
                                    Insira uma nova senha.
                                </div>
                            </div>
                        </div>

                        <div>
                            <label
                                for="newPasswordRepeat"
                                class="d-flex align-items-center fw-bold gap-1"
                                ><span class="text-primary">*</span>Repita sua
                                senha</label
                            >
                            <div>
                                <input
                                    name="newPasswordRepeat"
                                    id="newPasswordRepeat"
                                    required
                                    type="password"
                                    class="form-control"
                                    placeholder="Digite sua nova senha novamente"
                                />
                                <div class="invalid-feedback">
                                    Insira novamente a sua senha
                                </div>
                            </div>
                        </div>

                        <div>
                            <p
                                class="text-danger"
                                id="UpdatePasswordErrorMessage"
                            ></p>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Entrar
                        </button>
                    </form>
                </div>

                <div class="w-100 p-md-3 p-4 bg-primary-bg carousselSlideWidth">
                    <div class="d-flex flex-column gap-1">
                        <h4 class="fw-semibold d-flex gap-2 align-items-center">
                            <i class="fa-solid fa-key text-primary"></i>
                            Esqueceu sua senha?
                        </h4>
                        <p>
                            Ao preencher esse formulário, sua senha retornará ao padrão!
                        </p>
                    </div>

                    <form
                        class="d-flex flex-column gap-3 needs-validation"
                        id="ResetPassword"
                        novalidate
                    >
                        <div>
                            <label
                                for="userCPF"
                                class="d-flex align-items-center fw-bold gap-1"
                                ><span class="text-primary">*</span>CPF:</label
                            >
                            <div>
                                <input
                                    name="userCPF"
                                    id="userCPF"
                                    required
                                    type="string"
                                    class="form-control cpf"
                                    placeholder="Digite seu CPF"
                                    maxlength="14"
                                />
                                <div class="invalid-feedback">
                                    Insira um cpf válido.
                                </div>
                            </div>
                        </div>

                        <div>
                            <p
                                class="text-danger d-none"
                                id="resetPasswordErrorMessage"
                            ></p>
                            <p
                                class="text-success d-none"
                                id="resetPasswordSuccessMessage"
                            ></p>
                        </div>

                        <div class="">
                            <button type="submit" class="btn btn-primary w-100 ">
                                Resetar senha
                            </button>
                            <a href="?" class="btn w-100 mt-2">Entrar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            $("form#loginForm").on("submit", function (e) {
                e.preventDefault();

                $.ajax({
                    url: "<?=$isLocal ? "/bgfestas/" : "/"?>controllers/processLogin",
                    type: "POST",
                    dataType: "json",
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response.success) {
                            user = response.funcionario;

                            if (user.primAcess) {
                                $("#carrousselSlider").css(
                                    "transform",
                                    "translateX(-100%)"
                                );
                            } else {
                                window.location.href = "/" + response.redirect;
                            }
                        } else {
                            $("#loginErrorMessage").text(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Erro na requisição Ajax:", xhr.responseText);
                    },
                });
            });

            $("form#UpdatePassword").on("submit", function (e) {
                e.preventDefault();

                const newPassword = $("#newPassword").val();
                const newPasswordRepeat = $("#newPasswordRepeat").val();
                const cpf = $("#cpf").val();

                if (newPassword !== newPasswordRepeat) {
                    $("#resetPasswordErrorMessage").text(
                        "As senhas não coincidem."
                    );
                    return;
                }

                $.ajax({
                    url: "<?=$isLocal ? "/bgfestas/" : "/"?>controllers/processAlterarSenha",
                    type: "POST",
                    dataType: "json",
                    data: {
                        cpf: cpf,
                        newPassword: newPassword,
                        newPasswordRepeat: newPasswordRepeat,
                    },
                    success: function (response) {
                        $("#UpdatePasswordErrorMessage").text(response.message);
                        // console.log("/" + response.redirect)
                        window.location.href = "/" + response.redirect;
                    },
                    error: function (xhr, status, error) {
                        console.error(
                            "Erro na requisição Ajax:",
                            xhr.responseText
                        );
                        $("#UpdatePasswordErrorMessage").text(
                            "Erro ao processar a solicitação. Tente novamente mais tarde."
                        );
                    },
                });
            });
        
            $("form#ResetPassword").on("submit", function(e) {
                e.preventDefault()

                if(!validarCPF($("input[id='userCPF']").val())) {
                    $("input[id='userCPF']").addClass("is-invalid").removeClass("is-valid");
                    return
                } else {
                    $("input[id='userCPF']").addClass("is-valid").removeClass("is-invalid");
                }
            

                $.ajax({
                    url: "<?=$isLocal ? "/bgfestas/" : "/"?>controllers/processForgotPassword",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function (response) {
                        console.log($("form#ResetPassword").serialize());
                        if(response.success) {
                            
                            $("#resetPasswordSuccessMessage").text(response.message).removeClass("d-none").addClass("d-block");
                        } else {
                            $("#resetPasswordErrorMessage").text(response.message).removeClass("d-none").addClass("d-block");

                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(
                            "Erro na requisição Ajax:",
                            xhr.responseText
                        );
                        $("#resetPasswordErrorMessage").text(
                            "Erro ao processar a solicitação. Tente novamente mais tarde."
                        ).removeClass("d-none").addClass("d-block");
                    },
                })
            })
        </script>
    </body>
</html>
