<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
// Include admin_dashboard.php to access connectToDatabase() function
include "db_config.php";
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit();
} elseif ($_SESSION["user_role"] != 1) {
    header("Location: admin_dashboard.php"); // Redirect to user dashboard for non-admin users
    exit();
}
$conn = connectToDatabase();

// Function to get all applications from the database
function getApplications($conn) {
    $query = "
        SELECT
            pa.form_id,
            'Project Application' AS type,
            pa.status,
            pa.comment,
            pa.submissionDate
        FROM
            projectApplications pa
        LEFT JOIN
            ethics_forms ef ON pa.form_id = ef.form_id
        UNION
        SELECT
            ef.form_id,
            'Ethics Forms' AS type,
            ef.status,
            ef.comment,
            ef.submissionDate
        FROM
            ethics_forms ef
        LEFT JOIN
            projectApplications pa ON ef.form_id = pa.form_id;
    ";

    $result = $conn->query($query);
    $applications = [];
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $applications[] = $row;
        }
    }
    
    return $applications;
}

// Function to delete an application
function deleteApplication($conn, $form_id) {
    $stmt = $conn->prepare("DELETE FROM projectApplications WHERE form_id = ?");
    $stmt->bind_param("s", $form_id);
    $stmt->execute();
    $stmt->close();
}
function deleteApplication2($conn, $form_id) {
    $stmt = $conn->prepare("DELETE FROM ethics_forms WHERE form_id = ?");
    $stmt->bind_param("s", $form_id);
    $stmt->execute();
    $stmt->close();
}
// Function to update the comments of an application
function updateApplicationComments($conn, $form_id, $comment) {
    $stmt = $conn->prepare("UPDATE projectApplications SET comment = ? WHERE form_id = ?");
    $stmt->bind_param("ss", $comment, $form_id);
    $stmt->execute();
    $stmt->close();
}
function updateApplicationComments2($conn, $form_id, $comment) {
    $stmt = $conn->prepare("UPDATE ethics_forms SET comment = ? WHERE form_id = ?");
    $stmt->bind_param("ss", $comment, $form_id);
    $stmt->execute();
    $stmt->close();
}
// Function to update the status of an application
function updateApplicationStatus($conn, $form_id, $status) {
    $stmt = $conn->prepare("UPDATE projectApplications SET status = ? WHERE form_id = ?");
    $stmt->bind_param("ss", $status, $form_id);
    
    if (!$stmt->execute()) {
        echo "Error updating status: " . $stmt->error;
    }
    
    $stmt->close();
}

// Function to update the status of an application in the secondTable
function updateApplicationStatusInSecondTable($conn, $form_id, $status) {
    $stmt = $conn->prepare("UPDATE ethics_forms SET status = ? WHERE form_id = ?");
    $stmt->bind_param("ss", $status, $form_id);
    if (!$stmt->execute()) {
        echo "Error updating status: " . $stmt->error;
    }
    $stmt->close();
}

// Handle form submissions for updating status
// Handle form submissions for updating status
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["form_id"]) && isset($_POST["status"])) {
    $form_id = $_POST["form_id"];
    $status = $_POST["status"];

    // Call the updateApplicationStatus function to update the status
    updateApplicationStatus($conn, $form_id, $status);
    updateApplicationStatusInSecondTable($conn, $form_id, $status);

    // Output a success message as response
    echo "Status updated successfully";

    // Exit without redirecting
    exit();
} else {
    error_log("Invalid POST request or missing data.");
}

// Handle form submissions for updating comments
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["form_id"]) && isset($_POST["comment"])) {
    $form_id = $_POST["form_id"];
    $comment = $_POST["comment"];

    // Call the updateApplicationComments function to update the comments
    updateApplicationComments($conn, $form_id, $comment);
    updateApplicationComments2($conn, $form_id, $comment);

    // Redirect back to the applications page after comments update
    header("Location: applications.php");
    exit();
}

// Handle application deletion if requested
if (isset($_GET["delete"]) && $_GET["delete"] === "true" && isset($_GET["form_id"])) {
    $form_id = $_GET["form_id"];

    // Call the deleteApplication function to delete the application
    deleteApplication($conn, $form_id);
    deleteApplication2($conn, $form_id);

    // Redirect back to the applications page after deletion
    header("Location: applications.php");
    exit();
}

