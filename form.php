<?php

session_start();
//include 'db_config.php';
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("Location: index.php");
  exit();
}
if (isset($_GET['form_id'])) 
{
 $formId = $_GET['form_id'];
  $formType=$_GET['type'];


if ($formType === 'Project Application') {
    // Include the edit_form1.php logic here
    include 'edit_form.php';
} elseif ($formType === 'Ethics Forms') {
    // Include the edit_form2.php logic here
    include 'edit_form2.php';
} else {
    echo "Unknown form type.";
    echo "Form Type: $formType"; 
    exit();
  
}
}else{
  echo "No form id provided.";
  exit();
}

?>