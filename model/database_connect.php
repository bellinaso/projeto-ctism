<?php
class connect_database {

    protected $mysqli;
    protected $host = '127.0.0.1';
    protected $user = 'root';
    protected $password = '';
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
            if ($resultado = $this->mysqli->query($query)){
                $this->mysqli->commit();
            }
            else {
                $this->rows_affected = 0;
                throw new Exception('Erro');
            }
        }
        catch (Exception $exc) {
            $this->mysqli->rollback();
            $this->disconnect();
        }
    }


    public function consult($query) {
        try {
            if ($result = $this->mysqli->query($query)){
                $this->rows_affected = $result->num_rows;
                return $result;
            } else {
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