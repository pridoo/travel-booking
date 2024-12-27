<?php

class Database {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $port;
    private $conn;

    public function __construct($servername, $username, $password, $dbname, $port) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->port = $port;
    }

    public function connect() {
        
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname, $this->port);
        
        
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        return $this->conn;
    }

    public function closeConnection() {
        $this->conn->close();
    }
}

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'travel_tour');
define('DB_PORT', '3306');

$database = new Database(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

$conn = $database->connect();

?>
