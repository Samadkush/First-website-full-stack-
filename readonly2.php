<?php
// edit_form.php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

// Start the session to maintain login state across pages
//session_start();
// Check if the user is not logged in, then redirect to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit();
}

// Function to connect to the MySQL server
//include 'db_config.php';

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
        $updatedresearcherData = [];

        for ($i = 1; $i <= $updatednumresearchers; $i++) {
            $researcherName = $_POST['researcherName' . $i];
            $researcherInstitution = $_POST['researcherInstitution' . $i];
            $updatedresearcherData[] = $researcherName . ' (' . $researcherInstitution . ')';
        }
    
        $updatedresearcherData = implode('; ', $updatedresearcherData);     
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
        $updatedapprovalused = isset($_POST['approvalUsed']) ? $_POST['approvalUsed'] : null;
        $updatedapplicationstatus = $_POST['applicationStatus'];
        $updatedpreviousprotocolnumber= $_POST['previous_protocol_number'];
        $updatednewcompletiondate = $_POST['new_completion_date'];
        $updatedstudychanges = isset($_POST['study_changes']) ? $_POST['study_changes'] : null;        $updatedprotocolchanges = $_POST['protocol_changes'];
        $updatedunexpected = $_POST['unexpected'] ?? null;
        $updatedunexpecteddetails = $_POST['unexpected_details'];
        $updatedProtocolNo = $_POST['ProtocolNo'];
        $updatedChanges = $_POST['Changes'];
        $updatedunexpected1 = $_POST['unexpected1'] ?? null;
        $updatedReason = $_POST['Reason'];
        $updatedpurposeStudy = $_POST['purposeStudy'];
        $updateddataCollectionProcess = isset($_POST['dataCollectionProcess']) ? $_POST['dataCollectionProcess'] : null; 
        $updateddeception = $_POST['deception'] ?? null;
        $updatednegativeeffects = $_POST['negative_effects']?? null;
        $updatedeffectsdetails = $_POST['effects_details'];
        $updatedexpectedParticipants = $_POST['expectedParticipants'];
        $updatedcontrolGroup = $_POST['controlGroup']?? null;
        $updatedparticipantType = isset($_POST['participantType']) ? implode(',', $_POST['participantType']) : null;
        $updatedparticipantTypeOtherText = $_POST['participantTypeOtherText'];
        $updatedsampleCharacteristics = $_POST['sampleCharacteristics'];
        $updatedinvitationMethod = $_POST['invitationMethod'];
        $updatedmethodsToBeUsed = isset($_POST['methodsToBeUsed']) ? implode(',', $_POST['methodsToBeUsed']) : null;
        $updatedmethodOtherText = $_POST['methodOtherText'];
        $updatedcontributions = $_POST['contributions'];
        $updatedsupervisorName = $_POST['supervisorName'];
        $updatedsupervisorSignature = $_POST['supervisorSignature'];
        $updateddateSupervisor = $_POST['dateSupervisor'];
        $updatedresearcherName2 = $_POST['researcherName2'];
        $updatedresearcherSignature = $_POST['researcherSignature'];
        $updateddateResearcher = $_POST['dateResearcher'];




        // Update the form data in the database
        updateFormData2($formId, $updatedtitle, $updatedtypeofstudy, $updatedotherspecify, $updatedresearchername, $updateddepartment, $updatedinstitute,
        $updatedphone, $updatedaddress, $updatedemail, $updatednumresearchers, $updatedresearcherData, $updatedadvisortitle, $updatedadvisorname, $updatedadvisoraddress,
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
        echo "Form data updated successfully!";

        header('Location: dashboard.php');
        exit();
    }
} else {
    // Redirect the user back to user_dashboard.php if form_id is not provided
    echo "Error Updating form data";
    //header('Location: dashboard.php');
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

// Function to update the form data by form ID (You need to implement this function)
function updateFormData2($formId,$updatedtitle, $updatedtypeofstudy, $updatedotherspecify, $updatedresearchername, $updateddepartment, $updatedinstitute,
$updatedphone, $updatedaddress, $updatedemail, $updatednumresearchers,$updatedresearcherData,  $updatedadvisortitle, $updatedadvisorname, $updatedadvisoraddress,
$updatedadvisordepartment, $updatedadvisorphone, $updatedstartdate, $updatedenddate, $updatedorganizationA, $updatedorganizationB, $updatedorganizationC, $updatedexternalorganizations,
$updatedexternalorganizationsdetails, $updatedsupported, $updatedsupportinginstitution, $updateduniversityinstitution,
$updatedtubitakinstitution, $updatedinternationalinstitution, $updatedotherinstitution, $updatedapprovalused, $updatedapplicationstatus,
$updatedpreviousprotocolnumber, $updatednewcompletiondate, $updatedstudychanges, $updatedprotocolchanges, $updatedunexpected,
$updatedunexpecteddetails, $updatedProtocolNo, $updatedChanges, $updatedunexpected1, $updatedReason, $updatedpurposeStudy, $updateddataCollectionProcess,
$updateddeception, $updatednegativeeffects, $updatedeffectsdetails, $updatedexpectedParticipants, $updatedcontrolGroup, $updatedparticipantType,
$updatedparticipantTypeOtherText, $updatedsampleCharacteristics, $updatedinvitationMethod, $updatedmethodsToBeUsed, $updatedmethodOtherText,
$updatedcontributions, $updatedsupervisorName, $updatedsupervisorSignature, $updateddateSupervisor, $updatedresearcherName2, $updatedresearcherSignature,
$updateddateResearcher) {
    

    // Prepare and execute a query to update the form data
    $conn = connectToDatabase();
    // Replace 'your_table_name' with the actual name of your table
    
    $stmt = $conn->prepare("UPDATE ethics_forms SET  title = ?, type_of_study = ?, other_specify = ?, researcher_name = ?, department = ?, institute = ?, phone = ?, address = ?, email = ?, num_researchers = ?, researcherData = ?, advisor_title = ?, advisor_name = ?, advisor_address = ?, advisor_department = ?, advisor_phone = ?, start_date = ?, end_date = ?, organizationA = ?, organizationB = ?, organizationC = ?,  external_organization = ?, external_organization_details = ?, supported = ?, supporting_institution = ?, universityInstitution = ?, tubitakInstitution = ?, internationalInstitution = ?, otherInstitution = ?, approvalUsed = ?, applicationStatus = ?, previous_protocol_number = ?, new_completion_date = ?, study_changes = ?, protocol_changes = ?, unexpected = ?, unexpected_details = ?, protocolNo = ?, Changes = ?, unexpected1 = ?, Reason = ?, purposeStudy = ?, dataCollectionProcess = ?, deception = ?, negative_effects = ?, effects_details = ?, expectedParticipants = ?, controlGroup = ?, participantType = ?, participantTypeOtherText = ?, sampleCharacteristics = ?, invitationMethod = ?, methodsToBeUsed = ?, methodOtherText = ?, contributions = ?, supervisorName = ?, supervisorSignature = ?, dateSupervisor = ?, researcherName2 = ?, researcherSignature = ?, dateResearcher = ? WHERE ethics_forms.form_id = ?");
    if (!$stmt) {
      echo "Prepare failed: " . $conn->error;
  }
  
    $stmt->bind_param("sssssssssissssssssssssssssssssssssssssssssssssssssssssssssssss", $updatedtitle, $updatedtypeofstudy, $updatedotherspecify, $updatedresearchername, $updateddepartment, $updatedinstitute,
    $updatedphone, $updatedaddress, $updatedemail, $updatednumresearchers,$updatedresearcherData,  $updatedadvisortitle, $updatedadvisorname, $updatedadvisoraddress,
    $updatedadvisordepartment, $updatedadvisorphone, $updatedstartdate, $updatedenddate, $updatedorganizationA, $updatedorganizationB, $updatedorganizationC, $updatedexternalorganizations,
    $updatedexternalorganizationsdetails, $updatedsupported, $updatedsupportinginstitution, $updateduniversityinstitution,
    $updatedtubitakinstitution, $updatedinternationalinstitution, $updatedotherinstitution, $updatedapprovalused, $updatedapplicationstatus,
    $updatedpreviousprotocolnumber, $updatednewcompletiondate, $updatedstudychanges, $updatedprotocolchanges, $updatedunexpected,
    $updatedunexpecteddetails, $updatedProtocolNo, $updatedChanges, $updatedunexpected1, $updatedReason, $updatedpurposeStudy, $updateddataCollectionProcess,
    $updateddeception, $updatednegativeeffects, $updatedeffectsdetails, $updatedexpectedParticipants, $updatedcontrolGroup, $updatedparticipantType,
    $updatedparticipantTypeOtherText, $updatedsampleCharacteristics, $updatedinvitationMethod, $updatedmethodsToBeUsed, $updatedmethodOtherText,
    $updatedcontributions, $updatedsupervisorName, $updatedsupervisorSignature, $updateddateSupervisor, $updatedresearcherName2, $updatedresearcherSignature,
    $updateddateResearcher, $formId);
    
    if (!$stmt->execute()) {
      echo "Error executing statement: " . $stmt->error;
      return;
  } else {
      echo "Form data updated successfully!";
      header('Location: dashboard.php');
  }
}
?>
 <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FINAL INTERNATIONAL UNIVERSITY ETHICS COMMITTEE APPLICATION FORM</title>
  <link rel="stylesheet" href="style.css">
  <script src="script2.js"></script> 
</head>

<body>
<button id="backButton" class="back-button">Back to Applications</button>
<img src= "logo.jpg" alt="Final International University" class="logo">

  <div class="container">
    <h1>Ethics Committee Application Form</h1>
    <form id="ethicsForm" action="edit_form2.php?form_id=<?php echo $formId; ?>" method="post">
   
    <p>Studies conducted in Final International University (FIU) and/or studies conducted by FIU personnel/students,
      which involve collecting data from human participants, are subject to review by the FIU Ethics Committee (EC).
      Applicants should submit this application form to the FIU EC along with the other required documents (see the
      Application Check List). Approval of the EC is required before the start of data collection from human
      participants.</p>

    <form id="ethicsForm">
      <div class="form-group">
        <label for="title">1. Title of study:</label>
        <input type="text" id="title" name="title" placeholder="Enter the title of your study"
        value="<?php echo isset($formData2['title']) ? htmlspecialchars($formData2['title']) : ''; ?>" >

      </div>

      <div class="form-group">
      <label>2. Type of study:</label>
    <div class="radio-options">
        <label for="academicStaff">
            <input type="radio" id="academicStaff" name="type_of_study" value="academicStaff"  <?php echo isset($formData2['type_of_study']) && $formData2['type_of_study'] === 'academicStaff' ? 'checked' : ''; ?>>
            Academic Staff Study
        </label>
        <label for="doctorateThesis">
            <input type="radio" id="doctorateThesis" name="type_of_study" value="doctorateThesis"  <?php echo isset($formData2['type_of_study']) && $formData2['type_of_study'] === 'doctorateThesis' ? 'checked' : ''; ?>>
            Doctorate Thesis
        </label>
        <label for="masterThesis">
            <input type="radio" id="masterThesis" name="type_of_study" value="masterThesis"  <?php echo isset($formData2['type_of_study']) && $formData2['type_of_study'] === 'masterThesis' ? 'checked' : ''; ?>>
            Master Thesis
        </label>
        <label for="undergraduate">
            <input type="radio" id="undergraduate" name="type_of_study" value="undergraduate"  <?php echo isset($formData2['type_of_study']) && $formData2['type_of_study'] === 'undergraduate' ? 'checked' : ''; ?>>
            Undergraduate
        </label>
        <label for="other">
            <input type="radio" id="other" name="type_of_study" value="other"  <?php echo isset($formData2['type_of_study']) && $formData2['type_of_study'] === 'other' ? 'checked' : ''; ?>>
            Other (Specify)
        </label>
        <input type="text" id="otherSpecify" name="otherSpecify" placeholder="Specify" style="<?php echo isset($formData2['type_of_study']) && $formData2['type_of_study'] === 'other' ? 'display: block;' : 'display: none;'; ?>"
               value="<?php echo isset($formData2['otherSpecify']) ? htmlspecialchars($formData2['otherSpecify']) : ''; ?>" >
    </div>
</div>
      

      <div class="form-group">
        <label for="researcherName">3. Researcher’s Name and surname:</label>
        <input type="text" id="researcher_name" name="researcher_name" placeholder="Enter your name and surname"
        value="<?php echo isset($formData2['researcher_name']) ? htmlspecialchars($formData2['researcher_name']) : ''; ?>" >

      </div>

      <div class="form-group">
        <label for="department">Department:</label>
        <input type="text" id="department" name="department" placeholder="Enter your department"
        value="<?php echo isset($formData2['department']) ? htmlspecialchars($formData2['department']) : ''; ?>">

      </div>

      <div class="form-group">
        <label for="institute">Institute:</label>
        <input type="text" id="institute" name="institute" placeholder="Enter your institute"
        value="<?php echo isset($formData2['institute']) ? htmlspecialchars($formData2['institute']) : ''; ?>">

      </div>

      <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" placeholder="Enter your phone number"
        value="<?php echo isset($formData2['phone']) ? htmlspecialchars($formData2['phone']) : ''; ?>" >

      </div>

      <div class="form-group">
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" placeholder="Enter your address"
        value="<?php echo isset($formData2['address']) ? htmlspecialchars($formData2['address']) : ''; ?>" >

      </div>

      <div class="form-group">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" placeholder="Enter your email address"
        value="<?php echo isset($formData2['email']) ? htmlspecialchars($formData2['email']) : ''; ?>" >

      </div>

      <div class="form-group">
        
      
  
      <div class="form-group">
      <label for="otherResearchers">Number of researchers (0-10):</label>
    <select id="numResearchers" name="num_researchers" >
        <?php for ($i = 0; $i <= 10; $i++) {
            echo '<option value="' . $i . '"';
            if (isset($formData2['num_researchers']) && $formData2['num_researchers'] == $i) {
                echo ' selected';
            }
            echo '>' . $i . '</option>';
        } ?>
    </select>
      </div>
      
      <div class="researchers-container">
      <?php
  if (isset($formData2['researcherData'])) {
    $researcherEntries = explode('; ', $formData2['researcherData']);
    foreach ($researcherEntries as $index => $entry) {
      list($researcherName, $researcherInstitution) = explode(' (', $entry);
      $researcherInstitution = rtrim($researcherInstitution, ')');
      ?>
      <div class="form-group">
      <label for="researcherName<?php echo $index + 1; ?>">Researcher Name and Surname:</label>
        <input type="text" name="researcherName<?php echo $index + 1; ?>" value="<?php echo $researcherName; ?>" required >
        <label for="researcherInstitution<?php echo $index + 1; ?>">Institution:</label>
        <input type="text" name="researcherInstitution<?php echo $index + 1; ?>" value="<?php echo $researcherInstitution; ?>" required >
      </div>
      <?php
    }
  }
  ?>
</div>

  
      <div class="form-group" id="advisorSection" style="display: none;">
      <p>5. Advisor’s/Supervising Faculty Member’s (Undergraduate students conducting research must have an academic advisor/instructor supervising their research):</p>
    <label for="advisor_title">Title:</label>
    <select id="advisor_title" name="advisor_title">
        <option value="Instr."  <?php if (isset($formData2['advisor_title']) && $formData2['advisor_title'] === 'Instr.') echo 'selected'; ?>>Instr.</option>
        <option value="Sen Instr."  <?php if (isset($formData2['advisor_title']) && $formData2['advisor_title'] === 'Sen Instr.') echo 'selected'; ?>>Sen Instr.</option>
        <option value="Dr."  <?php if (isset($formData2['advisor_title']) && $formData2['advisor_title'] === 'Dr.') echo 'selected'; ?>>Dr.</option>
        <option value="Asst.Prof.Dr." diabled <?php if (isset($formData2['advisor_title']) && $formData2['advisor_title'] === 'Asst.Prof.Dr.') echo 'selected'; ?>>Asst.Prof.Dr.</option>
        <option value="Assoc.Pro.Dr."  <?php if (isset($formData2['advisor_title']) && $formData2['advisor_title'] === 'Assoc.Pro.Dr.') echo 'selected'; ?>>Assoc.Prof.Dr.</option>
    </select>
    <br>
        <label for="advisorName">Name and Surname:</label>
        <input type="text" id="advisorName" name="advisor_name" placeholder="Enter the name of the advisor"
        value="<?php echo isset($formData2['advisorName']) ? htmlspecialchars($formData2['advisorName']) : ''; ?>">

        <label for="advisorAddress">Address:</label>
        <input type="text" id="advisorAddress" name="advisor_address" placeholder="Enter address"
        value="<?php echo isset($formData2['advisor_address']) ? htmlspecialchars($formData2['advisor_address']) : ''; ?>">

        <div class="advisor-info" style="display: none;">
          <label for="advisorDepartment">Department:</label>
          <input type="text" id="advisorDepartment" name="advisor_department" placeholder="Enter the advisor's department"
          value="<?php echo isset($formData2['advisor_department']) ? htmlspecialchars($formData2['advisor_department']) : ''; ?>">

        </div>
      
        <div class="advisor-info" style="display: none;">
          <label for="advisorPhone">Phone:</label>
          <input type="tel" id="advisorPhone" name="advisor_phone" placeholder="Enter the advisor's phone number"
          value="<?php echo isset($formData2['advisor_phone']) ? htmlspecialchars($formData2['advisor_phone']) : ''; ?>">

        </div>
      </div>
      
      
      
        
      
      
      <div class="form-group">
        <label for="studyTimeFrame">6. Expected time frame of the study:</label>
        <label for="startDate">Start:</label>
        <input type="date" id="startDate" name="start_date"
        value="<?php echo isset($formData2['start_date']) ? htmlspecialchars($formData2['start_date']) : ''; ?>">

        <label for="endDate">End:</label>
        <input type="date" id="endDate" name="end_date"
        value="<?php echo isset($formData2['end_date']) ? htmlspecialchars($formData2['end_date']) : ''; ?>" >

        <p>The start date of the study should be at least three weeks from your date of application.</p>
      </div>

      <div class="form-group">
        <label for="organizations">7. Organizations, institutions in which data collection is planned to be accomplished:</label>
        <input type="text" id="organizations" name="organizationA" placeholder="Organization A"
        value="<?php echo isset($formData2['organizationA']) ? htmlspecialchars($formData2['organizationA']) : ''; ?>">

        <input type="text" id="organizations" name="organizationB" placeholder="Organization B"
        value="<?php echo isset($formData2['organizationB']) ? htmlspecialchars($formData2['organizationB']) : ''; ?>">

        <input type="text" id="organizations" name="organizationC" placeholder="Organization C"
        value="<?php echo isset($formData2['organizationC']) ? htmlspecialchars($formData2['organizationC']) : ''; ?>">

      </div>

      <div class="form-group">
      <label for="externalOrganization">8. Is the approval of organization/institution other than FIU required for data collection?</label>
    <input type="radio" id="externalOrganizationYes" name="external_organization" value="yes"  <?php if (isset($formData2['external_organization']) && $formData2['external_organization'] === 'yes') echo 'checked'; ?>>
    <label for="externalOrganizationYes">Yes</label>
    <input type="radio" id="externalOrganizationNo" name="external_organization" value="no"  <?php if (isset($formData2['external_organization']) && $formData2['external_organization'] === 'no') echo 'checked'; ?>>
    <label for="externalOrganizationNo">No</label>
    <textarea id="externalOrganizationDetails" name="external_organization_details" placeholder="If yes, please specify the organization details" ><?php echo isset($formData2['external_organization_details']) ? htmlspecialchars($formData2['external_organization_details']) : ''; ?></textarea>
</div>
      

      <div class="form-group">
      <label for="supported">9. Whether the project is supported/funded or not:</label>
    <input type="radio" id="supportedYes" name="supported" value="Supported"  <?php if (isset($formData2['supported']) && $formData2['supported'] === 'Supported') echo 'checked'; ?>>
    <label for="supportedYes">Supported</label>
    <input type="radio" id="supportedNo" name="supported" value="Not supported"  <?php if (isset($formData2['supported']) && $formData2['supported'] === 'Not supported') echo 'checked'; ?>>
    <label for="supportedNo">Not supported</label>
</div>

<div id="fundingOrganizationSection" <?php if (isset($formData2['supported']) && $formData2['supported'] === 'Supported') echo 'style="display: block;"'; else echo 'style="display: none;"'; ?>>
    <p>If supported, specify Institution</p>
    <input type="radio" id="University" name="supporting_institution" value="University"  <?php if (isset($formData2['supporting_institution']) && $formData2['supporting_institution'] === 'University') echo 'checked'; ?>>
    <label for="University">University</label>
    <div id="universityTextBox" <?php if (isset($formData['supporting_institution']) && $formData2['supporting_institution'] === 'University') echo 'style="display: block;"'; else echo 'style="display: none;"'; ?>>
        <p>Specify the university:</p>
        <input type="text" id="universityInstitution" name="universityInstitution" placeholder="Enter university name" value="<?php echo isset($formData2['universityInstitution']) ? htmlspecialchars($formData2['universityInstitution']) : ''; ?>" >
    </div>
    <input type="radio" id="TUBITAK" name="supporting_institution" value="TUBITAK"  <?php if (isset($formData2['supporting_institution']) && $formData2['supporting_institution'] === 'TUBITAK') echo 'checked'; ?>>
    <label for="TUBITAK">TUBITAK</label>
    <div id="tubitakTextBox" <?php if (isset($formData2['supporting_institution']) && $formData2['supporting_institution'] === 'TUBITAK') echo 'style="display: block;"'; else echo 'style="display: none;"'; ?>>
        <p>Specify TUBITAK details:</p>
        <input type="text" id="tubitakInstitution" name="tubitakInstitution" placeholder="Enter TUBITAK details" value="<?php echo isset($formData2['tubitakInstitution']) ? htmlspecialchars($formData2['tubitakInstitution']) : ''; ?>" >
    </div>
    <input type="radio" id="International" name="supporting_institution" value="International" <?php if (isset($formData2['supporting_institution']) && $formData2['supporting_institution'] === 'International') echo 'checked'; ?>>
    <label for="International">International</label>
    <div id="internationalTextBox" <?php if (isset($formData['supporting_institution']) && $formData['supporting_institution'] === 'International') echo 'style="display: block;"'; else echo 'style="display: none;"'; ?>>
        <p>Specify the international institution:</p>
        <input type="text" id="internationalInstitution" name="internationalInstitution" placeholder="Enter international institution name" value="<?php echo isset($formData2['internationalInstitution']) ? htmlspecialchars($formData2['internationalInstitution']) : ''; ?>" >
    </div>
    <input type="radio" id="Other" name="supporting_institution" value="Other"  <?php if (isset($formData2['supporting_institution']) && $formData2['supporting_institution'] === 'Other') echo 'checked'; ?>>
    <label for="Other">Other</label>
    <div id="otherTextBox" <?php if (isset($formData2['supporting_institution']) && $formData2['supporting_institution'] === 'Other') echo 'style="display: block;"'; else echo 'style="display: none;"'; ?>>
        <p>Specify other institution:</p>
        <input type="text" id="otherInstitution" name="otherInstitution" placeholder="Enter other institution name" value="<?php echo isset($formData2['otherInstitution']) ? htmlspecialchars($formData2['otherInstitution']) : ''; ?>" >
    </div>
</div>

<p>Will the ethical approval be used for a project submission (TUBITAK, EU projects, etc.)?</p>
<input type="radio" id="approvalUsedYes" name="approvalUsed" value="yes"  <?php if (isset($formData2['approvalUsed']) && $formData2['approvalUsed'] === 'yes') echo 'checked'; ?>>
<label for="approvalUsedYes">Yes</label>
<input type="radio" id="approvalUsedNo" name="approvalUsed" value="no"  <?php if (isset($formData2['approvalUsed']) && $formData2['approvalUsed'] === 'no') echo 'checked'; ?>>
<label for="approvalUsedNo">No</label>
      
      

      <div class="form-group">
      <label for="applicationStatus">10. Status of the application:</label>
<input type="radio" id="applicationStatusNew" name="applicationStatus" value="new" <?php if (isset($formData2['applicationStatus']) && $formData2['applicationStatus'] === 'new') echo 'checked'; ?>>
<label for="applicationStatusNew">New</label>
<input type="radio" id="applicationStatusRevised" name="applicationStatus" value="revised"  <?php if (isset($formData2['applicationStatus']) && $formData2['applicationStatus'] === 'revised') echo 'checked'; ?>>
<label for="applicationStatusRevised">Revised</label>
<input type="radio" id="applicationStatusExtension" name="applicationStatus" value="extension"  <?php if (isset($formData2['applicationStatus']) && $formData2['applicationStatus'] === 'extension') echo 'checked'; ?>>
<label for="applicationStatusExtension">Extension of a Previous Study</label>
<input type="radio" id="applicationStatusChanges" name="applicationStatus" value="changes" <?php if (isset($formData2['applicationStatus']) && $formData2['applicationStatus'] === 'changes') echo 'checked'; ?>>
<label for="applicationStatusChanges">Reporting changes</label>
<br>
<div class="form-group" id="extensionSection" <?php if (isset($formData2['applicationStatus']) && $formData2['applicationStatus'] === 'extension') echo 'style="display: block;"'; else echo 'style="display: none;"'; ?>>
    <label for="previousProtocolNumber">Protocol No (if extension):</label>
    <input type="text" id="previousProtocolNumber" name="previous_protocol_number" value="<?php echo isset($formData2['previous_protocol_number']) ? htmlspecialchars($formData2['previous_protocol_number']) : ''; ?>" >
    <br>
    <label for="newCompletionDate">The new expected date of completion:</label>
    <input type="date" id="newCompletionDate" name="new_completion_date" value="<?php echo isset($formData2['new_completion_date']) ? htmlspecialchars($formData2['new_completion_date']) : ''; ?>" >
    <br>
    <p>If this application is a request for the extension of a previous study, does the current study show any differences from the previously approved one?</p>
    <input type="radio" id="studyChangesYes" name="study_changes" value="yes"  <?php if (isset($formData2['study_changes']) && $formData2['study_changes'] === 'yes') echo 'checked'; ?>>
    <label for="studyChangesYes">Yes</label>
    <input type="radio" id="studyChangesNo" name="study_changes" value="no"  <?php if (isset($formData2['study_changes']) && $formData2['study_changes'] === 'no') echo 'checked'; ?>>
    <label for="studyChangesNo">No</label>
    <br>
    <!-- Hidden section for "If yes, please explain the changes you want to make" -->
    <!-- Hidden section for "If yes, please explain the changes you want to make" -->
<div class="form-group" id="studyChangesSection" style="display: none;">
  <label for="protocolChanges">If yes, please explain the changes you want to make:</label>
  <textarea id="protocolChanges" name="protocol_changes" placeholder="Explain the changes in a simple language (two paragraphs maximum)" ><?php echo isset($formData2['protocol_changes']) ? htmlspecialchars($formData2['protocol_changes']) : ''; ?></textarea>
</div>

      <br>
      <p>Is the reason for the proposed changes an unexpected situation that happens to a participant in the study (e.g., an event that could harm the participant’s psychological or physical health)?</p>
    <input type="radio" id="unexpectedYes" name="unexpected" value="yes"  <?php if (isset($formData2['unexpected']) && $formData2['unexpected'] === 'yes') echo 'checked'; ?>>
    <label for="unexpectedYes">Yes</label>
    <input type="radio" id="unexpectedNo" name="unexpected" value="no"  <?php if (isset($formData2['unexpected']) && $formData2['unexpected'] === 'no') echo 'checked'; ?>>
    <label for="unexpectedNo">No</label>
      <br>
      <!-- Hidden section for "If your answer is yes..." -->
      <div class="form-group" id="unexpectedDetailsSection" style="display: none;">
        <label for="unexpectedDetails">If your answer is yes; describe the unexpected situation that requires you to make changes. Please indicate what measures you have taken to prevent similar situations from occurring in the future.</label>
        <textarea id="unexpected_details" name="unexpected_details" placeholder="Describe the unexpected situation and preventive measures" ><?php echo isset($formData2['unexpected_details']) ? htmlspecialchars($formData2['unexpected_details']) : ''; ?> </textarea>
        

      </div>
    </div>
  </div>
</div>

<div class="form-group" id="reportingChangesSection" style="display: none;">

        <p>Reporting changes (if any)</p>
        <p>Protocol Number</p> 
        <br>
        <input type="text" id="Protocol No." name="ProtocolNo" placeholder="Enter Protocol Number"
        value="<?php echo isset($formData2['ProtocolNo']) ? htmlspecialchars($formData2['ProtocolNo']) : ''; ?>" >

        <br>
        <p>Please explain the changes you want to make (e.g., adding a new researcher to the research team, adding a new measure, adding a new study similar to your approved study) in a simple language so that people with no expertise in the field can understand (two paragraphs maximum). If your change(s) will be new informed consent form, debriefing form, etc., submit these forms together with the revised application to the Ethics Committee.</p>
        <input type="text" id="Changes" name="Changes"
        value="<?php echo isset($formData2['Changes']) ? htmlspecialchars($formData2['Changes']) : ''; ?>" >

        <p>Is the reason for the proposed changes an unexpected situation that happens to a participant in the study (e.g., an event that could harm the participant’s psychological or physical health)?</p>
    <input type="radio" id="unexpectedYes" name="unexpected1" value="yes"  <?php if (isset($formData2['unexpected1']) && $formData2['unexpected1'] === 'yes') echo 'checked'; ?>>
    <label for="unexpectedYes">Yes</label>
    <input type="radio" id="unexpectedNo" name="unexpected1" value="no"  <?php if (isset($formData2['unexpected1']) && $formData2['unexpected1'] === 'no') echo 'checked'; ?>>
    <label for="unexpectedNo">No</label>
        <br>
        <p>If your answer is yes; describe the unexpected situation that requires you to make changes. Please indicate what measures you have taken to prevent similar situations from occurring in the future.</p>
        <input type="text" id="Reason" name="Reason"
        value="<?php echo isset($formDat2a['Reason']) ? htmlspecialchars($formData2['Reasons']) : ''; ?>"  >

      </div>
      <div class="form-group" id="question11To21" style="display: none;">
      <div class="form-group">
        <label for="purposeStudy">11. Please explain the purpose of your study and the research question you are trying to answer with this study:</label>
        <input type="text" id="purposeStudy" name="purposeStudy" placeholder="Explain the purpose and research question in a simple language (maximum of two paragraphs)"
        value="<?php echo isset($formData2['purposeStudy']) ? htmlspecialchars($formData2['purposeStudy']) : ''; ?>" >

      </div>

      <div class="form-group">
        <label for="dataCollectionProcess">12. Write down your data collection process, including the method, scale, tools, and techniques to be used. (Submit a copy of any measure or questionnaire used in the research with this document.)</label>
        <input type="text" id="dataCollectionProcess" name="dataCollectionProcess" placeholder="Explain the data collection process"
        value="<?php echo isset($formData2['dataCollectionProcess']) ? htmlspecialchars($formData2['dataCollectionProcess']) : ''; ?>" >

      </div>
      <div class="form-group">
    <label for="deception">13. Does the study aim to partially/completely provide the participants with incorrect information in any way? Is there deception? Does the study require secrecy?</label>
    <input type="radio" id="deceptionYes" name="deception" value="yes"  <?php if (isset($formData2['deception']) && $formData2['deception'] === 'yes') echo 'checked'; ?>>
    <label for="deceptionYes">Yes</label>
    <input type="radio" id="deceptionNo" name="deception" value="no"  <?php if (isset($formData2['deception']) && $formData2['deception'] === 'no') echo 'checked'; ?>>
    <label for="deceptionNo">No</label>
</div>


      <div class="form-group">
    <label for="negativeEffects">14. Beyond the minimum stress and discomfort that participants may encounter in their daily lives, does your work contain elements that threaten their physical and/or mental health or that may be a source of stress for them?</label>
    <input type="radio" id="negativeEffectsYes" name="negative_effects" value="yes"  <?php if (isset($formData2['negative_effects']) && $formData2['negative_effects'] === 'yes') echo 'checked'; ?>>
    <label for="negativeEffectsYes">Yes</label>
    <input type="radio" id="negativeEffectsNo" name="negative_effects" value="no"  <?php if (isset($formData2['negative_effects']) && $formData2['negative_effects'] === 'no') echo 'checked'; ?>>
    <label for="negativeEffectsNo">No</label>
        <br>
        <label for="effectsDetails">If your answer is yes; what negative effects does your work have on the physical and/or mental health of the participants? Please explain in detail. Please write down the measures taken in order to eliminate or minimize the effects of these elements.</label>
        <input type="text" id="effectsDetails" name="effects_details" placeholder="Explain the negative effects and preventive measures"
        value="<?php echo isset($formData2['effects_details']) ? htmlspecialchars($formData2['effects_details']) : ''; ?>" >

      </div>

      <div class="form-group">
        <label for="expectedParticipants">15. The expected number of participants:</label>
        <input type="number" id="expectedParticipants" name="expectedParticipants"
        value="<?php echo isset($formData2['expectedParticipants']) ? htmlspecialchars($formData2['expectedParticipants']) : ''; ?>" >

      </div>

      <div class="form-group">
    <label for="controlGroup">16. If you are doing an education or intervention study, will a control group be used?</label>
    <input type="radio" id="controlGroupYes" name="controlGroup" value="yes"  <?php if (isset($formData2['controlGroup']) && $formData2['controlGroup'] === 'yes') echo 'checked'; ?>>
    <label for="controlGroupYes">Yes</label>
    <input type="radio" id="controlGroupNo" name="controlGroup" value="no"  <?php if (isset($formData2['controlGroup']) && $formData2['controlGroup'] === 'no') echo 'checked'; ?>>
    <label for="controlGroupNo">No</label>
</div>


      <div class="form-group" id="question17To21" style="display: none;">

      <div class="form-group">
    <label for="participantTypes">17. From the list presented below, tick the options that best describe the participants:</label>

    <input type="checkbox" id="participantTypeUniversityStudents" name="participantType[]" value="universityStudents"  <?php if (!empty($formData2['participantType']) && in_array('universityStudents', explode(',', $formData2['participantType']))) echo 'checked'; ?>>
    <label for="participantTypeUniversityStudents">University students</label>

    <input type="checkbox" id="participantTypeAdultsEmployment" name="participantType[]" value="adultsEmployment"  <?php if (!empty($formData2['participantType']) && in_array('adultsEmployment', explode(',', $formData2['participantType']))) echo 'checked'; ?>>
    <label for="participantTypeAdultsEmployment">Adults in employment</label>

    <input type="checkbox" id="participantTypeUnemployedAdults" name="participantType[]" value="unemployedAdults"  <?php if (!empty($formData2['participantType']) && in_array('unemployedAdults', explode(',', $formData2['participantType']))) echo 'checked'; ?>>
    <label for="participantTypeUnemployedAdults">Unemployed adults</label>

    <input type="checkbox" id="participantTypePreschoolChildren" name="participantType[]" value="preschoolChildren"  <?php if (!empty($formData2['participantType']) && in_array('preschoolChildren', explode(',', $formData2['participantType']))) echo 'checked'; ?>>
    <label for="participantTypePreschoolChildren">Preschool children</label>

    <input type="checkbox" id="participantTypePrimarySchoolPupils" name="participantType[]" value="primarySchoolPupils"  <?php if (!empty($formData2['participantType']) && in_array('primarySchoolPupils', explode(',', $formData2['participantType']))) echo 'checked'; ?>>
    <label for="participantTypePrimarySchoolPupils">Primary school pupils</label>

    <input type="checkbox" id="participantTypeHighSchoolStudents" name="participantType[]" value="highSchoolStudents"  <?php if (!empty($formData2['participantType']) && in_array('highSchoolStudents', explode(',', $formData2['participantType']))) echo 'checked'; ?>>
    <label for="participantTypeHighSchoolStudents">High school students</label>

    <input type="checkbox" id="participantTypeChildWorkers" name="participantType[]" value="childWorkers"  <?php if (!empty($formData2['participantType']) && in_array('childWorkers', explode(',', $formData2['participantType']))) echo 'checked'; ?>>
    <label for="participantTypeChildWorkers">Child workers</label>

    <input type="checkbox" id="participantTypeElderly" name="participantType[]" value="elderly"  <?php if (!empty($formData2['participantType']) && in_array('elderly', explode(',', $formData2['participantType']))) echo 'checked'; ?>>
    <label for="participantTypeElderly">The elderly</label>

    <input type="checkbox" id="participantTypeMentally" name="participantType[]" value="mentally"  <?php if (!empty($formData2['participantType']) && in_array('mentally', explode(',', $formData2['participantType']))) echo 'checked'; ?>>
    <label for="participantTypeMentally">Mentally /challenged individuals</label>

    <input type="checkbox" id="participantTypePhysically" name="participantType[]" value="physically"  <?php if (!empty($formData2['participantType']) && in_array('physically', explode(',', $formData2['participantType']))) echo 'checked'; ?>>
    <label for="participantTypePhysically">Physically /challenged individuals</label>

    <input type="checkbox" id="participantTypePrisoners" name="participantType[]" value="prisoners"  <?php if (!empty($formData2['participantType']) && in_array('prisoners', explode(',', $formData2['participantType']))) echo 'checked'; ?>>
    <label for="participantTypePrisoners">Prisoners</label>

    <input type="checkbox" id="participantTypeOther" name="participantType[]" value="Other"  <?php if (!empty($formData2['participantType']) && in_array('Other', explode(',', $formData2['participantType']))) echo 'checked'; ?>>
    <label for="participantTypeOther">Other (please specify)</label>

    <input type="text" id="participantTypeOtherText" name="participantTypeOtherText" style="display: none;" value="<?php echo isset($formData2['participantTypeOtherText']) ? htmlspecialchars($formData2['participantTypeOtherText']) : ''; ?>" >
            <br>
        <p>If applicable, submit the Parental Approval Form or Informed Consent Form for children and pupils participating in the study.</p>
      </div>
      </div>

      <div class="form-group">
        <label for="sampleCharacteristics">18. Briefly describe the sample characteristics, special restrictions, and conditions for participation (e.g., age group restriction, certain social group requirements, etc.):</label>
        <textarea id="sampleCharacteristics" name="sampleCharacteristics" placeholder="Explain the sample characteristics and restrictions" ><?php echo isset($formData2['sampleCharacteristics']) ? htmlspecialchars($formData2['sampleCharacteristics']) : ''; ?> </textarea>
        

      </div>

      <div class="form-group">
        <label for="invitationMethod">19. Explain how you will invite participants to the study. If the invitation will be via e-mail, social media, various websites, and similar channels, insert the text of the announcement into the application file:</label>
        <textarea id="invitationMethod" name="invitationMethod" placeholder="Explain the method of invitation and insert the announcement text" ><?php echo isset($formData2['invitationMethod']) ? htmlspecialchars($formData2['invitationMethod']) : ''; ?></textarea>
       

      </div>
      <div class="form-group">
    <label for="methodsToBeUsed">20. Please tick the method(s) to be used:</label>
    
    <input type="checkbox" id="methodSurvey" name="methodsToBeUsed[]" value="survey"  <?php if (!empty($formData2['methodsToBeUsed']) && in_array('survey', explode(',', $formData2['methodsToBeUsed']))) echo 'checked'; ?>>
    <label for="methodSurvey">Survey</label>
    
    <input type="checkbox" id="methodInterview" name="methodsToBeUsed[]" value="interview"  <?php if (!empty($formData2['methodsToBeUsed']) && in_array('interview', explode(',', $formData2['methodsToBeUsed']))) echo 'checked'; ?>>
    <label for="methodInterview">Interview</label>
    
    <input type="checkbox" id="methodObservation" name="methodsToBeUsed[]" value="observation"  <?php if (!empty($formData2['methodsToBeUsed']) && in_array('observation', explode(',', $formData2['methodsToBeUsed']))) echo 'checked'; ?>>
    <label for="methodObservation">Observation</label>
    
    <input type="checkbox" id="methodComputerTest" name="methodsToBeUsed[]" value="computerTest"  <?php if (!empty($formData2['methodsToBeUsed']) && in_array('computerTest', explode(',', $formData2['methodsToBeUsed']))) echo 'checked'; ?>>
    <label for="methodComputerTest">Computer test</label>
    
    <input type="checkbox" id="methodVideoRecording" name="methodsToBeUsed[]" value="videoRecording"  <?php if (!empty($formData2['methodsToBeUsed']) && in_array('videoRecording', explode(',', $formData2['methodsToBeUsed']))) echo 'checked'; ?>>
    <label for="methodVideoRecording">Video/film recording</label>
    
    <input type="checkbox" id="methodVoiceRecording" name="methodsToBeUsed[]" value="voiceRecording"  <?php if (!empty($formData2['methodsToBeUsed']) && in_array('voiceRecording', explode(',', $formData2['methodsToBeUsed']))) echo 'checked'; ?>>
    <label for="methodVoiceRecording">Voice recording</label>
    
    <input type="checkbox" id="methodPhysiologicalMeasurement" name="methodsToBeUsed[]" value="physiologicalMeasurement"  <?php if (!empty($formData2['methodsToBeUsed']) && in_array('physiologicalMeasurement', explode(',', $formData2['methodsToBeUsed']))) echo 'checked'; ?>>
    <label for="methodPhysiologicalMeasurement">Physiological measurement</label>
    
    <input type="checkbox" id="methodBiologicalSample" name="methodsToBeUsed[]" value="biologicalSample"  <?php if (!empty($formData2['methodsToBeUsed']) && in_array('biologicalSample', explode(',', $formData2['methodsToBeUsed']))) echo 'checked'; ?>>
    <label for="methodBiologicalSample">Biological sample</label>
    
    <input type="checkbox" id="methodAlcoholDrugs" name="methodsToBeUsed[]" value="alcoholDrugs"  <?php if (!empty($formData2['methodsToBeUsed']) && in_array('alcoholDrugs', explode(',', $formData2['methodsToBeUsed']))) echo 'checked'; ?>>
    <label for="methodAlcoholDrugs">Making participants use alcohol, drugs, or any other chemical substance</label>
    
    <input type="checkbox" id="methodExposureStimulation" name="methodsToBeUsed[]" value="exposureStimulation"  <?php if (!empty($formData2['methodsToBeUsed']) && in_array('exposureStimulation', explode(',', $formData2['methodsToBeUsed']))) echo 'checked'; ?>>
    <label for="methodExposureStimulation">Exposure to high stimulation (such as light, sound)</label>
    
    <input type="checkbox" id="methodExposureRadioactive" name="methodsToBeUsed[]" value="exposureRadioactive"  <?php if (!empty($formData2['methodsToBeUsed']) && in_array('exposureRadioactive', explode(',', $formData2['methodsToBeUsed']))) echo 'checked'; ?>>
    <label for="methodExposureRadioactive">Exposure to radioactive material</label>
    
    <input type="checkbox" id="methodOther" name="methodsToBeUsed[]" value="other"  <?php if (!empty($formData2['methodsToBeUsed']) && in_array('other', explode(',', $formData2['methodsToBeUsed']))) echo 'checked'; ?>>
    <label for="methodOther">Other (please specify)</label>
    
    <input type="text" id="methodOtherText" name="methodOtherText" style="display: none;" value="<?php echo isset($formData2['methodOtherText']) ? htmlspecialchars($formData2['methodOtherText']) : ''; ?>" >
</div>


      <div class="form-group">
        <label for="contributions">21. Write down the possible contributions of this work to your field and/or society (one paragraph at most):</label>
        <textarea id="contributions" name="contributions" placeholder="Explain the possible contributions of the study" >
        <?php echo isset($formData2['contributions']) ? htmlspecialchars($formData2['contributions']) : ''; ?></textarea>

      </div>
    </div>

      <div class="form-group">
        <p>I confirm that the information I have given above is accurate to the best of my knowledge.</p>
        <label for="supervisorName">Supervisor’s (if any) Name and Surname:</label>
        <input type="text" id="supervisorName" name="supervisorName" placeholder="Enter supervisor's name and surname"
        value="<?php echo isset($formData2['supervisorName']) ? htmlspecialchars($formData2['supervisorName']) : ''; ?>" >

        <label for="supervisorSignature">Signature:</label>
        <input type="text" id="supervisorSignature" name="supervisorSignature" placeholder="Enter supervisor's signature"
        value="<?php echo isset($formData2['supervisorSignature']) ? htmlspecialchars($formData2['supervisorSignature']) : ''; ?>" >

        <label for="dateSupervisor">Date:</label>
        <input type="date" id="dateSupervisor" name="dateSupervisor"
        value="<?php echo isset($formData2['dateSupervisor']) ? htmlspecialchars($formData2['dateSupervisor']) : ''; ?>">

        <br>
        <label for="researcherSignature">Researcher’s Name and Surname:</label>
        <input type="text" id="researcherSignature" name="researcherName2" placeholder="Enter researcher's name and surname"
        value="<?php echo isset($formData2['researcherName2']) ? htmlspecialchars($formData2['researcherName2']) : ''; ?>">

        <label for="researcherSignature">Signature:</label>
        <input type="signature" id="researcherSignature" name="researcherSignature" placeholder="Enter researcher's signature"
        value="<?php echo isset($formData2['researcherSignature']) ? htmlspecialchars($formData2['researcherSignature']) : ''; ?>">

        <label for="dateResearcher">Date:</label>
        <input type="date" id="dateResearcher" name="dateResearcher"
        value="<?php echo isset($formData2['dateResearcher']) ? htmlspecialchars($formData2['dateResearcher']) : ''; ?>">

      </div>

      <button type="submit" disabled>Submit</button>
    </form>
    </div>
</body>

</html>