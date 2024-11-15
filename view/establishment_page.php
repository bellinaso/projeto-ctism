<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookease - Estabelecimentos</title>
    <link rel="stylesheet" href="/public/css/establishment_page.css">
    <link rel="stylesheet" href="/public/css/components/red_button.css">
    <link rel="stylesheet" href="/public/css/components/header.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/0aaabe9207.js" crossorigin="anonymous"></script>
    <script src="../config.js"></script>
</head>

<body>
    <?php
        include '../config.php';
        require_once '../controller/establishments_controller.php';
        require_once '../controller/categories_controller.php';

        @session_start();
        $_SESSION['last_page'] = 'establishments.php';
    ?>
    <header>
        <div class="background_image"></div>
        <div class="header">
            <div class="logo">
                <a href="/view/index.php">
                    <img src="/public/images/logos_horizontal/logo1_white.svg" alt="" class="logo_image">
                </a>
            </div>
            <div class="header_buttons">
                <div class="account_pages">
                    <a href="/view/myaccount.php" class="profile_picture">
                        <i class="fa-regular fa-user"></i>
                    </a>
                    <div>
                        <?php
                            if(!isset($_SESSION['login'])) {
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
        <div class="establishment">
            <div class="establishment_header">
                <img src="../public/images/profile_picture.svg" alt="">
                <h2>Nome do estabelecimento</h2>
            </div>
            
            <div class="establishment_content">
                <h2>Lorem ipsum dolor sit amet.</h2>
                <div class="establishment_services">
                    
                </div>
            </div>
        </div>
    </main>
    
    <footer>
        
    </footer>
</body>

</html>