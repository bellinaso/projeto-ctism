<?php
    function get_logged_user($login) {
        $con = new connect_database();
        $con->connect();

        $query = "SELECT * FROM users where email = '$login';";

        $result = $con->consult($query);

        if($result != null) {
            return $result;
        }
        else {
            return null;
        }
    }
?>