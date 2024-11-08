<?php
    require_once '../controller/redirect_controller.php';

    if($_POST) {
        include_once '../model/database_connect.php';

        // Validate inputs
        if(
            !isset($_POST['name']) ||
            !isset($_POST['email']) ||
            !isset($_POST['phone']) ||
            !isset($_POST['cpf']) ||
            !isset($_POST['password']) ||
            !isset($_POST['password_confirm']) ||
            !isset($_POST['state']) ||
            !isset($_POST['city'])
        ) {
            redirect_to('register.php?code=422&error_at=empty_input');
        }
        else {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = preg_replace('/[^0-9]/', '', trim($_POST['phone']));
            $cpf = preg_replace('/[^0-9]/', '', trim($_POST['cpf']));
            // $cpf = $_POST['cpf'];

            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            $state = $_POST['state'];
            $city = $_POST['city'];
        }


        // Validate email
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            redirect_to('register.php?code=422&error_at=email_validation');
        }


        // Validate phone        
        if(!is_numeric($phone) && (!strlen($phone) == 10 || !strlen($phone) == 11)) {
            redirect_to('register.php?code=422&error_at=phone_validation');
        }


        // Validate CPF
        if(!validate_cpf($cpf)) {
            redirect_to('register.php?code=422&error_at=cpf_validation');
        }


        // Validate password
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
        if(
            strlen($password) < 8 ||
            !preg_match($pattern, $password) ||
            preg_match('/\s/', $password)
        ) {
            redirect_to('register.php?code=422&error_at=password_format_validation');
        }
        else if($password != $password_confirm) {
            redirect_to('register.php?code=422&error_at=password_match_validation');
        }


        // Tenta executar a inserção
        $error_message = user_register($cpf, $name, $email, $phone, $state, $city, $password, 'user', date('Y-m-d'));
        
        if($error_message == null) {
            @session_start();
            $_SESSION['login'] = $email;
            redirect_to($_SESSION['last_page']);
        }
        else {
            if(preg_match("/users\.(\w+)/", $error_message, $matches)) {
                $affected_column = $matches[1]; 
            }
            redirect_to("register.php?code=422&error_at=duplicated_$affected_column");
        }
    
    }


    function user_register($cpf, $name, $email, $phone, $state, $city, $password, $user_type, $creation_date) {
        $con = new connect_database();
        $con -> connect();

        $query = "INSERT INTO users (cpf, name, email, phone, state, city, password, user_type, creation_date)
                            VALUES ('$cpf', '$name', '$email', '$phone', '$state', '$city', '$password', '$user_type', '$creation_date')";

        $result = $con -> execute($query);

        if($result == null) {
            return $result;
        }
        else {
            return $result->getMessage();
        }
    }


    function validate_cpf($cpf) {
    
        if(strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
    
        // Calcula o primeiro dígito verificador
        for ($t = 9; $t < 11; $t++) {
            $soma = 0;
            for ($i = 0; $i < $t; $i++) {
                $soma += $cpf[$i] * (($t + 1) - $i);
            }
            $digito = ((10 * $soma) % 11) % 10;
            if($cpf[$i] != $digito) {
                return false;
            }
        }
    
        return true;
    }
?>