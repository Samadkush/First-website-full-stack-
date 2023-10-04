<?php
session_start();
$_SESSION['error'] = "Username or email already exists";
var_dump($_SESSION['error']); // Debug output
// Function to connect to the MySQL server
//include 'db_config.php';
function connectToDatabase() {
    // Replace with your MySQL server hostname, username, password, and database name
    $host = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "User";

    // Create a new MySQLi connection
    $conn = new mysqli($host, $username, $password, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
// Function to check if a username or email already exists
function doesUserExist($username, $email) {
    $conn = connectToDatabase();

    // Prepare and execute a query to check if the username or email already exists
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    return $count > 0;
}

// Function to handle user registration
function registerUser($username, $email, $password) {
    $conn = connectToDatabase();

    // Check if the username or email already exists
    if (doesUserExist($username, $email)) {
        header("Location: signup.php?error=Username or email already exists");
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Default role for new users (you can change this according to your role_id in the "roles" table)
    $defaultRole = 2; // Assuming 'user' role has role_id 2

    // Prepare and execute a query to insert user data into the database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $username, $email, $hashedPassword, $defaultRole);

    if ($stmt->execute()) {
        // Registration successful, redirect to login page with a success message
        header("Location: index.php?success=1");
        exit();
    } else {
        // Registration failed, redirect back to the signup page with an error parameter
        header("Location: signup.php?error=Registration failed");
        exit();
    }
}

// Handle user registration
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Register the user
    registerUser($username, $email, $password);
}
?>
