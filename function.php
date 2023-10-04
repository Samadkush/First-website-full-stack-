<?php
// edit_form.php
ini_set('display_errors', 1);

// Start the session to maintain login state across pages
session_start();
include 'db_config.php';
// Check if the user is not logged in, then redirect to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit();
}
//include 'db_config.php';

// Function to connect to the MySQL server

// Check if the form ID is provided as a query parameter
if (isset($_GET['form_id'])) {
    $formId = $_GET['form_id'];
    

    // Fetch the form data based on the form ID (You need to implement this function)
    $formData2 = getFormData2($formId);

    // Process the form submission if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the updated form data from the submitted form
        $updatedtitle = $_POST['title'];
        $updatedtypeofstudy = $_POST['type_of_study'];
        $updatedotherspecify = $_POST['other_specify'] ?? null;
        $updatedresearchername=$_POST['researcher_name'];
        $updateddepartment = $_POST['department'];
        $updatedinstitute = $_POST['institute'];
        $updatedphone = $_POST['phone'];
        $updatedaddress = $_POST['address'];
        $updatedemail = $_POST['email'];
        $updatednumresearchers = $_POST['num_researchers'];
        $updatedadvisortitle = $_POST['advisor_title'];
        $updatedadvisorname = $_POST['advisor_name'];
        $updatedadvisoraddress = $_POST['advisor_address'];
        $updatedadvisordepartment = $_POST['advisor_department'];
        $updatedadvisorphone = $_POST['advisor_phone'];
        $updatedstartdate = $_POST['start_date'];
        $updatedenddate = $_POST['end_date'];
        $updatedorganizationA = $_POST['organizationA'];
        $updatedorganizationB = $_POST['organizationB'];
        $updatedorganizationC = $_POST['organizationC'];
        $updatedexternalorganizations = $_POST['external_organizations'] ?? null;
        $updatedexternalorganizationsdetails = $_POST['external_organizations_details'] ?? null;
        $updatedsupported = $_POST['supported'];
        $updatedsupportinginstitution = $_POST['supporting_institution'] ?? null;
        $updateduniversityinstitution = $_POST['universityInstitution'];
        $updatedtubitakinstitution = $_POST['tubitakInstitution'];
        $updatedinternationalinstitution = $_POST['internationalInstitution'];
        $updatedotherinstitution = $_POST['otherInstitution'];
        $updatedapprovalused = $_POST['approvalUsed'];
        $updatedapplicationstatus = $_POST['applicationStatus'];
        $updatedpreviousprotocolnumber= $_POST['previous_protocol_number'];
        $updatednewcompletiondate = $_POST['new_completion_date'];
        $updatedstudychanges = $_POST['study_changes'];
        $updatedprotocolchanges = $_POST['protocol_changes'];
        $updatedunexpected = $_POST['unexpected'] ?? null;
        $updatedunexpecteddetails = $_POST['unexpected_details'];
        $updatedProtocolNo = $_POST['ProtocolNo'];
        $updatedChanges = $_POST['Changes'];
        $updatedunexpected1 = $_POST['unexpected1'] ?? null;
        $updatedReason = $_POST['Reason'];
        $updatedpurposeStudy = $_POST['purposeStudy'];
        $updateddataCollectionProcess = $_POST['dataCollectionProcess'];
        $updateddeception = $_POST['deception'] ?? null;
        $updatednegativeeffects = $_POST['negative_effects']?? null;
        $updatedeffectsdetails = $_POST['effects_details'];
        $updatedexpectedParticipants = $_POST['expectedParticipants'];
        $updatedcontrolGroup = $_POST['controlGroup']?? null;
        $updatedparticipantType = $_POST['participantType']?? null;
        $updatedparticipantTypeOtherText = $_POST['participantTypeOtherText'];
        $updatedsampleCharacteristics = $_POST['sampleCharacteristics'];
        $updatedinvitationMethod = $_POST['invitationMethod'];
        $updatedmethodsToBeUsed = $_POST['methodsToBeUsed']?? null;
        $updatedmethodOtherText = $_POST['methodOtherText'];
        $updatedcontributions = $_POST['contributions'];
        $updatedsupervisorName = $_POST['supervisorName'];
        $updatedsupervisorSignature = $_POST['supervisorSignature'];
        $updateddateSupervisor = $_POST['dateSupervisor'];
        $updatedresearcherName2 = $_POST['researcherName2'];
        $updatedresearcherSignature = $_POST['researcherSignature'];
        $updateddateResearcher = $_POST['dateResearcher'];




        // Update the form data in the database
        updateFormData2($form_id, $updatedtitle, $updatedtypeofstudy, $updatedotherspecify, $updatedresearchername, $updateddepartment, $updatedinstitute,
        $updatedphone, $updatedaddress, $updatedemail, $updatednumresearchers, $updatedadvisortitle, $updatedadvisorname, $updatedadvisoraddress,
        $updatedadvisordepartment, $updatedadvisorphone, $updatedstartdate, $updatedenddate, $updatedorganizationA, $updatedorganizationB, $updatedorganizationC, $updatedexternalorganizations,
        $updatedexternalorganizationsdetails, $updatedsupported, $updatedsupportinginstitution, $updateduniversityinstitution,
        $updatedtubitakinstitution, $updatedinternationalinstitution, $updatedotherinstitution, $updatedapprovalused, $updatedapplicationstatus,
        $updatedpreviousprotocolnumber, $updatednewcompletiondate, $updatedstudychanges, $updatedprotocolchanges, $updatedunexpected,
        $updatedunexpecteddetails, $updatedProtocolNo, $updatedChanges, $updatedunexpected1, $updatedReason, $updatedpurposeStudy, $updateddataCollectionProcess,
        $updateddeception, $updatednegativeeffects, $updatedeffectsdetails, $updatedexpectedParticipants, $updatedcontrolGroup, $updatedparticipantType,
        $updatedparticipantTypeOtherText, $updatedsampleCharacteristics, $updatedinvitationMethod, $updatedmethodsToBeUsed, $updatedmethodOtherText,
        $updatedcontributions, $updatedsupervisorName, $updatedsupervisorSignature, $updateddateSupervisor, $updatedresearcherName2, $updatedresearcherSignature,
        $updateddateResearcher);

        // Redirect the user back to the user_dashboard.php page after successful update
        header('Location: dashboard.php');
        exit();
    }
} else {
    // Redirect the user back to user_dashboard.php if form_id is not provided
    header('Location: dashboard.php');
    exit();
}

