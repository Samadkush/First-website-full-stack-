
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
var_dump($_POST);
// Start the session to maintain login state across pages
session_start();

// Check if the user is not logged in, then redirect to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["user_role"] !== 2) {
    header("Location: index.php");
    exit();
}

// Function to connect to the MySQL server
include 'db_config.php';

// Function to generate the form ID
function generate_form_id($conn) {
  $current_year = date('Y');
  $current_month = date('m');
  $last_form_id = getLastFormIdFromDatabase($conn);

  if ($last_form_id && strpos($last_form_id, $current_year . $current_month) !== false) {
      $last_number = intval(substr($last_form_id, 6));
      $new_number = str_pad($last_number + 1, 3, '1', STR_PAD_LEFT);
      $form_id = $current_year . $current_month . $new_number;
  } else {
      $form_id = $current_year . $current_month . '100';
  }

  return $form_id;
}
function getLastFormIdFromDatabase($conn) {
    $sql = "SELECT form_id FROM ethics_forms ORDER BY form_id DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the latest form_id from the result
        $row = $result->fetch_assoc();
        $last_form_id = $row["form_id"];
    } else {
        // If no form_id exists, start with '00' as the initial form ID.
        $current_year = date('Y');
        $current_month = date('m');
        $last_form_id = $current_year . $current_month . '100';
    }

    return $last_form_id;
}

function getFormInputs($inputNames) {
  $inputs = array();
  foreach ($inputNames as $name) {
      if (isset($_POST[$name])) {
          $inputs[$name] = $_POST[$name];
      }
  }
  return $inputs;
}

