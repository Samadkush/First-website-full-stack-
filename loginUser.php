<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start(); // Start the session here

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
// Function to handle user login
function loginUser($email, $password) {
    $conn = connectToDatabase();

    // Prepare and execute a query to fetch user data by email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Check if a user with the provided email exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $user["password"])) {
            // If the login is successful, set session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["user_id"] = $user["user_id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["user_role"] = $user["role_id"];

            // Redirect to the appropriate page based on user role
            if ($user["role_id"] == 1) {
                // Redirect to admin dashboard (replace "admin_dashboard.php" with the actual admin dashboard page)
                header("Location: admin_dashboard.php");
            } else {
                // Redirect to user dashboard (replace "user_dashboard.php" with the actual user dashboard page)
                header("Location: dashboard.php");
            }
            exit();
        } else {
            // Password is incorrect, redirect back to the login page with an error message
            header("Location: index.php?error=Incorrect email or password");
            exit();
        }
    } else {
        // User with the provided email does not exist, redirect back to the login page with an error message
        header("Location: index.php?error=Incorrect email or password");
        exit();
    }
}

// Handle user login
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["email"]) && isset($_POST["password"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Call the loginUser function to handle the login
    loginUser($email, $password);
}
?>