<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookease - Cadastro</title>
    <link rel="stylesheet" href="/public/css/register_login.css">
    <link rel="stylesheet" href="/public/css/register.css">
    <link rel="stylesheet" href="/public/css/components/red_button.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/0aaabe9207.js" crossorigin="anonymous"></script>
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
                        <i class="fa-solid fa-chevron-left"></i>
                        Voltar
                    </a>
                </div>
            </header>
            <div class="register_form">
                <h1>Crie sua conta!</h1>
                <?php
                if (isset($_REQUEST)) {
                    
                    if(isset($_REQUEST['code'])) {
                        
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
                    if(isset($_REQUEST['error_at'])) {

                        switch($_REQUEST['error_at']) {
                            case 'email_validation':
                                echo '
                                <span class="error_at">O email inserido é inválido!</span>
                                ';
                                break;

                            case 'phone_validation':
                                echo '
                                <span class="error_at">Número de telefone inválido!</span>
                                ';
                                break;

                            case 'cpf_validation':
                                echo '
                                <span class="error_at">Número de CPF inválido!</span>
                                ';
                                break;

                            case 'password_format_validation':
                                echo '
                                <span class="error_at">Formato de senha inválido!</span>
                                ';
                                break;

                            case 'password_match_validation':
                                echo '
                                <span class="error_at">Senhas não coincidem!</span>
                                ';
                                break;

                            case 'duplicated_cpf':
                                echo '
                                <span class="error_at">CPF já cadastrado!</span>
                                ';
                                break;

                            case 'duplicated_email':
                                echo '
                                <span class="error_at">E-mail já cadastrado!</span>
                                ';
                                break;

                            case 'duplicated_phone':
                                echo '
                                <span class="error_at">Telefone já cadastrado!</span>
                                ';
                                break;
                        }
                    }
                }
                ?>
                <form method="post" action="/controller/register_controller.php">

                    <div class="form_input">
                        <label for="name">
                            Nome completo
                        </label>
                        <input type="text" name="name" id="name" placeholder="Insira o seu nome completo">
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
                        <input type="phone" name="phone" id="phone" oninput="phone_format(this)" placeholder="Insira apenas números com DDD">
                    </div>

                    <div class="form_input">
                        <label for="cpf">
                            CPF
                        </label>
                        <input type="text" name="cpf" id="cpf" oninput="cpf_format(this)" maxlength="14" placeholder="Insira apenas números">
                    </div>

                    <!-- TODO: show password button -->
                    <div class="form_input">
                        <label for="password">
                            Crie uma senha
                        </label>
                        <div class="must_have">
                            <p>
                                Precisa conter no mínimo:
                            </p>
                            <p class="password_requiriments">
                                <span id="char_amount">8 caracteres</span>
                                <span id="number">1 número</span>
                                <span id="upper_case_letter">1 letra maiuscula</span>
                                <span id="lower_case_letter">1 letra minuscula</span>
                                <span id="symbol">1 símbolo especial</span>
                            </p>
                        </div>
                        <input type="password" name="password" id="password" oninput="password_validate(this), password_confirm_validate(document.getElementById('password_confirm'))" placeholder="Crie uma senha forte">
                    </div>

                    <div class="form_input">
                        <label for="password_confirm">
                            Confirme sua senha
                        </label>
                        <span id="password_match"></span>
                        <input type="password" name="password_confirm" id="password_confirm" oninput="password_confirm_validate(this)" placeholder="Digite a senha novamente para confirmar">
                    </div>

                    <div class="form_input_group">
                        <div class="form_input">
                            <label for="state">
                                Qual estado você mora?
                            </label>
                            <select name="state" id="state">
                                <option value="" disabled selected>Selecione um estado</option>
                                <option value="RS">Rio Grande do Sul</option>
                            </select>
                        </div>
                        <div class="form_input">
                            <label for="city">
                                Qual cidade você mora?
                            </label>
                            <select name="city" id="city">
                                <option value="" disabled selected>Selecione uma cidade</option>
                                <option value="Santa Maria">Santa Maria</option>
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
    <script src="../public/js/input_format.js"></script>
</body>

</html>