// Obtain the list of applications
$applications = getApplications($conn);

$perPage = 10; // Number of applications per page
$totalApplications = count($applications);
$totalPages = ceil($totalApplications / $perPage);

// Get the current page number from the URL query parameter
$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Applications</title>
</head>
<body>
    <header>
        <img src="logo.png" alt="Your Logo" style="width: 300px; height: 100px; margin-right: 6600px; ">
        <h1>Applications</h1>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="applications.php"><i class="fas fa-tasks"></i> Applications</a></li>
                <li><a href="index.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
    <div class="filter-container">
    <label for="status-filter">Filter by Status:</label>
    <select id="status-filter" onchange="filterByStatus(this)">
        <option value="all">All</option>
        <option value="New">New</option>
        <option value="Revision">Revision</option>
        <option value="Pending">Pending</option>
        <option value="Approved">Approved</option>
        <option value="Extension">Extension</option>
        <option value="Modification">Modification</option>
    </select>
</div>
        <section id="applications">
            <h2>Applications</h2>
            <table>
                <thead>
                    <tr>
                        <th>AppNo</th>
                        <th>AppType</th>
                        <th>Status</th>
                        <th>Comments</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php
    $startIndex = ($currentPage - 1) * $perPage;
    $endIndex = min($startIndex + $perPage, $totalApplications);
    
    for ($i = $startIndex; $i < $endIndex; $i++) {
        $application = $applications[$i];
        ?>
                        <tr>
                        <td><a href="readonly_function.php?form_id=<?php echo $application['form_id']; ?>&type=<?php echo $application['type']; ?>"><?php echo $application['form_id']; ?></a></td>
                            <td><?php echo isset($application['type']) ? $application['type'] : ''; ?></td>
                            <td>
                                <div class="status-container">
                                    <form method="post" action="applications.php">
                                        <select name="status" class="status">
                                            <option value="New" <?php echo (isset($application['status']) && $application['status'] === 'New') ? 'selected' : ''; ?>>New</option>
                                            <option value="Revision" <?php echo (isset($application['status']) && $application['status'] === 'Revision') ? 'selected' : ''; ?>>Revision</option>
                                            <option value="Pending" <?php echo (isset($application['status']) && $application['status'] === 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                            <option value="Approved" <?php echo (isset($application['status']) && $application['status'] === 'Approved') ? 'selected' : ''; ?>>Approved</option>
                                            <option value="Extension" <?php echo (isset($application['status']) && $application['status'] === 'Extension') ? 'selected' : ''; ?>>Extension</option>
                                            <option value="Modification" <?php echo (isset($application['status']) && $application['status'] === 'Modification') ? 'selected' : ''; ?>>Modification</option>
                                        </select>
                                    </form>
                                </div>
                            </td>
                            <td>
                                <div class="comments-container">
                                    <form method="post" action="applications.php">
                                        <input type="hidden" name="form_id" value="<?php echo isset($application['form_id']) ? $application['form_id'] : ''; ?>">
                                        <textarea name="comment"><?php echo isset($application['comment']) ? htmlspecialchars($application['comment']) : ''; ?></textarea>
                                        <button type="submit">Update</button>
                                    </form>
                                </div>
                            </td>
                            <td><?php echo isset($application['submissionDate']) ? date("Y-m-d", strtotime($application['submissionDate'])) : date("Y-m-d"); ?></td>
                            <td>
                                <a href="applications.php?delete=true&form_id=<?php echo isset($application['form_id']) ? $application['form_id'] : ''; ?>" class="delete-btn">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="pagination-container">
    <div class="pagination">
        <a href="?page=<?php echo $currentPage - 1; ?>" class="pagination-button pagination-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10">
                <polygon points="0,5 10,0 10,10" fill="#333" />
            </svg>
        </a>
        <span class="pagination-page"><?php echo $currentPage; ?> of <?php echo $totalPages; ?></span>
        <a href="?page=<?php echo $currentPage + 1; ?>" class="pagination-button pagination-forward">
            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10">
                <polygon points="0,0 10,5 0,10" fill="#333" />
            </svg>
        </a>
    </div>
</div>






        </section>
    </main>
    <script src="adminscript.js"></script>
</body>
</html>

