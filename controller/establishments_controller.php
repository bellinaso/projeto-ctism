<?php
    @include '../config.php';
    include_once '../model/database_connect.php';

    // TODO
    // <form method="post" action="yourFileName.php">
    //     <input type="text" name="studentname">
    //     <input type="submit" value="click" name="submit">
    // IDEA assign a name for the button
    // </form>

    // <?php
        // function display() {
        //     echo "hello ".$_POST["studentname"];
        // }
        // if(isset($_POST['submit'])) {
        //     display();
        // } 
    // ? >

    if($_POST) {

        if(isset($_POST['register'])) {
            echo 'deu certo';
            // TODO: validação de dados
        }
        else if(isset($_POST['update'])) {
            
        }
    }

    
    function establishment_register($cnpj, $user_id, $email, $name, $adress, $latitude, $longitude, $phone, $description, $creation_date) {

        $con = new connect_database();
        $con -> connect();

        $query = "INSERT INTO establishments (cnpj, user_id, email, name, adress, latitude, longitude, phone, description, creation_date)
                            VALUES ('$cnpj', '$user_id', '$email', '$name', '$adress', '$latitude', '$longitude', '$phone', '$description', '$creation_date')";

        $result = $con -> execute($query);

        if($result == 1) {
            $result = null;
            print_r($result);
            return $result;
        }
        else {
            print_r($result);
            return $result->getMessage();
        }
    }


    function get_geolocation($adress) {
        // Rua, Número, Bairro, Cidade, Estado, País
        $apiKey = API_KEY;

        // Fazendo a requisição para a API de Geocoding
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($adress) . "&key=" . $apiKey;
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        // Verifica se há resultado válido
        if ($data['status'] == "OK") {
            $lat = $data['results'][0]['geometry']['location']['lat'];
            $lng = $data['results'][0]['geometry']['location']['lng'];

            return array(
                "lat" => $lat,
                "lng" => $lng
            );
        }
        else {
            return null;
        }
    }


    function get_establishments() {
        $con = new connect_database();
        $con->connect();

        $query = "SELECT * FROM establishments;";
        $result = $con->consult($query);

        if($result != null) {
            return $result;
        }
        else {
            return null;
        }
    }
?>
