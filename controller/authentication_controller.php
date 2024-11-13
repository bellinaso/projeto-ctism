<?php
    require_once '../controller/redirect_controller.php';

    @session_start();

    function is_logged() {
        if(isset($_SESSION)
            && isset($_SESSION['login'])
            && $_SESSION['login'] != null) {
            return true;
        }
        else {
            return false;
        }
    }
?>