<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookease - Página inicial</title>
    <link rel="stylesheet" href="/public/css/components/red_button.css">
    <link rel="stylesheet" href="/public/css/components/header.css">
    <link rel="stylesheet" href="/public/css/index.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/0aaabe9207.js" crossorigin="anonymous"></script>
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
                    <a href="/view/myaccount.php" class="profile_picture">
                        <i class="fa-regular fa-user"></i>
                    </a>
                    <div>
                        <?php
                        if (!isset($_SESSION['login'])) {
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
                        } else {
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
            <i class="fa-solid fa-chevron-down"></i>
        </a>
    </header>
  
    <main>
    <div class="about_us" id="about_us">
        <!-- O que é o Bookease? -->
        <div class="h1pri">
            <h1>O que é o Bookease?</h1>
        </div>
        <div class="card_section">
            <div class="largeCard">
                <p>Bookease é uma plataforma intuitiva e inovadora que conecta clientes a diversos estabelecimentos, oferecendo soluções práticas e eficientes para agendamentos online. Com foco na simplificação do dia a dia, permite aos usuários reservar horários em serviços variados, como salões, clínicas, academias e outros, eliminando complicações e otimizando o tempo. Além de facilitar a organização de compromissos, o sistema melhora a experiência do cliente com uma interface amigável e personalizável, que atende tanto às necessidades dos usuários quanto dos estabelecimentos parceiros. Ao automatizar processos e modernizar o gerenciamento de reservas, o Bookease transforma a interação com serviços essenciais, promovendo conveniência e qualidade em cada etapa.</p>
            </div>
        </div>

        <!-- Nossa missão -->
        <div class="h1sec">
            <h1>Nossa missão</h1>
        </div>
        <div class="card_section">
            <div class="card info">
                <h2>Facilidade</h2>
                <p>Tornar o agendamento simples e intuitivo, eliminando barreiras tecnológicas para todos os usuários.</p>
            </div>
            <div class="card info">
                <h2>Acessibilidade</h2>
                <p>Oferecer uma plataforma inclusiva, adaptável a diferentes dispositivos e necessidades específicas.</p>
            </div>
            <div class="card info">
                <h2>Conexão</h2>
                <p>Facilitar o contato entre clientes e estabelecimentos, promovendo parcerias duradouras.</p>
            </div>
            <div class="card info">
                <h2>Inovação</h2>
                <p>Trazer inovação para transformar a experiência de agendamento, com praticidade e segurança.</p>
            </div>
        </div>

        <!-- Fundadores -->
        <div class="about_us">
            <h1>Fundadores</h1>
            <div class="card_section">
                <div class="card">
                    <img src="/public/images/category_images/arthur.jpg" alt="" class="rounded_card_image">
                    <h3>Arthur Bernardo Paul</h3>
                    <p>Estudante do Colégio Técnico Industrial de Santa Maria (CTISM)</p>
                </div>
                <div class="card">
                    <img src="/public/images/category_images/bruno.jpg" alt="Foto de Bruno Bellinaso Brasil" class="rounded_card_image">
                    <h3>Bruno Bellinaso Brasil</h3>
                    <p>Estudante do Colégio Técnico Industrial de Santa Maria (CTISM)</p>
                </div>
            </div>
        </div>
    </div>
</main>

    <footer>
    <div class="footer">
        <div class="footer_top">
          
            <div class="footer_section">
                <h4>Sobre o Bookease</h4>
                <p>O Bookease é uma plataforma que simplifica agendamentos, conectando clientes e estabelecimentos com eficiência e praticidade.</p>
            </div>

         
            <div class="footer_section">
                <h4>Links Úteis</h4>
                <ul>
                    <li><a href="#about_us">Sobre Nós</a></li>
                    <li><a href="/view/establishments.php">Reservar</a></li>
                    <li><a href="/view/myaccount.php">Minha Conta</a></li>
                    <li><a href="/view/contact.php">Contato</a></li>
                </ul>
            </div>

           
            <div class="footer_section">
                <h4>Contato</h4>
                <p>Email: <a href="mailto:support@bookease.com">support@bookease.com</a></p>
                <p>Telefone: (55) 99727-0790</p>
                <p>Endereço: Av Roraima, 1000 - Santa Maria, RS</p>
            </div>
        </div>

       
        <div class="footer_socials">
            <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-square"></i></a>
            <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin"></i></a>
        </div>

        <!-- Copyright -->
        <div class="footer_bottom">
            <p>© 2024 Bookease. Todos os direitos reservados.</p>
        </div>
    </div>
</footer>


</body>

</html>