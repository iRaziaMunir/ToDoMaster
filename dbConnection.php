<?php 

// class DbConnection{

//   private $server = "localhost";
//   private $username = "root";
//   private $password = "";
//   private $database = "TaskManagementSystem";
//   protected $connection = "";

//   function databaseConnection(){
   
//     $server = $this->server;
//     $username = $this->username;
//     $password = $this->password;
//     $database = $this->database;
    
//     try{

//       $this->connection = new mysqli($server, $username, $password, $database);
//       return $this->connection;
//     }
//    catch(mysqli_sql_exception $exception){

//       return $exception;
//    }
//   }

// }

$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'formDB';

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

if(mysqli_connect_error()){

  die("Connection failed: " . $connection->connect_error);
}
else
{
  // echo "Connection is established";
}
?>

