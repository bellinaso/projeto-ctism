<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookease - Entrar</title>
    <link rel="stylesheet" href="/public/css/login.css">
    <link rel="stylesheet" href="/public/css/components/red_button.css">
</head>

<body>
    <main>
        <div class="benefits_section">
            <img src="/public/images/account_benefits.svg" alt="" class="benefits_image">
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
                    <!-- <li>
                        <img src="/public/images/checkmark.svg" alt="" class="checkmark">
                        
                    </li> -->
                </ul>
            </div>
        </div>

        <div class="login_section">
            <header>
                <div class="logo">
                    <a href="/view/index.php">
                        <img src="/public/images/logos_horizontal/logo1_black.svg" alt="" class="logo_image">
                    </a>
                </div>
            </header>
            <div class="login_form">
                <h1>Acesse sua conta</h1>
                <form action="/controller/login_controller.php">
                    <div class="login_input">
                        <label for="login">
                            Faça login com seu endereço e-mail ou CPF
                        </label>
                        <input type="text" name="password" id="login" placeholder="Digite seu endereço e-mail ou CPF">
                    </div>
                    <div class="password_input">
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