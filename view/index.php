<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookease - Página inicial</title>
    <link rel="stylesheet" href="/public/css/components/red_button.css">
    <link rel="stylesheet" href="/public/css/components/header.css">
    <link rel="stylesheet" href="/public/css/index.css">
</head>

<body>
    <?php
        @session_start();
        $_SESSION['last_page'] = 'index.php';
    ?>
    <header>
        <div class="header">
            <div class="logo">
                <a href="/view/index.php">
                    <img src="/public/images/logos_horizontal/logo1_white.svg" alt="" class="logo_image">
                </a>
            </div>
            <div class="header_buttons">
                <div class="about_us_page">
                    <a href="#about_us">
                        Sobre nós
                    </a>
                </div>
                <div class="reserve_page red_button">
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
        <div class="header_slogan">
            <div class="slogan_text">
                <h1>Agendar<br> nunca foi<br> tão fácil!</h1>
            </div>
            <div class="see_more red_button">
                <a href="#about_us">    
                    Saiba mais
                </a>
            </div>
        </div>
        <a href="#about_us" class="arrow_down">
            <img src="/public/images/arrow_down.svg" alt="">
        </a>
    </header>
    <main>
        <div class="about_us" id="about_us">
            <h1>Nossa missão</h1>
            <div class="card_section">
                <div class="card">
                    <h2>Missão 1</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta, architecto exercitationem repudiandae sequi iusto debitis porro et dolores nostrum consectetur impedit, possimus distinctio ducimus, harum hic accusantium. Nihil, molestias nisi!</p>
                </div>
                <div class="card">
                    <h2>Missão 2</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta, architecto exercitationem repudiandae sequi iusto debitis porro et dolores nostrum consectetur impedit, possimus distinctio ducimus, harum hic accusantium. Nihil, molestias nisi!</p>
                </div>
                <div class="card">
                    <h2>Missão 3</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta, architecto exercitationem repudiandae sequi iusto debitis porro et dolores nostrum consectetur impedit, possimus distinctio ducimus, harum hic accusantium. Nihil, molestias nisi!</p>
                </div>
                <div class="card">
                    <h2>Missão 4</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta, architecto exercitationem repudiandae sequi iusto debitis porro et dolores nostrum consectetur impedit, possimus distinctio ducimus, harum hic accusantium. Nihil, molestias nisi!</p>
                </div>
            </div>
        </div>
        <div class="about_us">
            <h1>Quem nós somos?</h1>
            <div class="card_section">
                <div class="card">
                    <img src="/public/images/profile_picture.svg" alt="" class="rounded_card_image">
                    <h3>Arthur Bernardo Paul</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta, architecto exercitationem repudiandae sequi iusto debitis porro et dolores nostrum consectetur impedit, possimus distinctio ducimus, harum hic accusantium. Nihil, molestias nisi!</p>
                </div>
                <div class="card">
                    <img src="/public/images/profile_picture.svg" alt="" class="rounded_card_image">
                    <h3>Bruno Bellinaso Brasil</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta, architecto exercitationem repudiandae sequi iusto debitis porro et dolores nostrum consectetur impedit, possimus distinctio ducimus, harum hic accusantium. Nihil, molestias nisi!</p>
                </div>
            </div>
        </div>
    </main>
    <footer>

    </footer>
</body>

</html>