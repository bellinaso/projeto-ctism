<?php
    @include '../config.php';
    require_once '../controller/redirect_controller.php';
    include_once '../model/database_connect.php';

    if($_POST) {

        // TODO: Fazer um user_controller e utilizar o mesmo princípio abaixo
        if(isset($_POST['register'])) {
            if(
                !isset($_POST['name']) ||
                !isset($_POST['cnpj']) ||
                !isset($_POST['email']) ||
                !isset($_POST['phone']) ||
                !isset($_POST['state']) ||
                !isset($_POST['city']) ||
                !isset($_POST['district']) ||
                !isset($_POST['street']) ||
                !isset($_POST['establishment_number']) ||
                !isset($_POST['description']) ||
                !isset($_POST['category']) ||
                !isset($_POST['subcategory'])
            ) {
                redirect_to('establishment_register.php?code=422&error_at=empty_input');
            }
            else {
                // Information
                $name = ucwords(trim($_POST['name']));
                $cnpj = preg_replace('/[^0-9]/','',trim($_POST['cnpj'])); // não pode ter igual
                $phone = preg_replace('/[^0-9]/','',trim($_POST['phone'])); // não pode ter igual
                $email = $_POST['email'];

                // Address
                $state_id = $_POST['state']; // tem que estar no banco
                $city_id = $_POST['city']; // tem que estar no banco
                $district = $_POST['district'];
                $street = $_POST['street'];
                $establishment_number = $_POST['establishment_number'];

                // Additional information
                $description = trim($_POST['description']); // tem que ser < 200
                $category = $_POST['category']; // tem que estar no banco
                $subcategory = $_POST['subcategory'];
            }

            $con = new connect_database();
            $con->connect();

            // Validate cnpj
            if(!validate_cnpj($cnpj)) {
                redirect_to('establishment_register.php?code=422&error_at=cnpj_validation');
            }
            
            
            // Validate email
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                redirect_to('establishment_register.php?code=422&error_at=email_validation');
            }
            
            // Validate phone
            if(!is_numeric($phone) && (!strlen($phone) == 10 || !strlen($phone) == 11)) {
                redirect_to('establishment_register.php?code=422&error_at=phone_validation');
            }
            
            // Validate state
            if(($state = $con->consult("SELECT name FROM states WHERE id = $state_id")) == null) {
                redirect_to('establishment_register.php?code=422&error_at=invalid_state');
            }
            
            // Validate city
            if(($city = $con->consult("SELECT name FROM cities WHERE id = $city_id")) == null) {
                redirect_to('establishment_register.php?code=422&error_at=invalid_city');
            }
            
            // Validate description
            if(strlen($description) > 200) {
                redirect_to('establishment_register.php?code=422&error_at=invalid_description');
            }
            
            // Validate category
            if(($con->consult("SELECT name FROM categories WHERE id = $category")) == null) {
                redirect_to('establishment_register.php?code=422&error_at=invalid_category');
            }
            
            // Validate subcategory
            if(($con->consult("SELECT name FROM subcategories WHERE id = $subcategory")) == null) {
                redirect_to('establishment_register.php?code=422&error_at=invalid_subcategory');
            }

            // Image Validation
            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = './uploads/';
    
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $file_temp_path = $_FILES['image']['tmp_name'];
                $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            
                $new_file_name = $cnpj.'.jpg';
                $destination = $upload_dir.$new_file_name;
            
                if (!move_uploaded_file($file_temp_path, $destination)) {
                    redirect_to('establishment_register.php?code=422&error_at=saving_image');
                }
            }

            $address = "Rua $street, $establishment_number, Bairro $district, $city[name], $state[name], Brazil";
            // Rua, Número, Bairro, Cidade, Estado, País

            $geolocation = get_geolocation($address);
            print_r($geolocation);
            
            @session_start();
            $login = $_SESSION['login'];
            $user = $con->consult("SELECT * FROM users WHERE email = '$login'");
            
            $error_message = establishment_register($cnpj, $user['id'], $email, $name, $address, $geolocation['lat'], $geolocation['lng'], $phone, $description, $category, $subcategory, date("Y-m-d"));

            if($error_message == null) {
                
                $con->execute("UPDATE users SET user_type = 'manager' WHERE email = '$login';");
            }
            else {
                if(preg_match("/establishments\.(\w+)/", $error_message, $matches)) {
                    $affected_column = $matches[1]; 
                }   
                redirect_to("establishment_register.php?code=422&error_at=duplicated_$affected_column");
            }
        }
        else if(isset($_POST['update'])) {

        }
    }

    
    function establishment_register($cnpj, $user_id, $email, $name, $address, $latitude, $longitude, $phone, $description, $category_id, $subcategory_id, $creation_date) {

        $con = new connect_database();
        $con -> connect();

        $query = "INSERT INTO establishments (cnpj, user_id, email, name, address, latitude, longitude, phone, description, category_id, subcategory_id, creation_date)
                            VALUES (
                            '$cnpj',
                            '$user_id',
                            '$email',
                            '$name',
                            '$address',
                            '$latitude',
                            '$longitude',
                            '$phone',
                            '$description',
                            '$category_id',
                            '$subcategory_id',
                            '$creation_date')";

        $result = $con -> execute($query);

        if($result == '1') {
            $result = null;
            print_r($result);
            return $result;
        }
        else {
            return $result->getMessage();
        }
    }


    function get_geolocation($adress) {
        // Rua, Número, Bairro, Cidade, Estado, País
        $apiKey = API_KEY;

        // Fazendo a requisição para a API de Geocoding
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($adress) . "&key=" . $apiKey;
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        // Verifica se há resultado válido
        if ($data['status'] == "OK") {
            $lat = $data['results'][0]['geometry']['location']['lat'];
            $lng = $data['results'][0]['geometry']['location']['lng'];

            return array(
                "lat" => $lat,
                "lng" => $lng
            );
        }
        else {
            echo "Erro na api: $data[status]";
            return null;
        }
    }


    function get_establishments() {
        $con = new connect_database();
        $con->connect();

        // $query = "SELECT * FROM establishments;";
        $query = "SELECT establishments.*, 
                    categories.name AS category_name, 
                    subcategories.name AS subcategory_name
                    FROM establishments
                    JOIN categories ON establishments.category_id = categories.id
                    LEFT JOIN subcategories ON establishments.subcategory_id = subcategories.id;";
                
        $result = $con->consult_all($query);

        if($result != null) {
            return $result;
        }
        else {
            return null;
        }
    }


    function get_one_establishment($id) {
        $con = new connect_database();
        $con->connect();

        // $query = "SELECT * FROM establishments;";
        $query = "SELECT establishments.*, 
                    categories.name AS category_name, 
                    subcategories.name AS subcategory_name
                    FROM establishments
                    JOIN categories ON establishments.category_id = categories.id
                    LEFT JOIN subcategories ON establishments.subcategory_id = subcategories.id
                    WHERE establishments.id = $id;";
                
        $result = $con->consult($query);

        if($result != null) {
            return $result;
        }
        else {
            return null;
        }
    }


    function get_my_establishments() {
        $con = new connect_database();
        $con->connect();

        @session_start();
        $user_id = $con->consult("SELECT id FROM users where email = '$_SESSION[login]'");

        // $query = "SELECT * FROM establishments;";
        $query = "SELECT establishments.*, 
                    categories.name AS category_name, 
                    subcategories.name AS subcategory_name
                    FROM establishments
                    JOIN categories ON establishments.category_id = categories.id
                    LEFT JOIN subcategories ON establishments.subcategory_id = subcategories.id
                WHERE establishments.user_id = $user_id[id];";
                
        $result = $con->consult_all($query);

        if($result != null) {
            return $result;
        }
        else {
            return null;
        }
    }


    function get_services_from_establishment($id) {
        $con = new connect_database();
        $con->connect();

        $query = "SELECT * FROM services where establishments_id = $id";

        $result = $con->consult_all($query);

        if($result != null) {
            return $result;
        }
        else {
            return null;
        }
    }


    function get_availability_from_service($id) {
        $con = new connect_database();
        $con->connect();

        $query = "SELECT 
                availability.id AS id,
                availability.service_id AS service_id,
                availability.week_days,
                availability.start_time,
                services.name AS service_name,
                establishments.name AS establishment_name
                FROM  availability
                INNER JOIN services ON availability.service_id = services.id
                INNER JOIN establishments ON services.establishments_id = establishments.id
                WHERE establishments.id = $id;";

        $result = $con->consult_all($query);

        if($result != null) {
            return $result;
        }
        else {
            return null;
        }
    }


    function get_reserves_from_establishment($id) {
        $con = new connect_database();
        $con->connect();

        $query = "SELECT 
                reserves.id AS id,
                reserves.establishments_id AS establishment_name,
                users.name AS user_name,
                establishments.name AS establishment_name,
                services.name AS service_name,
                availability.start_time AS availability_time,
                reserves.reserve_date,
                reserves.service_date,
                reserves.reserve_status
                FROM reserves
                JOIN users ON reserves.user_id = users.id
                JOIN establishments ON reserves.establishments_id = establishments.id
                JOIN services ON reserves.service_id = services.id
                JOIN availability ON reserves.availability_id = availability.id
                WHERE reserves.establishments_id = $id;";

        $result = $con->consult_all($query);

        if($result != null) {
            return $result;
        }
        else {
            return null;
        }
    }


    function validate_cnpj($cnpj) {
        // Remove qualquer caractere que não seja número
        $cnpj = preg_replace('/\D/', '', $cnpj);
    
        // Verifica se o CNPJ tem 14 dígitos e se não é uma sequência de números repetidos
        if (strlen($cnpj) != 14 || preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }
    
        // Cálculo do primeiro dígito verificador
        $multiplicadores1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $soma = 0;
        for ($i = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $multiplicadores1[$i];
        }
        $digito1 = ($soma % 11) < 2 ? 0 : 11 - ($soma % 11);
    
        // Verifica o primeiro dígito
        if ($cnpj[12] != $digito1) {
            return false;
        }
    
        // Cálculo do segundo dígito verificador
        $multiplicadores2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $soma = 0;
        for ($i = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $multiplicadores2[$i];
        }
        $digito2 = ($soma % 11) < 2 ? 0 : 11 - ($soma % 11);
    
        // Verifica o segundo dígito
        return $cnpj[13] == $digito2;
    }
?>
