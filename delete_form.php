<?php
// Check if the form_id parameter is provided and is a valid integer
if (isset($_GET['form_id']) && is_numeric($_GET['form_id'])) {
    // Database connection credentials
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "User";

    // Create database connection
    $connection = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Get the form_id from the GET parameter
    $form_id = $_GET['form_id'];

    // Prepare the SQL query to delete the form
    $sql = "DELETE FROM projectApplications WHERE form_id = ?";

    // Create a prepared statement
    $stmt = $connection->prepare($sql);

    // Bind the parameter and execute the statement
    $stmt->bind_param("i", $form_id);

    if ($stmt->execute()) {
        // Form deleted successfully, redirect back to the dashboard or any other page
        header("Location: dashboard.php");
        exit();
    } else {
        // Error occurred during deletion, display an error message or handle it as needed
        echo "Error: " . $stmt->error;
    }

    // Close the statement and the database connection
    $stmt->close();
    $connection->close();
} else {
    // If form_id is not provided or not valid, redirect back to the dashboard or show an error message
    header("Location: dashboard.php");
    exit();
}