// Check if the form is submitted
function submitForm(){
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $connection = connectToDatabase();
      $inputNames = array(
        'form_id', 'user_id', 'title', 'type_of_study', 'other_specify', 'researcher_name', 'department',
        'institute', 'phone', 'address', 'email', 'num_researchers', 'researcherData', 'advisor_title', 'advisor_name', 'advisor_address',
        'advisor_department', 'advisor_phone', 'start_date', 'end_date', 'organizationA', 'organizationB', 'organizationC', 
        'external_organization', 'external_organization_details', 'supported', 'supporting_institution',
        'universityInstitution', 'tubitakInstitution', 'internationalInstitution', 'otherInstitution',
        'approvalUsed', 'applicationStatus', 'previous_protocol_number', 'new_completion_date',
        'study_changes', 'protocol_changes', 'unexpected', 'unexpected_details', 'protocolNo', 'Changes',
        'unexpected1', 'Reason', 'purposeStudy', 'dataCollectionProcess', 'deception', 'negative_effects',
        'effects_details', 'expectedParticipants', 'controlGroup', 'participantType',
        'participantTypeOtherText', 'sampleCharacteristics', 'invitationMethod', 'methodsToBeUsed',
        'methodOtherText', 'contributions', 'supervisorName', 'supervisorSignature', 'dateSupervisor',
        'researcherName2', 'researcherSignature', 'dateResearcher'

  );

  // Retrieve form inputs using the getFormInputs function
  $formInputs = getFormInputs($inputNames);
  
  $user_id = $_SESSION["user_id"];
  // Generate the form ID
  $form_id = generate_form_id($connection);

  $sql = "INSERT INTO ethics_forms (form_id, user_id, title, type_of_study, other_specify, researcher_name, department, institute, phone, address, email, num_researchers, researcherData, advisor_title, advisor_name, advisor_address, advisor_department, advisor_phone, start_date, end_date, organizationA, organizationB, organizationC, external_organization, external_organization_details, supported, supporting_institution, universityInstitution, tubitakInstitution, internationalInstitution, otherInstitution, approvalUsed, applicationStatus, previous_protocol_number, new_completion_date, study_changes, protocol_changes, unexpected, unexpected_details, protocolNo, Changes, unexpected1, Reason, purposeStudy, dataCollectionProcess, deception, negative_effects, effects_details, expectedParticipants, controlGroup, participantType, participantTypeOtherText, sampleCharacteristics, invitationMethod, methodsToBeUsed, methodOtherText, contributions, supervisorName, supervisorSignature, dateSupervisor, researcherName2, researcherSignature, dateResearcher)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $connection->prepare($sql);
  if ($stmt === false) {
    die("Prepare failed: " . $connection->error);
}
$form_id = generate_form_id($connection);
$user_id = $_SESSION["user_id"];
$title = $formInputs['title'];
$type_of_study = $formInputs['type_of_study'];
$other_specify = isset($formInputs['otherSpecify']) ? $formInputs['otherSpecify'] : '';
$researcher_name = $formInputs['researcher_name'];
$department = $formInputs['department'];
$institute = $formInputs['institute'];
$phone = $formInputs['phone'];
$address = $formInputs['address'];
$email = $formInputs['email'];
$num_researchers = $formInputs['num_researchers'];
$researcherData = $formInputs['researcherData'] ;
$advisor_title = $formInputs['advisor_title'];
$advisor_name = $formInputs['advisor_name'];
$advisor_address = $formInputs['advisor_address'];
$advisor_department = $formInputs['advisor_department'];
$advisor_phone = $formInputs['advisor_phone'];
$start_date = $formInputs['start_date'];
$end_date = $formInputs['end_date'];
$organizationA = $formInputs['organizationA'];
$organizationB = $formInputs['organizationB'];
$organizationC = $formInputs['organizationC'];
$external_organization = $formInputs['external_organization'];
$external_organization_details = $formInputs['external_organization_details'];
$supported = $formInputs['supported'];
$supporting_institution = isset($formInputs['supporting_institution']) ? $formInputs['supporting_institution'] : '';
$universityInstitution = $formInputs['universityInstitution'];
$tubitakInstitution = $formInputs['tubitakInstitution'];
$internationalInstitution = $formInputs['internationalInstitution'];
$otherInstitution = $formInputs['otherInstitution'];
$approvalUsed = $formInputs['approvalUsed'];
$applicationStatus = $formInputs['applicationStatus'];
$previous_protocol_number = $formInputs['previous_protocol_number'];
$new_completion_date =isset($formInputs['new_completion_date']) ? $formInputs['new_completion_date'] : '';
$study_changes = isset($formInputs['study_changes']) ? $formInputs['study_changes'] : '';
$protocol_changes = $formInputs['protocol_changes'];
$unexpected = isset($formInputs['unexpected']) ? $formInputs['unexpected'] : '';
$unexpected_details = $formInputs['unexpected_details'];
$protocolNo = isset($formInputs['protocolNo']) ? $formInputs['protocolNo'] : '';
$Changes = isset($formInputs['Changes']) ? $formInputs['Changes'] : '';
$unexpected1 = isset($formInputs['unexpected1']) ? $formInputs['unexpected1'] : '';
$Reason = $formInputs['Reason'];
$purposeStudy = $formInputs['purposeStudy'];
$dataCollectionProcess = $formInputs['dataCollectionProcess'];
$deception =isset($formInputs['deception']) ? $formInputs['deception'] : '';
$negative_effects =isset($formInputs['negative_effects']) ? $formInputs['negative_effects'] : '';
$effects_details = $formInputs['effects_details'];
$expectedParticipants = $formInputs['expectedParticipants'];
$controlGroup =isset($formInputs['controlGroup']) ? $formInputs['controlGroup'] : '';
$participantType = isset($formInputs['participantType']) ? implode(',', $formInputs['participantType']) : '';
$participantTypeOtherText = $formInputs['participantTypeOtherText'];
$sampleCharacteristics = $formInputs['sampleCharacteristics'];
$invitationMethod = $formInputs['invitationMethod'];
$methodsToBeUsed = isset($formInputs['methodsToBeUsed']) ? implode(',', $formInputs['methodsToBeUsed']) : '';
$methodOtherText = $formInputs['methodOtherText'];
$contributions = $formInputs['contributions'];
$supervisorName = $formInputs['supervisorName'];
$supervisorSignature = $formInputs['supervisorSignature'];
$dateSupervisor = $formInputs['dateSupervisor'];
$researcherName2 = $formInputs['researcherName2'];
$researcherSignature = $formInputs['researcherSignature'];
$dateResearcher = $formInputs['dateResearcher'];


$result = $stmt->bind_param(
    "sisssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss",
    $form_id, $user_id, $title, $type_of_study, $other_specify, $researcher_name, $department,
    $institute, $phone, $address, $email, $num_researchers, $researcherData, $advisor_title, $advisor_name, $advisor_address,
    $advisor_department, $advisor_phone, $start_date, $end_date, $organizationA,$organizationB,$organizationC,
    $external_organization, $external_organization_details, $supported, $supporting_institution, $universityInstitution,
    $tubitakInstitution, $internationalInstitution, $otherInstitution, $approvalUsed,
    $applicationStatus, $previous_protocol_number, $new_completion_date, $study_changes,
    $protocol_changes, $unexpected, $unexpected_details, $protocolNo, $changes, $unexpected1,
    $Reason, $purposeStudy, $dataCollectionProcess, $deception, $negative_effects, $effects_details, $expectedParticipants, $controlGroup,
    $participantType, $participantTypeOtherText, $sampleCharacteristics, $invitationMethod,
    $methodsToBeUsed, $methodOtherText, $contributions, $supervisorName, $supervisorSignature,
    $dateSupervisor, $researcherName2, $researcherSignature, $dateResearcher
);

if ($result === false) {
    die("Binding parameters failed: " . $stmt->error);
}

$result = $stmt->execute();
$stmt->close(); // Close the statement before redirecting

if ($result === false) {
    die("Execute failed: " . $stmt->error);
}else{
echo "Form data inserted successfully!";
ob_start();
if (header('Location: dashboard.php#Application-status')) {
    exit(); // Make sure to exit after sending the header
} else {
    echo "Header redirection failed."; // For debugging purposes
}
}
}
}
?>

