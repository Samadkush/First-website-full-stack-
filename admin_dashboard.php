<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session to maintain login state across pages

session_start();
// Function to get all applications from the database

// Function to update the status of an application
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit();
} elseif ($_SESSION["user_role"] != 1) {
    header("Location: admin_dashboard.php"); // Redirect to user dashboard for non-admin users
    exit();
}

// Function to delete an application


// Handle application status update if form is submitted


// Function to get the counts of applications based on their status
include "db_config.php";

function getApplicationCounts() {
    $conn = connectToDatabase();

    // Prepare and execute a query to fetch the counts of applications based on status from both tables
    $stmt = $conn->prepare("
        SELECT status, COUNT(*) as count FROM (
            SELECT status FROM projectApplications
            UNION ALL
            SELECT status FROM ethics_forms
        ) AS combined_tables
        GROUP BY status
    ");
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Initialize counters
    $counts = array(
        'newRequestCount' => 0,
        'approvedCount' => 0,
        'awaitingRevisionCount' => 0,
        // Add more counters for other status options if needed
    );

    // Fetch counts as an associative array and update the counters
    while ($row = $result->fetch_assoc()) {
        if ($row['status'] == 'New') {
            $counts['newRequestCount'] = $row['count'];
        } elseif ($row['status'] == 'Approved') {
            $counts['approvedCount'] = $row['count'];
        } elseif ($row['status'] == 'Pending') {
            $counts['awaitingRevisionCount'] = $row['count'];
        }
        // Add more conditions for other status options if needed
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();

    return $counts;
}

// Get the counts of applications based on status
$counts = getApplicationCounts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display" rel="stylesheet">
    <script src="adminscript.js"></script>
    <title>ADMIN DASHBOARD</title>
</head>
<body>
<header class="dashboard-header" >
    <img src="logo.png" alt="Your Logo" style="width: 300px; height: 100px; margin-right: 6600px; ">

    <nav>
        <h1>ADMIN DASHBOARD</h1>
        <ul>
            <li><a href="admin_dashboard.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="applications.php"><i class="fas fa-tasks"></i> Applications</a></li>
            <li><a href="index.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </nav>
</header>

    <main>
        <section id="home">
            <h2>Home</h2>
            <div class="status-container">
                <div class="status">
                    <div class="count" id="newRequestCount"><?php echo $counts['newRequestCount']; ?></div>
                    <div class="status-text">New Request</div>
                </div>
                <div class="status">
                    <div class="count" id="approvedCount"><?php echo $counts['approvedCount']; ?></div>
                    <div class="status-text">Approved</div>
                </div>
                <div class="status">
                    <div class="count" id="awaitingRevisionCount"><?php echo $counts['awaitingRevisionCount']; ?></div>
                    <div class="status-text">Awaiting Revision</div>
                </div>
            </div>
        </section>
    </main>

    
</body>
</html>
