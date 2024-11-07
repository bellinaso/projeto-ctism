<?php
    @session_start();

    function redirect_to($page) {
        header("location:../view/$page");
        exit();
    }
?>