<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookease - Entrar</title>
    <link rel="stylesheet" href="/public/css/register_login.css">
    <link rel="stylesheet" href="/public/css/login.css">
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
        <div class="benefits_section">
            <img src="/public/images/account_benefits_1.svg" alt="" class="benefits_image">
            <div class="benefits">
                <p>Entrando na sua conta, você:</p>
                <ul>
                    <li>
                        <img src="/public/images/checkmark.svg" alt="" class="checkmark">
                        Acessa rapidamente aos seus compromissos
                    </li>
                    <li>
                        <img src="/public/images/checkmark.svg" alt="" class="checkmark">
                        Gerencia facilmente seus agendamentos
                    </li>
                </ul>
            </div>
        </div>

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
            <div class="login_form">
                <h1>Acesse sua conta!</h1>
                <?php
                if (isset($_REQUEST) && isset($_REQUEST['code'])) {
                    switch ($_REQUEST['code']) {
                        case 401:
                            echo '
                            <div class="form_error">
                                <span>Usuário ou senha incorretos!</span> Verifique se todos os campos foram corrigidos corretamente e tente novamente.
                            </div>
                            ';
                            break;
                    }
                }
                ?>
                <form method="post" action="/controller/login_controller.php">
                    <div class="form_input">
                        <label for="login">
                            Faça login com seu endereço e-mail ou CPF
                        </label>
                        <input type="text" name="login" id="login" placeholder="Digite seu endereço e-mail ou CPF">
                    </div>
                    <div class="form_input">
                        <label for="password">
                            Insira sua senha para prosseguir
                        </label>
                        <input type="password" name="password" id="password" placeholder="Digite a sua senha">
                    </div>
                    <div class="submit red_button">
                        <button type="submit">Continuar</button>
                    </div>
                </form>
                <p class="create_account">
                    Não possui conta? <a href="/view/register.php">Crie sua conta aqui</a>
                </p>
            </div>
        </div>
    </main>
</body>

</html>