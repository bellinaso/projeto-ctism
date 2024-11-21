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
                            <img src="../controller/uploads/'.$establishment['cnpj'].'.jpg" alt="" class="establishment_image">
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
                                        <button type="button" onclick="create_new_service()">Adicionar novo</button>
                                    </div>
                                </div>
                                
                            <div class="service_register">
                                <form action="../controller/service_controller.php" method="post">
                                    <input type="hidden" name="establishment_id" value="'.$establishment['id'].'">
                                    <div class="row">
                                        <div class="form_input">
                                            <label for="name">
                                                Nome do serviço
                                            </label>
                                            <input type="text" name="name" id="name" placeholder="Insira um nome para o serviço">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form_input">
                                            <label for="description">
                                                Descrição
                                                <span id="description_count">0/200</span>
                                            </label>
                                            <span id="limit_exceeded"></span>
                                            <input type="text" name="description" id="description" placeholder="Insira uma descrição do serviço">
                                        </div>
                                    </div>
                                    <label>
                                        Horários disponíveis
                                    </label>
                                    <div class="row week_days">
        
                                        <div class="column">
                                            <div class="form_input">
                                                <input type="checkbox" name="week_days" id="DOM">
                                                <label for="DOM" class="service_button">DOM</label>
                                            </div>
                                        </div>
        
                                        <div class="column">
                                            <div class="form_input">
                                                <input type="checkbox" name="week_days" id="SEG">
                                                <label for="SEG" class="service_button">SEG</label>
                                            </div>
                                        </div>
        
                                        <div class="column">
                                            <div class="form_input">
                                                <input type="checkbox" name="week_days" id="TER">
                                                <label for="TER" class="service_button">TER</label>
                                            </div>
                                        </div>
        
                                        <div class="column">
                                            <div class="form_input">
                                                <input type="checkbox" name="week_days" id="QUA">
                                                <label for="QUA" class="service_button">QUA</label>
                                            </div>
                                        </div>
        
                                        <div class="column">
                                            <div class="form_input">
                                                <input type="checkbox" name="week_days" id="QUI">
                                                <label for="QUI" class="service_button">QUI</label>
                                            </div>
                                        </div>
        
                                        <div class="column">
                                            <div class="form_input">
                                                <input type="checkbox" name="week_days" id="SEX">
                                                <label for="SEX" class="service_button">SEX</label>
                                            </div>
                                        </div>
        
                                        <div class="column">
                                            <div class="form_input">
                                                <input type="checkbox" name="week_days" id="SAB">
                                                <label for="SAB" class="service_button">SAB</label>
                                            </div>
                                        </div>
        
                                    </div>
                                    <div class="row">
                                        <div class="green_button new_service">
                                            <button type="submit" name="create_new">Confirmar</button>
                                        </div>
                                    </div>
                                </form>
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

                                            $formated_start_time = date('h:i', strtotime($a['start_time']));
                                            echo '
                                                    <div class="form_input">
                                                        <input type="radio" name="available_times" id="'.$a['id'].'" value="'.$a['id'].'">
                                                        <label for="'.$a['id'].'" class="service_button">'.$formated_start_time.'</label>
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
        const columns = document.querySelectorAll(".column");

        columns.forEach((column, index) => {
            const checkbox = column.querySelector('input[type="checkbox"]');

            const initial_time_input = document.createElement("input");

            const new_button_div = document.createElement("div");
            const new_button = document.createElement("button");
            
            const delete_button_div = document.createElement("div");
            const delete_button = document.createElement("button");

            initial_time_input.type = "time";
            initial_time_input.name = `service_availability_time_${index}[]`;

            new_button_div.className = "green_button time_button";
            delete_button_div.className = "red_button time_button";

            new_button.innerHTML = '<i class="fa-solid fa-plus"></i>';
            delete_button.innerHTML = '<i class="fa-solid fa-minus"></i>';

            checkbox.addEventListener("change", () => {

                if (checkbox.checked) {
                    new_button_div.appendChild(new_button);
                    delete_button_div.appendChild(delete_button);

                    column.appendChild(new_button_div);
                    column.appendChild(initial_time_input);
                    column.appendChild(delete_button_div);
        
                    new_button.addEventListener("click", (e) => {
                        e.preventDefault();

                        const time_input = document.createElement("input");
                        time_input.type = "time";
                        time_input.name = `service_availability_time_${index}[]`;

                        console.log(column.lastElementChild);
                        
                        column.insertBefore(time_input, column.lastElementChild);
                    });

                    delete_button.addEventListener("click", (e) => {
                        e.preventDefault();

                        if(column.children.length > 4) {
                            column.removeChild(column.lastElementChild.previousElementSibling);
                        }
                    });
                }
                else {
                    
                    const time_inputs = column.querySelectorAll("input[type=time]");
                    const buttons_div = column.querySelectorAll(".time_button");

                    time_inputs.forEach((time_input) =>  {
                        column.removeChild(time_input);
                    });

                    buttons_div.forEach((button) =>  {
                        column.removeChild(button);
                    });
                }
            });

            
        });
    </script>

    <script>
        const desciption_input = document.getElementById('description');
        const description_count = document.getElementById('description_count');
        const limit_exceeded = document.getElementById('limit_exceeded');
        const max_chars = 100;

        desciption_input.addEventListener('input', () => {
            const current_length = desciption_input.value.length;
            description_count.textContent = `${current_length}/100`;
            
            if (current_length > max_chars) {
                limit_exceeded.textContent = 'A descrição deve ser menor do que 100 caracteres!';
                description_count.style.color = 'var(--red-1)';
            }
            else {
                limit_exceeded.textContent = '';
                description_count.style.color = 'var(--gray-2)';
            }
        });
    </script>

    <script>
        function create_new_service() {
            const create_service_button = document.querySelector(".new_service");

            if(create_service_button.classList.contains("green_button")) {
                create_service_button.classList.remove("green_button")
                create_service_button.classList.add("red_button")
                create_service_button.children[0].innerText = "Cancelar"
            }
            else {
                create_service_button.classList.add("green_button")
                create_service_button.classList.remove("red_button")
                create_service_button.children[0].innerText = "Adicionar novo"
            }

            const create_service = document.querySelector(".service_register");

            if(create_service.classList.contains("show")) {
                create_service.classList.remove("show")
            }
            else {
                create_service.classList.add("show")
            }
        }
    </script>

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