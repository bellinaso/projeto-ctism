<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookease - Novo estabelecimento</title>
    <link rel="stylesheet" href="/public/css/establishment_register.css">
    <link rel="stylesheet" href="/public/css/components/red_button.css">
    <link rel="stylesheet" href="/public/css/components/header.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/0aaabe9207.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php
        require_once '../controller/authentication_controller.php';
        require_once '../controller/redirect_controller.php';

        include_once '../model/database_connect.php';

        if(is_logged() == false) {
            @session_start();
            $_SESSION['last_page'] = 'establishment_register.php';

            redirect_to('login.php');
        }

        $con = new connect_database();
        $con->connect();

        $states = $con->consult_all("SELECT * FROM states");

        $cities = $con->consult_all("SELECT * FROM cities");

        $categories = $con->consult_all("SELECT * FROM categories");

        $subcategories = $con->consult_all("SELECT * FROM subcategories");

        $jsonCities = json_encode($cities);
        $jsonSubcategories = json_encode($subcategories);
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
        <div class="form_section">
            <div class="go_back">
                <a href="/view/myaccount.php">
                    <i class="fa-solid fa-chevron-left"></i>
                    Voltar
                </a>
            </div>
            <h1>Cadastre seu negócio!</h1>
            <?php
                if (isset($_REQUEST)) {
                    
                    if(isset($_REQUEST['code'])) {
                        
                        switch ($_REQUEST['code']) {
                            case 422:
                                echo '
                                <div class="form_error">
                                    <span>Algo deu errado!</span> Verifique se todos os campos foram corrigidos corretamente e tente novamente.
                                </div>
                                ';
                                break;
                        }
                    }
                    if(isset($_REQUEST['error_at'])) {

                        switch($_REQUEST['error_at']) {
                            case 'cnpj_validation':
                                echo '
                                <span class="error_at">CNPJ inválido!</span>
                                ';
                                break;
                            case 'email_validation':
                                echo '
                                <span class="error_at">E-mail inválido!</span>
                                ';
                                break;
                            case 'phone_validation':
                                echo '
                                <span class="error_at">Número de telefone inválido!</span>
                                ';
                                break;
                            case 'invalid_state':
                                echo '
                                <span class="error_at">Endereço inválido! Estado inexistente.</span>
                                ';
                                break;
                            case 'invalid_city':
                                echo '
                                <span class="error_at">Endereço inválido! Cidade inexistente.</span>
                                ';
                                break;
                            case 'invalid_description':
                                echo '
                                <span class="error_at">Descrição inválida! Limite de caracteres excedido.</span>
                                ';
                                break;
                            case 'invalid_category':
                                echo '
                                <span class="error_at">Categoria inválida! Categoria inexistente.</span>
                                ';
                                break;
                            case 'invalid_subcategory':
                                echo '
                                <span class="error_at">Subategoria inválida! Subategoria inexistente.</span>
                                ';
                                break;
                            case 'duplicated_cnpj':
                                echo '
                                <span class="error_at">CNPJ duplicado! Este CNJP já foi utilizado para cadastrar um estabelecimento.</span>
                                ';
                                break;
                        }
                    }
                }
            ?>
            <form method="post" action="/controller/establishments_controller.php" enctype="multipart/form-data">

                <!-- 
                    - USER_ID
                    - LAT E LNG
                    - CREATION DATE
                -->
                <h3>Informações</h3>
                <div class="form_input_group">
                    <div class="form_input">
                        <label for="name">
                            Nome
                        </label>
                        <input type="text" name="name" id="name" placeholder="Insira o seu nome do estabelecimento">
                    </div>
                    
                    <div class="form_input">
                        <label for="cnpj">
                            CNPJ
                        </label>
                        <input type="text" name="cnpj" id="cnpj" oninput="cnpj_format(this)" placeholder="Insira o seu CNPJ">
                    </div>
                </div>

                <div class="form_input_group">
                    <div class="form_input">
                        <label for="email">
                            Endereço e-mail
                        </label>
                        <input type="email" name="email" id="email" placeholder="Insira o endereço e-mail do estabelecimento">
                    </div>

                    <div class="form_input">
                        <label for="phone">
                            Telefone
                        </label>
                        <input type="phone" name="phone" id="phone" oninput="phone_format(this)" placeholder="Insira o endereço e-mail do estabelecimento">
                    </div>
                </div>

                <!-- - ENDEREÇO (Rua, Número, Bairro, Cidade, Estado, País) -->
                <h3>Endereço</h3>
                <div class="form_input_group">
                    <div class="form_input">
                        <label for="state">
                            Estado
                        </label>
                        <select name="state" id="state">
                            <option value="" disabled selected>Selecione o estado</option>
                            <?php
                                foreach($states as $s) {
                                    echo '<option value='.$s['id'].'>'.$s['name'].'</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form_input">
                        <label for="city">
                            Cidade
                        </label>
                        <select name="city" id="city">
                            <option value="" disabled selected>Selecione a cidade</option>
                            
                        </select>
                    </div>
                </div>

                <div class="form_input_group">
                    <div class="form_input">
                        <label for="district">
                            Bairro
                        </label>
                        <input type="text" name="district" id="district" placeholder="Insira o bairro">
                    </div>

                    <div class="form_input">
                        <label for="street">
                            Rua
                        </label>
                        <input type="text" name="street" id="street" placeholder="Insira a rua">
                    </div>

                    <div class="form_input">
                        <label for="establishment_number">
                            Número
                        </label>
                        <input type="number" name="establishment_number" id="establishment_number" placeholder="Insira o número">
                    </div>
                </div>

                <h3>Informações adicionais</h3>
                <div class="form_input_group">
                    <div class="form_input">
                        <label for="category">
                            Categoria
                        </label>
                        <select name="category" id="category">
                            <option value="" disabled selected>Selecione uma categoria</option>
                            <?php
                                foreach($categories as $c) {
                                    echo '<option value='.$c['id'].'>'.$c['name'].'</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form_input">
                        <label for="subcategory">
                            Categoria
                        </label>
                        <select name="subcategory" id="subcategory">
                            <option value="" disabled selected>Selecione uma subcategoria</option>
                        </select>
                    </div>
                </div>

                <div class="form_input_group">
                    <div class="form_input">
                        <label for="description">
                            <span>Descrição</span>
                            <span id="description_count">0/200</span>
                        </label>
                        <span id="limit_exceeded"></span>
                        <textarea name="description" id="description" placeholder="Escreva uma breve descrição do seu estabelecimento" ></textarea>
                    </div>
                    <div class="form_input">
                        <label for="image">
                            Foto
                        </label>
                        <input type="file" name="image" id="image">
                    </div>
                </div>

                <!-- https://blog.logrocket.com/creating-custom-select-dropdown-css/ -->

                <div class="submit red_button">
                    <button type="submit" name="register">Continuar</button>
                </div>
            </form>
        </div>
    </main>
    
    <footer>

    </footer>
    <script src="../public/js/input_format.js"></script>

    <script>
        const cities = <?= $jsonCities; ?>;
        console.log(cities);

        const state_select = document.getElementById("state");
        const city_select = document.getElementById("city");

        function update_city_options(state_id) {
            // Limpa as opções anteriores do select de cidades
            city_select.innerHTML = '<option value="" disabled selected>Selecione a cidade</option>';

            const filtered_cities = cities.filter(city => city.state_id == state_id);

            filtered_cities.forEach(city => {
                const option = document.createElement("option");
                option.value = city.id;
                option.textContent = city.name;
                city_select.appendChild(option);
            });
        }

        // Escuta a mudança no select de estados
        state_select.addEventListener("change", () => {
            const selected_state_id = state_select.value;
            update_city_options(selected_state_id);
        });
    </script>

    <script>
        const subcategories = <?= $jsonSubcategories; ?>;
        console.log(subcategories);

        const category_select = document.getElementById("category");
        const subcategory_select = document.getElementById("subcategory");

        function update_subcategory_options(category_id) {
            // Limpa as opções anteriores do select de cidades
            subcategory_select.innerHTML = '<option value="" disabled selected>Selecione uma subcategoria</option>';

            const filtered_subcategory = subcategories.filter(subcategory => subcategory.category_id == category_id);

            filtered_subcategory.forEach(subcategory => {
                const option = document.createElement("option");
                option.value = subcategory.id;
                option.textContent = subcategory.name;
                subcategory_select.appendChild(option);
            });
        }

        // Escuta a mudança no select de estados
        category_select.addEventListener("change", () => {
            const selected_category_id = category_select.value;
            update_subcategory_options(selected_category_id);
        });
    </script>

    <script>
        const desciption_input = document.getElementById('description');
        const description_count = document.getElementById('description_count');
        const limit_exceeded = document.getElementById('limit_exceeded');
        const max_chars = 200;

        desciption_input.addEventListener('input', () => {
            const current_length = desciption_input.value.length;
            description_count.textContent = `${current_length}/200`;
            
            if (current_length > max_chars) {
                limit_exceeded.textContent = 'A descrição deve ser menor do que 200 caracteres!';
                description_count.style.color = 'var(--red-1)';
            }
            else {
                limit_exceeded.textContent = '';
                description_count.style.color = 'var(--gray-2)';
            }
        });
    </script>
    
    <script>

    </script>
</body>

</html>