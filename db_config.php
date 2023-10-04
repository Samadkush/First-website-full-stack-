<?php
 // Include the database connection file
 // Check if the user is not logged in or not an admin, then redirect to the login page
 if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit();
}
 
 
 // Function to connect to the MySQL server
 function connectToDatabase() {
     // Replace with your MySQL server hostname, username, password, and database name
     $host = "localhost";
     $username = "root";
     $password = "root";
     $dbname = "User";

     //$host = "localhost";
    // $username = "studeoaa_abdsamad";
    // $password = "n$4!*i_QM!N_";
    // $dbname = "studeoaa_abdsamad";
 
 
     // Create a new MySQLi connection
     $conn = new mysqli($host, $username, $password, $dbname);
 
     // Check if the connection was successful
     if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
     }
 
     return $conn;
 }
?>
