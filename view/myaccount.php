<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookease - Minha conta</title>
    <link rel="stylesheet" href="/public/css/myaccount.css">
    <link rel="stylesheet" href="/public/css/components/red_button.css">
    <link rel="stylesheet" href="/public/css/components/header.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/0aaabe9207.js" crossorigin="anonymous"></script>
    <script src="../config.js"></script>
</head>

<body>
    <?php
        require_once '../controller/authentication_controller.php';
        require_once '../controller/redirect_controller.php';

        require_once '../controller/establishments_controller.php';
        require_once '../controller/categories_controller.php';

        include_once '../model/database_connect.php';

        @session_start();
        if(is_logged() == false) {
            $_SESSION['last_page'] = 'myaccount.php';

            redirect_to('login.php');
        }

        $con = new connect_database();
        $con->connect();

        $query = "SELECT * FROM users WHERE email = '$_SESSION[login]';";
        $user = $con->consult($query);
        
    ?>
    <!-- https://boxicons.com/ -->
    <!-- https://fontawesome.com/ -->
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
        <div class="main_content">
            <div class="aside_buttons">
                <a href="./myaccount.php" class="aside_button">
                    <i class='bx bxs-user'></i>
                    <span>Minhas informações</span>
                </a>
                <a href="#" class="aside_button">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span>Meus agendamentos</span>
                </a>
                <?php
                    // if($user['user_type'] == 'manager') {
                    if($user['user_type'] != null) {
                        echo '
                            <a href="?info=my_establishments" class="aside_button">
                                <i class="fa-solid fa-store"></i>
                                <span>Meus estabelecimentos</span>
                            </a>
                        ';
                    }
                    // if($user['user_type'] == 'user') {
                    if($user['user_type'] != null) {
                        echo '
                            <a href="#" class="aside_button">
                                <i class="fa-solid fa-gears"></i>
                                <span>Painel de administrador</span>
                            </a>
                        ';
                    }
                ?>
                <a href="../view/establishment_register.php" class="aside_button">
                    <i class="fa-regular fa-square-plus"></i>
                    <span>Cadastrar meu estabelecimento</span>
                </a>
                <a href="../controller/logout_controller.php" class="aside_button">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span>Sair</span>
                </a>
            </div>

            <div class="informations">
                <?php
                    if(isset($_REQUEST) && isset($_REQUEST['info'])) {
                        switch ($_REQUEST['info']) {
                            case 'my_establishments':
                                echo '
                                    <div class="establishments">
                                        <h2>Meus estabelecimentos</h2>
                                        <div class="establishments_list">
                                    ';
                                
                                $establishments = get_my_establishments();
                                if($establishments != null) {
                                    foreach($establishments as $e) {
                                        echo '
                                            <div class="establishment">
                                                <div class="establishment_image">
                                                    <a href="/view/establishment_page.php">
                                                        <img src="/public/images/image_icon.svg" alt="" class="image_icon">
                                                    </a>
                                                </div>
                                                <div class="establishment_info">
                                                    <h3>
                                                        <a href="#">
                                                        '.$e['name'].'
                                                        </a>
                                                    </h3>
                                                    <p>
                                                        <span>Descrição: </span>
                                                        '.$e['description'].'
                                                    </p>
                                                    <p>
                                                        <span>Categoria: </span>
                                                        '.$e['category_name'].'
                                                    </p>
                                                    <p>
                                                        <span>Subcategoria: </span>
                                                        '.$e['subcategory_name'].'
                                                    </p>
                                                    <p>
                                                        <span>Endereço: </span>
                                                        '.$e['address'].'
                                                    </p>
                                                </div>
                                                <div class="open_establishment">
                                                    <a href="/view/establishment_page.php">
                                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        ';
                                    }
                                }
                                else {
                                    echo '
                                        <div class="not_found">
                                            <i class="fa-solid fa-circle-exclamation"></i>
                                            <h1>
                                                Ops!
                                            </h1>
                                            <h2>
                                                Parece que você não<br>
                                                possui nenhum<br>
                                                estabelecimento<br>
                                                Cadastrado!
                                            </h2>
                                        </div>
                                    ';
                                }
                                echo'
                                        </div>
                                    </div>
                                ';
                                break;
                            
                            default:
                                header('Location:./myaccount.php');

                        }
                    }
                    else {
                        echo "
                            <div class='account'>
                                <div class='personal_info'>
                                    <h2>Informações pessoais:</h2>
            
                                    <div class='table'>
                                        <div class='table_row'>
                                            <img src='../public/images/profile_picture.svg' alt=''>
                                            <div class='table_column'>
                                                <span class='table_strong'>Nome:</span>
                                                <span class='table_strong'>CPF:</span>
                                                <span class='table_strong'>Estado:</span>
                                                <span class='table_strong'>Cidade:</span>
                                            </div>
                                            <div class='table_column'>
                                                <span>$user[name]</span>
                                                <span>$user[cpf]</span>
                                                <span>$user[state]</span>
                                                <span>$user[city]</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class='account_info'>
                                    <h2>Informações da conta:</h2>
                                    <div class='table'>
                                        <div class='table_column'>
                                            <span class='table_strong'>E-mail:</span>
                                            <span class='table_strong'>Data de criação:</span>
                                        </div>
                                        <div class='table_column'>
                                            <span>$user[email]</span>
                                            <span>$user[creation_date]</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ";
                    }
                ?>
            </div>
        </div>
    </main>
    
    <footer>

    </footer>

</body>

</html>