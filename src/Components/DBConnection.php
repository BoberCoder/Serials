<?php

namespace Serials\Components;

class DBConnection
{
    private $connection;

    public function __construct($username, $password)
    {
        $this->connection = new \PDO('mysql:host=localhost;charset=UTF8', $username, $password);
        $this->connection = new \PDO('mysql:host=localhost;dbname=serials;charset=UTF8', $username, $password);
        if (!$this->connection) {
            echo 'Connecting error';
        }
    }
    public function getConnection()
    {
        return $this->connection;
    }
}