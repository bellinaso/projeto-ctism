<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookease - Estabelecimentos</title>
    <link rel="stylesheet" href="/public/css/myaccount.css">
    <link rel="stylesheet" href="/public/css/components/red_button.css">
    <link rel="stylesheet" href="/public/css/components/header.css">
    <script src="../config.js"></script>
</head>

<body>
    <?php
        require_once '../controller/authentication_controller.php';
        require_once '../controller/redirect_controller.php';

        include_once '../model/database_connect.php';

        if(is_logged() == false) {
            @session_start();
            $_SESSION['last_page'] = 'myaccount.php';

            redirect_to('login.php');
        }
    ?>
    <header>
        <div class="header">
            <div class="logo">
                <a href="/view/index.php">
                    <img src="/public/images/logos_horizontal/logo1_white.svg" alt="" class="logo_image">
                </a>
            </div>
            <div class="header_buttons">
                <div class="header_button">
                    <a href="../view/establishments.php">
                        Página inicial
                    </a>
                </div>
                <div class="account_pages">
                    <a href="/view/myaccount.php">
                        <img class="profile_picture" src="/public/images/profile_picture.svg" alt="">
                    </a>
                    <div>
                        <a href="/view/myaccount.php">
                            <span>MINHA CONTA</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- IDEA: div central na página com coluna à esquerda com botões para "Minhas informações"... -->
        <!-- TODO: Logout button -->
        <div class="main_content">
            <div class="aside_buttons">
                <a href="./myaccount.php" class="aside_button">
                    <!-- <img src="../public/images/profile_picture.svg" alt=""> -->
                    <svg width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M20.5899 22C20.5899 18.13 16.7399 15 11.9999 15C7.25991 15 3.40991 18.13 3.40991 22" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Minhas informações</span>
                </a>
            </div>

            <div class="informations">
                <?php
                    if(isset($_REQUEST) && isset($_REQUEST['info'])) {
                        switch ($_REQUEST['info']) {
                            case 'value':
                                # code...
                                break;
                            
                            default:
                                echo '';
                                break;
                        }
                    }
                ?>
                <div class="account">
                    <div class="personal_info">
                        <h2>Informações pessoais:</h2>
                        <div class="account_row">
                            <div class="profile_picture">
                                <img src="../public/images/profile_picture.svg" alt="">
                            </div>

                            <div class="profile_info">
                                <div class="profile_info_column">
                                    <span>Nome:</span>
                                    <span>Telefone:</span>
                                    <span>CPF:</span>
                                    <span>Estado:</span>
                                    <span>Cidade:</span>
                                </div>
                                <div class="profile_info_column">
                                    <span>Teste</span>
                                    <span>Teste</span>
                                    <span>Teste</span>
                                    <span>Teste</span>
                                    <span>Teste</span>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="account_info">
                        <h2>Informações da conta:</h2>
                        <div class="acount_row">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <footer>

    </footer>

</body>

</html>