// Function to get the form data by form ID (You need to implement this function)
function getFormData2($formId) {
    $conn = connectToDatabase();

    // Prepare and execute a query to fetch form data by form ID
    // Replace 'your_table_name' with the actual name of your table
    $stmt = $conn->prepare("SELECT * FROM ethics_forms WHERE form_id = ?");
    $stmt->bind_param("i", $formId);
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Fetch form data as an associative array
    $formData2 = $result->fetch_assoc();

    return $formData2;
}

// Function to update the form data by form ID 
function updateFormData2($formId,$updatedtitle, $updatedtypeofstudy, $updatedotherspecify, $updatedresearchername, $updateddepartment, $updatedinstitute,
$updatedphone, $updatedaddress, $updatedemail, $updatednumresearchers, $updatedadvisortitle, $updatedadvisorname, $updatedadvisoraddress,
$updatedadvisordepartment, $updatedadvisorphone, $updatedstartdate, $updatedenddate, $updatedorganizationA, $updatedorganizationB, $updatedorganizationC, $updatedexternalorganizations,
$updatedexternalorganizationsdetails, $updatedsupported, $updatedsupportinginstitution, $updateduniversityinstitution,
$updatedtubitakinstitution, $updatedinternationalinstitution, $updatedotherinstitution, $updatedapprovalused, $updatedapplicationstatus,
$updatedpreviousprotocolnumber, $updatednewcompletiondate, $updatedstudychanges, $updatedprotocolchanges, $updatedunexpected,
$updatedunexpecteddetails, $updatedProtocolNo, $updatedChanges, $updatedunexpected1, $updatedReason, $updatedpurposeStudy, $updateddataCollectionProcess,
$updateddeception, $updatednegativeeffects, $updatedeffectsdetails, $updatedexpectedParticipants, $updatedcontrolGroup, $updatedparticipantType,
$updatedparticipantTypeOtherText, $updatedsampleCharacteristics, $updatedinvitationMethod, $updatedmethodsToBeUsed, $updatedmethodOtherText,
$updatedcontributions, $updatedsupervisorName, $updatedsupervisorSignature, $updateddateSupervisor, $updatedresearcherName2, $updatedresearcherSignature,
$updateddateResearcher) {
    $conn = connectToDatabase();

    // Prepare and execute a query to update the form data
    $stmt = $conn->prepare("UPDATE ethics_forms SET  title = ?, type_of_study = ?, other_specify = ?, researcher_name = ?, department = ?, institute = ?, phone = ?, address = ?, email = ?, num_researchers = ?, advisor_title = ?, advisor_name = ?, advisor_address = ?, advisor_department = ?, advisor_phone = ?, start_date = ?, end_date = ?, organizationA = ?, organizationB = ?, organizationC = ?, external_organization = ?, external_organization_details = ?, supported = ?, supporting_institution = ?, universityInstitution = ?, tubitakInstitution = ?, internationalInstitution = ?, otherInstitution = ?, approvalUsed = ?, applicationStatus = ?, previous_protocol_number = ?, new_completion_date = ?, study_changes = ?, protocol_changes = ?, unexpected = ?, unexpected_details = ?, protocolNo = ?, Changes = ?, unexpected1 = ?, Reason = ?, purposeStudy = ?, dataCollectionProcess = ?, deception = ?, negative_effects = ?, effects_details = ?, expectedParticipants = ?, controlGroup = ?, participantType = ?, participantTypeOtherText = ?, sampleCharacteristics = ?, invitationMethod = ?, methodsToBeUsed = ?, methodOtherText = ?, contributions = ?, supervisorName = ?, supervisorSignature = ?, dateSupervisor = ?, researcherName2 = ?, researcherSignature = ?, dateResearcher = ? WHERE form_id = ?");
    $stmt->bind_param("ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss", $updatedtitle, $updatedtypeofstudy, $updatedotherspecify, $updatedresearchername, $updateddepartment, $updatedinstitute,
    $updatedphone, $updatedaddress, $updatedemail, $updatednumresearchers, $updatedadvisortitle, $updatedadvisorname, $updatedadvisoraddress,
    $updatedadvisordepartment, $updatedadvisorphone, $updatedstartdate, $updatedenddate, $updatedorganizationA, $updatedorganizationB, $updatedorganizationC, $updatedexternalorganizations,
    $updatedexternalorganizationsdetails, $updatedsupported, $updatedsupportinginstitution, $updateduniversityinstitution,
    $updatedtubitakinstitution, $updatedinternationalinstitution, $updatedotherinstitution, $updatedapprovalused, $updatedapplicationstatus,
    $updatedpreviousprotocolnumber, $updatednewcompletiondate, $updatedstudychanges, $updatedprotocolchanges, $updatedunexpected,
    $updatedunexpecteddetails, $updatedProtocolNo, $updatedChanges, $updatedunexpected1, $updatedReason, $updatedpurposeStudy, $updateddataCollectionProcess,
    $updateddeception, $updatednegativeeffects, $updatedeffectsdetails, $updatedexpectedParticipants, $updatedcontrolGroup, $updatedparticipantType,
    $updatedparticipantTypeOtherText, $updatedsampleCharacteristics, $updatedinvitationMethod, $updatedmethodsToBeUsed, $updatedmethodOtherText,
    $updatedcontributions, $updatedsupervisorName, $updatedsupervisorSignature, $updateddateSupervisor, $updatedresearcherName2, $updatedresearcherSignature,
    $updateddateResearcher);
    
    $stmt->execute();
    if ($stmt->errno) {
        echo "Error: " . $stmt->error;
    } else {
        $_SESSION['form_updated'] = true;
        header('Location: dashboard.php');
        exit();
    }
}

?>