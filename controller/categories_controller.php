<?php
    function get_subcategory() {
        $con = new connect_database();
        $con->connect();

        $query = "SELECT * FROM subcategories;";

        $result = $con->consult_all($query);

        if($result != null) {
            return $result;
        }
        else {
            return null;
        }
    }
?>