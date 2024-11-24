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
   
    <section id="about_us">
    <div class="container">
        <!-- O que é o Bookease -->
        <div class="section" id="what_is_bookease">
          
            <div class="card what-is">
                
                <p><h4>Sobre o Bookease</h4>O Bookease é uma plataforma inovadora que busca simplificar o processo de agendamento, conectando usuários a serviços de forma rápida e eficiente. Nosso objetivo é proporcionar uma experiência de agendamento prática, intuitiva e acessível a todos, com foco em facilitar o dia a dia dos nossos usuários.</p>
            </div>
        </div>

        <!-- Missões -->
        <div class="section" id="mission">
    <h2></h2>
    <div class="card-grid">
        <div class="card mission">
            <h4>Simplificar o Agendamento</h4>
            <p>A nossa missão é oferecer uma plataforma intuitiva e eficiente, com foco na experiência do usuário e no acesso fácil e rápido a todos os serviços.</p>
        </div>
        <div class="card mission">
            <h4>Inovar Constantemente</h4>
            <p>Buscar inovação contínua, trazendo novos recursos e melhorias para a plataforma, sempre com base nas necessidades dos usuários e nas tendências do mercado.</p>
        </div>
        <div class="card mission">
            <h4>Impulsionar Estabelecimentos</h4>
            <p>Contribuir para o crescimento e a visibilidade dos estabelecimentos parceiros, ajudando-os a alcançar mais clientes e a otimizar seus serviços.</p>
        </div>
        <div class="card mission">
            <h4>Facilitar o Acesso aos Serviços</h4>
            <p>Expandir nossa presença no mercado, promovendo a conveniência e facilitando o acesso aos serviços de qualquer lugar, a qualquer hora.</p>
        </div>
        <div class="card mission">
            <h4>Proporcionar Agilidade no Agendamento</h4>
            <p>Oferecer um sistema ágil e eficiente que permita aos usuários agendar seus serviços de maneira rápida e sem complicação.</p>
        </div>
        <div class="card mission">
            <h4>Transformar a Experiência do Usuário</h4>
            <p>Proporcionar uma experiência de usuário excepcional, com uma plataforma que seja fácil de usar, rápida e eficiente, sempre buscando melhorar a usabilidade.</p>
        </div>
    </div>
</div>
<!-- Fundadores -->
<div class="section founders-section" id="founders">
   
<div class="founders-section">
    <div class="founder">
        <div class="card-image">
            <img src="/public/images/category_images/arthur.jpg" alt="Foto de Arthur" class="rounded-image">
        </div>
        <div class="card-content">
            <h3>Arthur Bernardo Paul</h3>
            <p>Estudante e cofundador do Bookease. Juntos, buscamos transformar a maneira de agendar serviços.</p>
            <div class="social-links">
                <a href="https://www.instagram.com/arthur_bernardo" target="_blank">
                    <i class="fa-brands fa-linkedin"></i>
                    <!-- LinkedIn -->
                </a>
                <a href="https://www.github.com/in/arthurbernardopaul" target="_blank">
                    <i class="fa-brands fa-github"></i>
                    <!-- Github -->
                </a>
            </div>
        </div>
    </div>
    <div class="founder">
        <div class="card-image">
            <img src="/public/images/category_images/bruno.jpg" alt="Foto de Bruno Bellinaso Brasil" class="rounded-image">
        </div>
        <div class="card-content">
            <h3>Bruno Bellinaso Brasil</h3>
            <p>Estudante e cofundador do Bookease. Juntos, buscamos transformar a maneira de agendar serviços.</p>
            <div class="social-links">
                <a href="https://www.instagram.com/brunobellinaso" target="_blank">
                    <i class="fa-brands fa-linkedin"></i>
                    <!-- LinkedIn -->
                </a>
                <a href="https://www.github.com/in/brunobellinaso" target="_blank">
                    <i class="fa-brands fa-github"></i>
                    <!-- Github -->
                </a>
            </div>
        </div>
    </div>
</div>



 

</section>


      


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

       
</footer>


</body>

</html>