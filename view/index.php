<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookease - Estabelecimentos</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>

<body>
    <header>
        <div class="logo">
            <a href="/view/index.php">
                <img src="/public/images/logos_horizontal/logo1_white.svg" alt="" class="logo_image">
            </a>
        </div>
        <div class="header_buttons">
            <div class="reserve_page">
                <a href="/view/establishments.php">
                    RESERVAR AGORA
                </a>
            </div>
            <div class="account_pages">
                <a href="/view/myaccount.php">
                    <img class="profile_picture" src="/public/images/profile_picture.svg" alt="">
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
                    ?>
                </div>
            </div>
        </div>
    </header>
    <main>

    </main>
    <footer>

    </footer>
</body>

</html>