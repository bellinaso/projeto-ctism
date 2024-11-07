<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookease - Cadastro</title>
    <link rel="stylesheet" href="/public/css/register_login.css">
    <link rel="stylesheet" href="/public/css/register.css">
    <link rel="stylesheet" href="/public/css/components/red_button.css">
</head>

<body>
    <?php
    require_once '../controller/authentication_controller.php';
    require_once '../controller/redirect_controller.php';

    if (is_logged()) {
        redirect_to('index.php');
    }
    ?>
    <main>
        <div class="form_section">
            <header>
                <div class="logo">
                    <a href="/view/index.php">
                        <img src="/public/images/logos_horizontal/logo1_black.svg" alt="" class="logo_image">
                    </a>
                </div>
                <div class="go_back">
                    <a href="/view/index.php">
                        <img src="/public/images/go_back.svg" alt="" class="go_back_image">
                        Voltar
                    </a>
                </div>
            </header>
            <div class="register_form">
                <h1>Crie sua conta!</h1>
                <?php
                if (isset($_REQUEST) && isset($_REQUEST['code'])) {
                    switch ($_REQUEST['code']) {
                        case 422:
                            echo '
                            <div class="form_error">
                                <span>Algo deu errado!</span> Verifique se todos os campos foram corrigidos corretamente e tente novamente.
                            </div>
                            ';
                            break;
                    }
                }
                ?>
                <form method="post" action="/controller/register_controller.php">

                    <div class="form_input">
                        <label for="complete_name">
                            Nome completo
                        </label>
                        <input type="text" name="complete_name" id="complete_name" placeholder="Insira o seu nome completo">
                    </div>

                    <div class="form_input">
                        <label for="email">
                            Endereço e-mail
                        </label>
                        <input type="email" name="email" id="email" placeholder="Insira seu endereço e-mail">
                    </div>

                    <div class="form_input">
                        <label for="phone">
                            Número de telefone
                        </label>
                        <input type="phone" name="phone" id="phone" placeholder="Insira apenas números com DDD">
                    </div>

                    <div class="form_input">
                        <label for="cpf">
                            CPF
                        </label>
                        <input type="text" name="cpf" id="cpf" oninput="cpf_format(this)" onkeydown="pressed_key(event, this)" maxlength="14" placeholder="Insira apenas números">
                    </div>

                    <div class="form_input">
                        <label for="password">
                            Crie uma senha
                        </label>
                        <input type="password" name="password" id="password" placeholder="Crie uma senha forte">
                    </div>

                    <div class="form_input">
                        <label for="password_confirm">
                            Confirme sua senha
                        </label>
                        <input type="password" name="password_confirm" id="password_confirm" placeholder="Digite a senha novamente para confirmar">
                    </div>

                    <div class="form_input_group">
                        <div class="form_input">
                            <label for="state">
                                Qual estado você mora?
                            </label>
                            <select name="state" id="state">
                                <option value="" disabled selected>Selecione um estado</option>
                                <option value="">Rio Grande do Sul</option>
                            </select>
                        </div>
                        <div class="form_input">
                            <label for="city">
                                Qual cidade você mora?
                            </label>
                            <select name="city" id="city">
                                <option value="" disabled selected>Selecione uma cidade</option>
                                <option value="">Santa Maria</option>
                            </select>
                        </div>
                    </div>

                    <!-- https://blog.logrocket.com/creating-custom-select-dropdown-css/ -->

                    <div class="submit red_button">
                        <button type="submit">Continuar</button>
                    </div>
                </form>
                <p class="create_account">
                    Já possui conta? <a href="/view/login.php">Entre na sua conta aqui</a>
                </p>
            </div>
        </div>

        <div class="benefits_section">
            <img src="/public/images/account_benefits_2.svg" alt="" class="benefits_image">
            <div class="benefits">
                <p>Criando sua conta, você aproveita:</p>
                <ul>
                    <li>
                        <img src="/public/images/checkmark.svg" alt="" class="checkmark">
                        Todos os compromissos em um só lugar
                    </li>
                    <li>
                        <img src="/public/images/checkmark.svg" alt="" class="checkmark">
                        Uma plataforma segura e confiável
                    </li>
                    <li>
                        <img src="/public/images/checkmark.svg" alt="" class="checkmark">
                        Sua agenda gerenciada de forma prática e rápida
                    </li>
                    <li>
                        <img src="/public/images/checkmark.svg" alt="" class="checkmark">
                        Compromissos agendados com facilidade
                    </li>
                </ul>
            </div>
        </div>
    </main>
    <script>
        function cpf_format(input) {
            let value = input.value;

            // Remove qualquer caractere que não seja número
            value = value.replace(/\D/g, "");

            // Limita o CPF a 11 dígitos
            value = value.substring(0, 11);

            // Adiciona pontos e hífen conforme necessário
            if (value.length > 3 && value.length <= 6) {
                value = value.replace(/(\d{3})(\d+)/, "$1.$2");
            }
            else if (value.length > 6 && value.length <= 9) {
                value = value.replace(/(\d{3})(\d{3})(\d+)/, "$1.$2.$3");
            }
            else if (value.length > 9) {
                value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
            }

            // Atualiza o valor do campo de entrada
            input.value = value;
        }
    </script>
</body>

</html>