<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'db_config.php';

if (isset($_GET['form_id']) && isset($_GET['type'])) {
    $formId = $_GET['form_id'];
    $formType = $_GET['type'];

    if ($formType === 'Project Application') {
        // Include the logic for displaying Project Application details here
        include 'readonly.php';
    } elseif ($formType === 'Ethics Forms') {
        // Include the logic for displaying Ethics Forms details here
        include 'readonly2.php';
    } else {
        echo "Unknown form type.";
        echo "Form Type: $formType"; 
        exit();
    }
} else {
    echo "No form id or form type provided.";
    exit();
}
?>
