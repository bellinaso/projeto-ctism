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

        @session_start();
        $_SESSION['last_page'] = 'establishments.php';

        if(isset($_REQUEST) && isset($_REQUEST['id'])) {
            $establishment = get_one_establishment($_REQUEST['id']);

            if(strlen($establishment['phone']) == 10) {
                $establishment['phone'] = preg_replace('/(\d{2})(\d{4})(\d+)/', '($1) $2-$3', $establishment['phone']);
            }
            else {
                $establishment['phone'] = preg_replace('/(\d{2})(\d{5})(\d+)/', '($1) $2-$3', $establishment['phone']);
            }
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
        <div class="establishment">
            <?php
                    if(isset($establishment) && $establishment != null) {
                        echo '
                            <div class="establishment_header">
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
                                        foi encontrado!
                                    </h2>
                                </div>
                            ';
                        }
                    ?>
            <div class="establishment_content">
                <div class="manager_buttons">

                </div>
                <div class="establishment_services">
                    
                    <div class="service">
                        <div class="service_info">
                            <h3>Nome do serviço</h3>
                            <p>Descrição do serviço</p>
                        </div>
                        
                        <form action="pagina_tal">
                            
                            <div class="next_week">
                                <div class="form_input">
                                    <input type="radio" name="available_day" id="week_day_1" value="1" checked>
                                    <label for="week_day_1" class="service_button">16/11</label>
                                </div>
                                
                                <div class="form_input">
                                    <input type="radio" name="available_day" id="week_day_2" value="2">
                                    <label for="week_day_2" class="service_button">17/11</label>
                                </div>
                                
                                <div class="form_input">
                                    <input type="radio" name="available_day" id="week_day_3" value="3">
                                    <label for="week_day_3" class="service_button">18/11</label>
                                </div>
                                
                                <div class="form_input">
                                    <input type="radio" name="available_day" id="week_day_4" value="4">
                                    <label for="week_day_4" class="service_button">19/11</label>
                                </div>
                                
                                <div class="form_input">
                                    <input type="radio" name="available_day" id="week_day_5" value="5">
                                    <label for="week_day_5" class="service_button">20/11</label>
                                </div>
                                
                                <div class="form_input">
                                    <input type="radio" name="available_day" id="week_day_6" value="6">
                                    <label for="week_day_6" class="service_button">21/11</label>
                                </div>
                                
                                <div class="form_input">
                                    <input type="radio" name="available_day" id="week_day_7" value="7">
                                    <label for="week_day_7" class="service_button">22/11</label>
                                </div>
                            </div>

                            <div class="days_slider" id="days_slider_1">
                                <div class="available_times slide">
                                    <div class="form_input">
                                        <input type="radio" name="available_times" id="times_1" value="1">
                                        <label for="times_1" class="service_button">19:00</label>
                                    </div>
                                
                                    <div class="form_input">
                                        <input type="radio" name="available_times" id="times_2" value="1">
                                        <label for="times_2" class="service_button">20:00</label>
                                    </div>
                                
                                    <div class="form_input">
                                        <input type="radio" name="available_times" id="times_3" value="1">
                                        <label for="times_3" class="service_button">21:00</label>
                                    </div>
                                </div>
                                
                                <div class="available_times slide">
                                    <div class="form_input">
                                        <input type="radio" name="available_times" id="times_1" value="1">
                                        <label for="times_1" class="service_button">19:00</label>
                                    </div>
                                
                                    <div class="form_input">
                                        <input type="radio" name="available_times" id="times_2" value="1">
                                        <label for="times_2" class="service_button">20:00</label>
                                    </div>
                                
                                    <div class="form_input">
                                        <input type="radio" name="available_times" id="times_3" value="1">
                                        <label for="times_3" class="service_button">21:00</label>
                                    </div>
                                </div>
                                <div class="available_times slide">
                                    <div class="form_input">
                                        <input type="radio" name="available_times" id="times_1" value="1">
                                        <label for="times_1" class="service_button">19:00</label>
                                    </div>
                                
                                    <div class="form_input">
                                        <input type="radio" name="available_times" id="times_2" value="1">
                                        <label for="times_2" class="service_button">20:00</label>
                                    </div>
                                
                                    <div class="form_input">
                                        <input type="radio" name="available_times" id="times_3" value="1">
                                        <label for="times_3" class="service_button">21:00</label>
                                    </div>
                                </div>

                            </div>
                            
                            <div class="green_button submit_button">
                                <button type="submit" name="service_id" value="1">Agendar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <footer>
        
    </footer>
    <script>
        const week_days = document.getElementsByName('available_day');
        const available_times = document.getElementById('days_slider_1');
        // const available_times = document.getElementsByClassName('available_times');

        
        console.log(week_days);
        
        week_days.forEach((day, index) => {
            day.addEventListener('click',  () => {
                available_times.style.transform = `translateX(-${100*index}%)`;
            });
        });
    </script>
</body>

</html>