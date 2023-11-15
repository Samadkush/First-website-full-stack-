<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

//$session_name =  "loggedin";
// Start the session to maintain login state across pages
//session_name($session_name);
session_start();
//$_SESSION["loggedin"] = true;

// Check if the user is not logged in, then redirect to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("Location: index.php");
  exit();
} elseif ($_SESSION["user_role"] == 1) {
  header("Location: admin_dashboard.php"); // Redirect to admin dashboard for admin users
  exit();
}

// Include view_applications.php and its contents

// Function to connect to the MySQL server
include 'db_config.php';

$conn = connectToDatabase();
function getAllFormDetails($conn, $userId) {
  $stmt = $conn->prepare("
      SELECT
          pa.form_id,
          'Project Application' AS type,
          pa.status,
          pa.comment,
          pa.submissionDate
      FROM
          projectApplications pa
      WHERE
          pa.user_id = ?
      UNION
      SELECT
          ef.form_id,
          'Ethics Forms' AS type,
          ef.status,
          ef.comment,
          ef.submissionDate
      FROM
          ethics_forms ef
      WHERE
          ef.user_id = ?
  ");

  $stmt->bind_param("ii", $userId, $userId);
  $stmt->execute();

  $result = $stmt->get_result();
  $formDetails = $result->fetch_all(MYSQLI_ASSOC);

  return $formDetails;
}
$userId = $_SESSION["user_id"];
// Get all forms' details for the logged-in user
$allFormDetails = getAllFormDetails($conn, $userId);


// Get form details
$formId = isset($_GET['form_id']) ? $_GET['form_id'] : null;
$formDetails = null;

if ($formId !== null) {
    $formDetails = getAllFormDetails($conn, $formId);


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
if (isset($_GET["delete"]) && $_GET["delete"] === "true" && isset($_GET["form_id"])) {
  $form_id = $_GET["form_id"];

  // Call the deleteApplication function to delete the application
  deleteApplication($conn, $form_id);
  deleteApplication2($conn, $form_id);

  // Redirect back to the applications page after deletion
  header("Location: dashboard.php");
  exit();
}

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
<header class="normal-header">
    <img src="logo (1).png" alt="Your Logo" style="width: 300px; height: 100px; margin-right: 6600px; ">
    <h1 class="dashboard-title">USER DASHBOARD</h1> <!-- Move "User Dashboard" here -->
    <div id="navbar">
        <nav>
        <ul class="nav-list">
                <li><a href="#home-section">Home</a></li> 
                <li><a href="#Application-status">Applications Status</a></li>
                <li><a href="form1.php">Ethics Committee Application Form</a></li>
                <li><a href="form2.php">Project Information Form</a></li>
                <li><a href="#" onclick="logout()">Logout</a></li>
            </ul>
        </nav>
    </div>
</header>

    <section id="home-section" class="section">
      <div class="home-container">
        <div class="form-container">
          <button class="accordion-btn" data-description="form1-description">Ethics Application Form</button>
          <div class="description" id="form1-description">
            <p>Studies conducted in Final International University (FIU) and/or studies conducted by FIU personnel/students, which involve collecting data from human participants, are subject to review by the FIU Ethics Committee (EC). Applicants should submit this application form to the FIU EC along with the other required documents (see the Application Check List). Approval of the EC is required before the start of data collection from human participants.</p>
          </div>
        </div>
      
        <div class="form-container">
          <button class="accordion-btn" data-description="form2-description">Project Information Form</button>
          <div class="description" id="form2-description">
            <p>Studies conducted in Final International University (FIU) and/or studies conducted by FIU personnel/students, which involve collecting data from human participants, are subject to review by the FIU Ethics Committee (EC). Applicants should submit this application form to the FIU EC along with the other required documents (see the Application Check List). Approval of the EC is required before the start of data collection from human participants.</p>
          </div>
        </div>
      </div>
    </section>
      

    

    <section id="Application-status" class="section">
    <div class="applications-list">
    <h2>Applications</h2>
    <table>
        <thead>
            <tr>
                <th>AppNo</th>
                <th>AppType</th>
                <th>Date</th>
                <th>Status</th>
                <th>Comments</th> <!-- Updated column header -->
            </tr>
        </thead>
        <tbody>
        <?php foreach ($allFormDetails as $formDetails) { ?>
          <form method="post" action="applications.php">
                <tr>
                <td><a href="readonly_function.php?form_id=<?php echo $formDetails['form_id']; ?>&type=<?php echo $formDetails['type']; ?>"><?php echo $formDetails['form_id']; ?></a></td>
                    <td><?php echo $formDetails['type']; ?></td>
                    <td><?php echo isset($formDetails['submissionDate']) ? date("Y-m-d", strtotime($formDetails['submissionDate'])) : date("Y-m-d "); ?></td>
                    <td><?php echo ucfirst($formDetails['status']); ?></td>
                    <td>
                        <?php echo $formDetails['comment']; ?> <!-- Display admin's comment -->
                    </td>
                    <td>
                        <?php if ($formDetails['status'] === 'New' || $formDetails['status'] === 'Modified' || $formDetails['status'] === 'Revision') { ?>
                            <!-- Edit button with form_id as a parameter -->
                            <a class="button" href="form.php?form_id=<?php echo $formDetails['form_id']; ?>&type=<?php echo $formDetails['type']; ?>">Edit Form</a>
                            <!-- Delete button with form_id as a parameter -->
                            <a class="button" href="dashboard.php?delete=true&form_id=<?php echo $formDetails['form_id']; ?>">Delete</a>
                        <?php } else { ?>
                            <!-- Show empty space if status is not "new" or "modified" -->
                            &nbsp;
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>

<style>
    /* Style for the anchor tags to look like buttons */
    .button {
        display: inline-block;
        background-color: #4CAF50;
        color: white;
        padding: 8px 16px;
        text-align: center;
        text-decoration: none;
        font-size: 14px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-right: 5px;
    }

    .button:hover {
        background-color: #45a049;
    }
</style>

<script src="dashboard.js"></script>
    </body>
    </html> 