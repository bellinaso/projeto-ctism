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
    <main>
    <div class="register_section">
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
                <h1>Acesse sua conta</h1>
                <form action="/controller/register_controller.php">

                    <div class="form_input">
                        <label for="login">
                            Nome completo
                        </label>
                        <input type="text" name="complete_name" id="login" placeholder="Insira o seu nome completo">
                    </div>

                    <div class="form_input">
                        <label for="email">
                            Endereço e-mail
                        </label>
                        <input type="text" name="email" id="email" placeholder="Insira seu endereço e-mail">
                    </div>

                    <div class="form_input">
                        <label for="phone">
                            Número de telefone
                        </label>
                        <input type="text" name="phone" id="phone" placeholder="Seu número de telefone com DDD">
                    </div>

                    <div class="form_input">
                        <label for="cpf">
                            CPF
                        </label>
                        <input type="text" name="cpf" id="cpf" placeholder="Digite apenas os números, sem pontos ou traços">
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
                            <select name="" id="state">
                                <option value="">Teste</option>
                            </select>
                        </div>
                        <div class="form_input">
                            <label for="city">
                                Qual cidade você mora?
                            </label>
                            <select name="" id="city">
                                <option value="">Teste</option>
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
</body>

</html>