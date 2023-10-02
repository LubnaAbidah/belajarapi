<?php

// Contoh Class Database menggunakan PDO

class Database {

    private $host;
    private $dbname;
    private $username;
    private $password;
    public $connection;

    public function __construct($db_setting) {
        $this->host = $db_setting['host'];
        $this->dbname = $db_setting['dbname'];
        $this->username = $db_setting['username'];
        $this->password = $db_setting['password'];
    }

    public function connect() {
        try {
            $this->connection = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           // echo "Connected to the database successfully.";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function disconnect() {
        $this->connection = null;
        echo "Disconnected from the database.";
    }
}

$db_setting = [
    'host' => 'localhost',
    'dbname' => 'belajarapi',
    'username' => 'root',
    'password' => '',
];


