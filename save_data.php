<?php
//check for errors
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Start the session to maintain login state across pages
session_start();

// Check if the user is not logged in, then redirect to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit();
}


// Function to connect to the MySQL server
include 'db_config.php';

// Function to sanitize user input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function getLastFormIdFromDatabase($connection) {
    $sql = "SELECT form_id FROM projectApplications ORDER BY form_id DESC LIMIT 1";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the latest form_id from the result
        $row = $result->fetch_assoc();
        $last_form_id = $row["form_id"];
    } else {
        // If no form_id exists, start with '00' as the initial form ID.
        $current_year = date('Y');
        $current_month = date('m');
        $last_form_id = $current_year . $current_month . '00';
    }

    return $last_form_id;
}

// Function to handle form submission
function submitForm() {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Database connection credentials
       // $servername = "localhost";
        //$username = "studeoaa_abdsamad";
        //$password = "n$4!*iQM!N_";
        //$dbname = "studeoaa_abdsamad";

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

        // Retrieve the logged-in user's userId
        $userId = $_SESSION["user_id"];

        // Generate the form ID based on the current year and month
        $formId = generate_form_id($connection);

        // Retrieve form inputs and sanitize them
        $StudyDescription = sanitize_input($_POST['StudyDescription']);
        $ExplainData = sanitize_input($_POST['ExplainData']);
        $StudyResult = sanitize_input($_POST['StudyResult']);
        $yesno1 = isset($_POST['yesno1']) ? sanitize_input($_POST['yesno1']) : '';
        $StudyDescription_1 = isset($_POST['StudyDescription_1']) ? sanitize_input($_POST['StudyDescription_1']) : '';
        $yesno2 = isset($_POST['yesno2']) ? sanitize_input($_POST['yesno2']) : '';
        $StudyDescription_2 = isset($_POST['StudyDescription_2']) ? sanitize_input($_POST['StudyDescription_2']) : '';
        $StudyResult_1 = isset($_POST['StudyResult_1']) ? sanitize_input($_POST['StudyResult_1']) : '';
        $yesno3 = isset($_POST['yesno3']) ? sanitize_input($_POST['yesno3']) : '';
        $StudyDescription_3 = isset($_POST['StudyDescription_3']) ? sanitize_input($_POST['StudyDescription_3']) : '';
        $Name = sanitize_input($_POST['Name']);
        $ResearcherSignature = sanitize_input($_POST['ResearcherSignature']);
        $Name_1 = sanitize_input($_POST['Name_1']);
        $SupervisorSignature =sanitize_input($_POST['SupervisorSignature']);
        $status = 'new'; // Set the status to "new" for initial submission
        $submissionDate = date("Y-m-d");
        // Prepare the SQL query
        $sql = "INSERT INTO projectApplications (user_id, form_id, StudyDescription, ExplainData, StudyResult, yesno1, StudyDescription_1, yesno2, StudyDescription_2, StudyResult_1, yesno3, StudyDescription_3, Name, ResearcherSignature, Name_1, SupervisorSignature, status, submissionDate)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Create a prepared statement
        $stmt = $connection->prepare($sql);

        // Bind the parameters and execute the statement
        $stmt->bind_param(
            "isssssssssssssssss",
            $userId,
            $formId,
            $StudyDescription,
            $ExplainData,
            $StudyResult,
            $yesno1,
            $StudyDescription_1,
            $yesno2,
            $StudyDescription_2,
            $StudyResult_1,
            $yesno3,
            $StudyDescription_3,
            $Name,
            $ResearcherSignature,
            $Name_1,
            $SupervisorSignature,
            $status,
            $submissionDate
        );
        
        if ($stmt->execute()) {
            header('Location: dashboard.php#Application-status');

        exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement and the database connection
        $stmt->close();
        $connection->close();
    }
}

// Function to generate the form ID based on the current year and month
function generate_form_id($connection) {
    $current_year = date('Y');
    $current_month = date('m');
    $last_form_id = getLastFormIdFromDatabase($connection);

    if ($last_form_id && strpos($last_form_id, $current_year . $current_month) !== false) {
        $last_number = intval(substr($last_form_id, 6));
        $new_number = str_pad($last_number + 1, 2, '0', STR_PAD_LEFT);
        $form_id = $current_year . $current_month . $new_number;
    } else {
        $form_id = $current_year . $current_month . '00';
    }

    return $form_id;
}

// Function to retrieve the last form ID from the database

// Call the submitForm function to handle form submission
submitForm();
?>
