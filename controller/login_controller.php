<?php
    require_once '../controller/redirect_controller.php';

    if($_POST) {
        include_once '../model/database_connect.php';

        $login = $_POST['login'];
        $password = $_POST['password'];
        
        $result = user_login($login, $password);

        if($result != null) {
            @session_start();

            $_SESSION['login'] = $result['email'];
            redirect_to($_SESSION['last_page']);
        }
        else {
            redirect_to('login.php?code=401');
        }
    }


    function user_login($login, $password) {
        $con = new connect_database();
        $con->connect();

        $query = "SELECT * FROM users WHERE (email = $login OR cpf = $login) AND password = $password;";
        $result = $con->consult($query);

        return $result;
    }
?>