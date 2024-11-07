<?php
    require_once '../controller/redirect_controller.php';

    if($_POST) {
        include_once '../model/database_connect.php';

        $name = $_POST['complete_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $cpf = $_POST['cpf'];

        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];

        $state = $_POST['state'];
        $city = $_POST['city'];

        // Validate inputs
        if(
            !isset($name) ||
            !isset($email) ||
            !isset($phone) ||
            !isset($cpf) ||
            !isset($password) ||
            !isset($password_confirm) ||
            !isset($state) ||
            !isset($city)
        ) {
            redirect_to('register.php?code=422&error_at=empty_input');
        }

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            redirect_to('register.php?code=422&error_at=email_validation');
        }
        
        // TODO: Validate CPF
        // if () {
        //     redirect_to('register.php?code=422&error_at=');
        // }
        // Precisa verificar se: (removendo os . e -) há exatamente 9 números
            
        // Validate password
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
        if(
            strlen($password) < 8 ||
            $password != $password_confirm ||
            !preg_match($pattern, $password)
        ) {
            redirect_to('register.php?code=422&error_at=password_validation');
        }

        
    }
?>