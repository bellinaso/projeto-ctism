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
                        <?php
                            if(!isset($_SESSION['login'])) {
                                @session_start();
                                $_SESSION['last_page'] = 'myaccount.php';
                                echo '
                                    <span class="account_buttons">
                                        <a href="/view/login.php">
                                            ENTRE
                                        </a>
                                        <span>ou</span>
                                    </span>
                                    <span class="account_buttons">
                                        <a href="/view/register.php">
                                            CADASTRE-SE
                                        </a>
                                    </span>
                                ';
                            }
                            else {
                                echo '
                                    <a href="/view/myaccount.php">
                                        <span>MINHA CONTA</span>
                                    </a>
                                ';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- IDEA: div central na página com coluna à esquerda com botões para "Minhas informações"... -->
        <!-- TODO: Logout button -->
    </main>
    
    <footer>

    </footer>

</body>

</html>