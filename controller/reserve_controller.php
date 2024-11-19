<?php
    require_once '../controller/redirect_controller.php';
    include_once '../model/database_connect.php';

    if($_POST) {
        @session_start();
        if(isset($_POST['establishment_cancellation'])) {

            $result = reserve_cancellation($_POST['establishment_cancellation'], $_SESSION['login']);
            
            if($result['result'] != 1) {
                redirect_to('establishment_page.php?code=401');
            }
            else {
                redirect_to("establishment_page.php?id=$result[establishment_id]&code=200&cancelled=$_POST[establishment_cancellation]");
            }
        }
        else if (isset($_POST['complete'])) {
            $result = reserve_complete($_POST['complete'], $_SESSION['login']);
            
            if($result['result'] != 1) {
                redirect_to('establishment_page.php?code=401');
            }
            else {
                redirect_to("establishment_page.php?id=$result[establishment_id]&code=200&completed=$_POST[complete]");
            }

        }
    }


    function reserve_cancellation($reserve_id, $user) {
        $con = new connect_database();
        $con->connect();

        
        $user = $con->consult("SELECT * FROM users WHERE email = '$user'");

        $query = $con->consult("SELECT
                                        establishments.user_id,
                                        reserves.establishments_id
                                        FROM reserves
                                        JOIN establishments ON reserves.establishments_id = establishments.id
                                        WHERE reserves.id = $reserve_id;");

        if($user['id'] == $query['user_id']) {
            
            $result = $con->execute("UPDATE reserves SET reserve_status = 'establishment_cancellation' WHERE id = $reserve_id");

            return array('result' => $result, 'establishment_id' => $query['establishments_id']);
        }
    }


    function reserve_complete($reserve_id, $user) {
        $con = new connect_database();
        $con->connect();

        
        $user = $con->consult("SELECT * FROM users WHERE email = '$user'");

        $query = $con->consult("SELECT
                                        establishments.user_id,
                                        reserves.establishments_id
                                        FROM reserves
                                        JOIN establishments ON reserves.establishments_id = establishments.id
                                        WHERE reserves.id = $reserve_id;");

        if($user['id'] == $query['user_id']) {
            
            $result = $con->execute("UPDATE reserves SET reserve_status = 'completed' WHERE id = $reserve_id");

            return array('result' => $result, 'establishment_id' => $query['establishments_id']);
        }
    }
?>