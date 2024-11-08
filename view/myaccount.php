<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookease - Estabelecimentos</title>
    <link rel="stylesheet" href="/public/css/establishments.css">
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

            </div>
        </div>
    </header>

    <main>
        
    </main>
    
    <footer>

    </footer>

</body>

</html>