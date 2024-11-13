<?php
    require_once '../controller/redirect_controller.php';

    @session_start();

    if(isset($_SESSION)) {

        if(isset($_SESSION['login'])) {
            $_SESSION['login'] = null;
            redirect_to('establishments.php');
        }
    }
?>