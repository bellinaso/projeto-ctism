<?php
class connect_database {

    protected $mysqli;
    protected $host = '127.0.0.1';
    protected $user = 'root';
    protected $password = '12345';
    protected $database = 'bookease';

    public $rows_affected = 0;

    public $lastInsertId = 0;

    public function get_connection() {
        return $this->mysqli;
    }


    public function connect() {
        $this->mysqli = new mysqli($this->host, $this->user, $this->password, $this->database);

        if ($this->mysqli->errno) {
            echo("Error while connecting to database. Error:" . $this->mysqli->connect_errno);
            exit();
        }
        
        $this->mysqli->set_charset('utf8');
    }


    public function execute($query) {
        try {
            if ($result = $this->mysqli->query($query)){
                $last_insert_id = $this->mysqli->insert_id;
                $this->mysqli->commit();
                return $result;
            }
            else {
                $this->rows_affected = 0;
                throw new Exception();
            }
        }
        catch (Exception $exc) {
            $this->mysqli->rollback();
            $this->disconnect();
            print_r($exc);
            return $exc;
        }
    }

    public function insert($query) {
        try {
            if ($result = $this->mysqli->query($query)){
                $last_insert_id = $this->mysqli->insert_id;
                $this->mysqli->commit();
                return ($last_insert_id);
            }
            else {
                $this->rows_affected = 0;
                throw new Exception();
            }
        }
        catch (Exception $exc) {
            $this->mysqli->rollback();
            $this->disconnect();
            print_r($exc);
            return $exc;
        }
    }


    public function consult($query) {
        try {
            if ($result = $this->mysqli->query($query)){
                $this->rows_affected = $result->num_rows;
                $result = mysqli_fetch_assoc($result);
                return $result;
            }
            else {
                $this->rows_affected = 0;
                return null;
            }
        }
        catch (Exception $exc) {
            $this->disconnect();
        }
    }


    public function consult_all($query) {
        try {
            if ($result = $this->mysqli->query($query)){
                $this->rows_affected = $result->num_rows;
                $result = $result->fetch_all(MYSQLI_ASSOC);
                return $result;
            }
            else {
                $this->rows_affected = 0;
                return null;
            }
        }
        catch (Exception $exc) {
            $this->disconnect();
        }
    }


    public function convert_to_date($date) {
        $date = explode('-', $date);
        return ' ' . $date[2] . '-' . $date[1] . '-' . $date[0];
    }


    public function disconnect(){
        $this->mysqli->close();
    }

}