<?php
    require_once '../controller/redirect_controller.php';
    require_once '../controller/authentication_controller.php';
    require_once '../controller/user_controller.php';
    include_once '../model/database_connect.php';

    if($_POST) {

        if(isset($_POST['create_new'])) {

            if(
                (!isset($_POST['name']) && trim($_POST['name']) != '') ||
                !isset($_POST['establishment_id'])
            ) {
                if(isset($_POST['establishment_id'])) {
                    redirect_to("establishment_page.php?id=$_POST[establishment_id]&code=422");
                }
                else {
                    redirect_to("establishments.php");
                }
            }
            else {
                if(isset($_POST['service_availability_time_0'])) {
                    $monday = $_POST['service_availability_time_0'];
                }
                else {
                    $monday = null;
                }
                if(isset($_POST['service_availability_time_1'])) {
                    $tuesday = $_POST['service_availability_time_1'];
                }
                else {
                    $tuesday = null;
                }
                if(isset($_POST['service_availability_time_2'])) {
                    $wednesday = $_POST['service_availability_time_2'];
                }
                else {
                    $wednesday = null;
                }
                if(isset($_POST['service_availability_time_3'])) {
                    $thursday = $_POST['service_availability_time_3'];
                }
                else {
                    $thursday = null;
                }
                if(isset($_POST['service_availability_time_4'])) {
                    $friday = $_POST['service_availability_time_4'];
                }
                else {
                    $friday = null;
                }
                if(isset($_POST['service_availability_time_5'])) {
                    $saturday = $_POST['service_availability_time_5'];
                }
                else {
                    $saturday = null;
                }
                if(isset($_POST['service_availability_time_6'])) {
                    $sunday = $_POST['service_availability_time_6'];
                }
                else {
                    $sunday = null;
                }
                
                $service_name = trim($_POST['name']);
                $service_description = trim($_POST['description']);
                
                @session_start();
                $service_id = service_register(
                    $_SESSION['login'],
                    $_POST['establishment_id'],
                    $service_name,
                    $service_description,
                    date('Y-m-d'));
                
                    print_r($service_id);
                    
                availability_register($service_id, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday);

                redirect_to("establishment_page.php?id=$_POST[establishment_id]&code=200");
            }
        }
    }

    function service_register($user, $establishment_id, $service_name, $service_description, $creation_date) {
        $con = new connect_database();
        $con->connect();

        $user = $con->consult("SELECT * FROM users WHERE email = '$user'");
        $establishment = $con->consult("SELECT * FROM establishments WHERE id = '$establishment_id'");



        if($user['id'] == $establishment['user_id']) {
            return $con->execute("INSERT INTO services (establishments_id, name, description, creation_date) 
            VALUES
            ($establishment_id,
            '$service_name',
            '$service_description',
            '$creation_date');
            ");
        }
    }

    function availability_register($service_id, $monday = null, $tuesday = null, $wednesday = null, $thursday = null, $friday = null, $saturday = null, $sunday = null
    ) {
        $con = new connect_database();
        $con->connect();

        if(isset($monday)) {
            foreach ($monday as $a) {
                $con->insert("INSERT INTO availability (service_id, week_days, start_time)
                VALUES
                ($service_id,
                'monday',
                '$a');
                ");
            }
        }
        if(isset($tuesday)) {
            foreach ($monday as $a) {
                $con->insert("INSERT INTO availability (service_id, week_days, start_time)
                VALUES
                ($service_id,
                'tuesday',
                '$a');
                ");
            }
        }
        if(isset($wednesday)) {
            foreach ($monday as $a) {
                $con->insert("INSERT INTO availability (service_id, week_days, start_time)
                VALUES
                ($service_id,
                'wednesday',
                '$a');
                ");
            }
        }
        if(isset($thursday)) {
            foreach ($monday as $a) {
                $con->insert("INSERT INTO availability (service_id, week_days, start_time)
                VALUES
                ($service_id,
                'thursday',
                '$a');
                ");
            }
        }
        if(isset($friday)) {
            foreach ($monday as $a) {
                $con->insert("INSERT INTO availability (service_id, week_days, start_time)
                VALUES
                ($service_id,
                'friday',
                '$a');
                ");
            }
        }
        if(isset($saturday)) {
            foreach ($monday as $a) {
                $con->insert("INSERT INTO availability (service_id, week_days, start_time)
                VALUES
                ($service_id,
                'saturday',
                '$a');
                ");
            }
        }
        if(isset($sunday)) {
            foreach ($monday as $a) {
                $con->insert("INSERT INTO availability (service_id, week_days, start_time)
                VALUES
                ($service_id,
                'sunday',
                '$a');
                ");
            }
        }
    }
?>