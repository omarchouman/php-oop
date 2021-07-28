<?php

namespace App\Database;

use PDO, PDOException;

class Database {

   private $servername = "localhost";
   private $username = "omar";
   private $password = "omar";

public function __construct(){
    try {
        $conn = new PDO("mysql:host=$servername;dbname=phpexercise", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
      } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }
}

}