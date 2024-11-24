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
                if(isset($result['establishment_id'])) {
                    redirect_to("establishment_page.php?id=$result[establishment_id]&code=200&cancelled=$_POST[establishment_cancellation]");
                }
                else {
                    redirect_to("myaccount.php?info=my_reserves&code=200&cancelled=$_POST[establishment_cancellation]");
                }

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

                if(validate_date($service_date) == false) {
                    redirect_to("establishment_page.php?id=$_POST[establishment_id]&code=422");
                }

                if(validate_availability($availability_id, $service_id) == false) {
                    redirect_to("establishment_page.php?id=$_POST[establishment_id]&code=422");
                }

                $result = reserve_service(
                    $user['id'],
                    $establishment_id,
                    $service_id,
                    $availability_id,
                    date('Y-m-d'),
                    $service_date,
                    'pending');

                redirect_to("../view/myaccount.php?info=my_reserves");
            }
        }
    }


    function reserve_service($user_id, $establishment_id, $service_id, $availability_id, $reserve_date, $service_date, $reserve_status) {
        $con = new connect_database();
        $con->connect();

        $query = $con->execute("INSERT INTO reserves (user_id, establishments_id, service_id, availability_id, reserve_date, service_date, reserve_status)
        VALUES (
            $user_id,
            $establishment_id,
            $service_id,
            $availability_id,
            '$reserve_date',
            '$service_date',
            '$reserve_status'
        );");

        return $query;
    }


    function get_my_reserves() {
        $con = new connect_database();
        $con->connect();

        @session_start();
        $user_id = $con->consult("SELECT id FROM users where email = '$_SESSION[login]'");

        // $query = "SELECT * FROM establishments;";
        $query = "SELECT 
                reserves.id AS id,
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
                WHERE reserves.user_id = $user_id[id];";
                
        $result = $con->consult_all($query);

        if($result != null) {
            return $result;
        }
        else {
            return null;
        }
    }


    function validate_date($date) {
        
        if (!preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/', $date)) {
            return false;
        }

        $date = new DateTime($date);
    
        $current_date = new DateTime();
        $current_date->setTime(0, 0, 0);
        
        $next_week = clone $current_date;
        $next_week->modify('+7 days');
        

        if ($date >= $current_date && $date <= $next_week) {
            return true;
        }
        else {
            return false;
        }
    }


    function validate_availability($availability_id, $service_id) {
        $con = new connect_database();
        $con->connect();

        $availability = $con->consult("SELECT * FROM availability WHERE id = $availability_id");

        if($availability['service_id'] == $service_id) {
            return true;
        }
        else {
            return false;
        }
    }


    function reserve_cancellation($reserve_id, $user) {
        $con = new connect_database();
        $con->connect();

        
        $user = $con->consult("SELECT * FROM users WHERE email = '$user'");
        print_r($user);

        $query = $con->consult("SELECT
                                        establishments.user_id,
                                        reserves.establishments_id,
                                        reserves.user_id as reserve_user_id
                                        FROM reserves
                                        JOIN establishments ON reserves.establishments_id = establishments.id
                                        WHERE reserves.id = $reserve_id;");

        if($user['id'] == $query['user_id'] && $user['user_type'] == 'manager') {
            
            $result = $con->execute("UPDATE reserves SET reserve_status = 'establishment_cancellation' WHERE id = $reserve_id");

            return array('result' => $result, 'establishment_id' => $query['establishments_id']);
        }
        else if ($user['id'] == $query['reserve_user_id'] && $user['user_type'] == 'user') {

            $result = $con->execute("UPDATE reserves SET reserve_status = 'user_cancellation' WHERE id = $reserve_id");
    
            return array('result' => $result);
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