<?php
    require_once '../controller/redirect_controller.php';
    require_once '../controller/authentication_controller.php';
    require_once '../controller/user_controller.php';
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
        else if (isset($_POST['register_reserve'])) {
            if(
                $_POST['available_day'] == null ||
                $_POST['available_times'] == null ||
                $_POST['establishment_id'] == null ||
                $_POST['service_id'] == null
                ) {
                redirect_to("establishment_page.php?id=$_POST[establishment_id]&code=422");
            }
            else {
                if(is_logged() == false) {
                    $_SESSION['last_page'] = "establishment_page.php?id=$_POST[establishment_id]";
        
                    redirect_to('login.php');
                }

                $service_date = $_POST['available_day'];
                $availability_id = $_POST['available_times'];
                $service_id = $_POST['service_id'];
                $establishment_id = $_POST['establishment_id'];
                $user = get_logged_user($_SESSION['login']);

                $result = reserve_service(
                    $user['id'],
                    $establishment_id,
                    $service_id,
                    $availability_id,
                    date('Y-m-d'),
                    $service_date,
                    'pending');
            }
        }
    }
 

    function reserve_service($user_id, $establishment_id, $service_id, $availability_id, $reserve_date, $service_date, $reserve_status) {
        $con = new connect_database();
        $con->connect();

        $availability = $con->consult("SELECT * FROM availability WHERE id = $availability_id");

        if($availability['service_id'] != $service_id) {
            return 'invalid_availability';
        }

        $service_date = validate_date($service_date);

        if($service_date == false) {
            return 'invalid_date';
        }

        
        $query = $con->execute("INSERT INTO reserves (user_id, establishments_id, service_id, availability_id, reserve_date, service_date, reserve_status)
        VALUES (
            $user_id,
            $establishment_id,
            $service_id,
            $availability_id,
            '$reserve_date',
            '".$service_date->format('Y-m-d')."',
            '$reserve_status'
        );");

        return $query;
    }


    function validate_date($date) {
        
        if (!preg_match('/^\d{2}\/\d{2}$/', $date)) {
            return false;
        }
        
        list($day, $month) = explode('/', $date);
    
        $current_year = date('Y');
        $date = DateTime::createFromFormat('d/m/Y', "$day/$month/$current_year");
    
        $current_date = new DateTime();
        $current_date->setTime(0, 0, 0);
        
        $next_week = clone $current_date;
        $next_week->modify('+7 days');
        
        if ($date >= $current_date && $date <= $next_week) {
            return $date;
        }
        else {
            return false;
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