<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookease - Estabelecimentos</title>
    <link rel="stylesheet" href="/public/css/establishment_page.css">
    <link rel="stylesheet" href="/public/css/components/red_button.css">
    <link rel="stylesheet" href="/public/css/components/green_button.css">
    <link rel="stylesheet" href="/public/css/components/header.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/0aaabe9207.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php
        require_once '../controller/establishments_controller.php';
        require_once '../controller/categories_controller.php';
        require_once '../controller/user_controller.php';
        require_once '../controller/authentication_controller.php';

        if(isset($_REQUEST) && isset($_REQUEST['id'])) {
            $establishment = get_one_establishment($_REQUEST['id']);

            if(isset($establishment)) {
                
                if(strlen($establishment['phone']) == 10) {
                    $establishment['phone'] = preg_replace('/(\d{2})(\d{4})(\d+)/', '($1) $2-$3', $establishment['phone']);
                }
                else {
                    $establishment['phone'] = preg_replace('/(\d{2})(\d{5})(\d+)/', '($1) $2-$3', $establishment['phone']);
                }

                $services = get_services_from_establishment($establishment['id']);

                $availability = get_availability_from_service($establishment['id']);

                $reserves = get_reserves_from_establishment($establishment['id']);
            }

            if(is_logged()) {
                $logged_user = get_logged_user($_SESSION['login']);
            }


            @session_start();
            $_SESSION['last_page'] = 'establishment_page.php?id='.$_REQUEST['id'];
        }
    ?>
    <header
        <?php
            if(isset($establishment)) {
                echo '
                    style="background-image: url(../public/images/category_images/'.str_replace(' ','\ ',$establishment['category_name']).'.jpg);
                    background-repeat: no-repeat;
                    background-attachment: fixed;
                    background-position: center 120%;
                    background-size: cover;
                "
                ';
            }
        ?>>
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
        <div class="header_background_image"></div>
    </header>

    <main>
        <div class="establishment_header">
            <?php
                    if(isset($establishment) && $establishment != null) {
                        echo '
                            <img src="../public/images/image_icon.svg" alt="" class="establishment_image">
                            <div class="establishment_info">
                                <h2 class="establishment_title">'.$establishment['name'].'</h2>
                                <p>
                                    <span>Contato: </span>
                                    '.$establishment['phone'].'
                                </p>
                                <p>'.$establishment['description'].'</p>
                                <p>
                                    <span>Categoria: </span>
                                    '.$establishment['category_name'].'
                                </p>
                                <p>
                                    <span>Subcategoria: </span>
                                    '.$establishment['subcategory_name'].'
                                </p>
                            </div>
                        ';
                        }
                        else {
                            echo '
                                <div class="not_found">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    <h1>
                                        Ops!
                                    </h1>
                                    <h2>
                                        Parece que o<br>
                                        estabelecimento<br>
                                        não foi encontrado!
                                    </h2>
                                </div>
                            ';
                        }
                    ?>
        </div>
        <div class="establishment_content">
            <?php
                $message_title = 'Algo inesperado deu errado!';
                $message= '';
                $message_style = 'action_failed';
                if(isset($_REQUEST) && isset($_REQUEST['code'])) {
                    switch ($_REQUEST['code']) {
                        case 401:
                            $message_title = 'Algo inesperado deu errado!';
                            $message_style = 'action_failed';
                            break;
                            
                        case 422:
                            $message_title = 'Algo deu errado!';
                            $message = 'Verifique se todos os campos foram preenchidos corretamente.';
                            $message_style = 'action_failed';
                            break;

                        case 200:
                            $message_title = 'Ação concluída com suecsso!';
                            $message_style = 'action_succeed';
                            if(isset($_REQUEST['cancelled'])) {
                                $message = "Agendamento <span>#$_REQUEST[cancelled]</span> cancelado.";
                            }
                            else if(isset($_REQUEST['completed'])) {
                                $message = "Agendamento <span>#$_REQUEST[completed]</span> finalizado.";
                            }
                            break;
                    }
                    echo '
                    <div class="row">
                        <div class="'.$message_style.'">
                            <span>'.$message_title.'</span> '.$message.'
                        </div>
                    </div>
                    ';
                }
            ?>
            
            <div class="row">
                <?php
                    if(isset($logged_user) &&
                    isset($establishment) &&
                    $logged_user['id'] == $establishment['user_id']) {
                        echo '
                            <h1>Reservas</h1>
                        ';
                    }
                ?>
                <h1>Serviços</h1>
            </div>

            <div class="row">
                <?php
                            if(
                            isset($logged_user) &&
                            isset($establishment) &&
                            $logged_user['id'] == $establishment['user_id']) {
                                echo '
                                    <div class="establishment_reserves">                            
                                ';
                                if($reserves != null) {
                                    foreach($reserves as $r) {
                                        echo '
                                            <div class="reserve">
                                            <div class="table">
                                                <div class="table_row">
                                                    <div class="table_column">
                                                        <span class="table_strong">ID:</span>
                                                        <span class="table_strong">Reservador:</span>
                                                        <span class="table_strong">Serviço:</span>
                                                        <span class="table_strong">Data:</span>
                                                        <span class="table_strong">Horário:</span>
                                                        <span class="table_strong">Status:</span>
                                                    </div>
                                                    <div class="table_column">
                                                        <span>'.$r['id'].'</span>
                                                        <span>'.$r['user_name'].'</span>
                                                        <span>'.$r['service_name'].'</span>
                                                        <span>'.$r['service_date'].'</span>
                                                        <span>'.$r['availability_time'].'</span>
                                                        <span class="status_'.$r['reserve_status'].'">'.$r['reserve_status'].'</span>
                                                    </div>
                                                </div>
                                            </div>
                                            ';
                                        if($r['reserve_status'] == 'pending') {
                                            echo '
                                                <div class="reserve_buttons">
                                                    <form action="../controller/reserve_controller.php" method="post">
                                                        <div class="green_button reserve_button">
                                                            <button type="submit" name="complete" value="'.$r['id'].'">
                                                                <i class="fa-regular fa-circle-check"></i>
                                                                Marcar como completo
                                                            </button>
                                                        </div>
                                                        
                                                        <div class="red_button reserve_button">
                                                            <button type="submit" name="establishment_cancellation" value="'.$r['id'].'">
                                                                <i class="fa-solid fa-ban"></i>
                                                                Cancelar
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            ';
                                        }
                                        echo '
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
                                                Parece que<br>
                                                nenhuma reserva<br>
                                                foi encontrada!
                                            </h2>
                                        </div>
                                    ';
                                }
                            }
                        ?>
                </div>
                

                <div class="establishment_services">
                    <?php
                        if(
                        isset($logged_user) &&
                        isset($establishment) &&
                        $logged_user['id'] == $establishment['user_id']) {
                            echo '
                                <div class="manager_buttons">
                                    <div class="green_button new_service">
                                        <button type="button">Adicionar novo</button>
                                    </div>
                                </div>        
                            ';
                        }
                    ?>
                    <?php
                        if(isset($services)) {
                            foreach($services as $s) {
                                echo '
    
                                    <div class="service">
                                        <div class="service_info">
                                            <h3>'.$s['name'].'</h3>
                                            <p>'.$s['description'].'</p>
                                        </div>
                                        
                                        <form action="../controller/reserve_controller.php" method="post">
                                    
                                            <div class="next_week">
                                ';
    
                                for ($i = 0; $i < 7; $i++) {
                                    $future_date = new DateTime();
                                    $future_date->add(new DateInterval("P{$i}D"));
                                
                                    $formated_date = $future_date->format('d/m');
                                    $mysql_formated_date = $future_date->format('Y-m-d');
                                
                                    $week_day_id = "week_day_$s[id]_$i";
    
                                    $radio_value = $i + 1;
                                
                                    $checked = $i === 0 ? 'checked' : '';
                                
                                    echo '
                                                <div class="form_input">
                                                    <input type="radio" name="available_day" class="available_day_'.$s['id'].'" id="'.$week_day_id.'" value="'.$mysql_formated_date.'" '.$checked.'>
                                                    <label for="'.$week_day_id.'" class="service_button">'.$formated_date.'</label>
                                                </div>
                                    ';
                                }
    
                                echo '
                                            </div>
    
                                            <div class="days_slider" id="days_slider_'.$s['id'].'">
                                ';
    
                                for($i=0; $i<7; $i++) {
                                    $future_date = new DateTime();
                                    $future_date->add(new DateInterval("P{$i}D"));
                                
                                    $formated_date = $future_date->format('l');
    
                                    echo '
                                                <div class="available_times slide">
                                    ';
                                    
                                    foreach($availability as $a) {
                                        if($a['week_days'] == strtolower($formated_date) && $a['service_id'] == $s['id']) {
                                            echo '
                                                    <div class="form_input">
                                                        <input type="radio" name="available_times" id="'.$a['id'].'" value="'.$a['id'].'">
                                                        <label for="'.$a['id'].'" class="service_button">'.$a['start_time'].'</label>
                                                    </div>
                                            ';
                                        }
                                    }
                                    echo '
                                                </div>
                                    ';
                                }
                                echo '
                                            </div>
                                            <div class="green_button submit_button">
                                                <button type="submit" name="register_reserve" value="'.$s['id'].'">Agendar</button>
                                            </div>
                                            <input type="hidden" name="establishment_id" value="'.$establishment['id'].'">
                                            <input type="hidden" name="service_id" value="'.$s['id'].'">
                                        </form>
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
                                        Parece que nenhum<br>
                                        serviço<br>
                                        foi encontrado!
                                    </h2>
                                </div>
                            ';
                        }
                    ?>
                </div>
            </div>

        </div>
    </main>
    
    <footer>
        
    </footer>
    <script>
        <?php
        $service_ids = array_map(function($services) {return $services['id'];}, $services);
        ?>
        const services_id = <?= json_encode($service_ids) ?>;
        
        services_id.forEach((id) => {
            document.querySelectorAll(`.available_day_${id}`).forEach((day, index) => {
                day.addEventListener('click',  () => {
                document.getElementById(`days_slider_${id}`).style.transform = `translateX(-${100*index}%)`;
            });
            })
        });
    </script>
</body>

</html>