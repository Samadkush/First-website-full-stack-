<?php
// edit_form.php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

class EthicsForm {
    private $formId;
    private $conn;

    public function __construct($formId, $conn) {
        $this->formId = $formId;
        $this->conn = $conn;
    }

    public function getFormData() {
        $stmt = $this->conn->prepare("SELECT * FROM ethics_forms WHERE form_id = ?");
        $stmt->bind_param("i", $this->formId);
        $stmt->execute();
        $result = $stmt->get_result();
        $formData = $result->fetch_assoc();
        return $formData;
    }

    public function updateFormData($updatedData) {
        $updateQuery = "UPDATE ethics_forms SET ";
        $params = array();
        foreach ($updatedData as $key => $value) {
            $updateQuery .= "$key = ?, ";
            $params[] = &$updatedData[$key];
        }
        $updateQuery = rtrim($updateQuery, ', ') . " WHERE form_id = ?";
        $paramTypes = str_repeat('s', count($params)) . 'i';
        $params[] = &$this->formId;

        $stmt = $this->conn->prepare($updateQuery);
        if ($stmt) {
            call_user_func_array(array($stmt, 'bind_param'), array_merge(array($paramTypes), $params));
            if ($stmt->execute()) {
                echo "Form data updated successfully!";
                header("Location: dashboard.php"); // Replace with your actual success page URL
              } else {
                echo "Error updating form data: " . $stmt->error;
            }
        } else {
            echo "Prepare failed: " . $this->conn->error;
        }
    }
}

// Start the session to maintain login state across pages
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit();
}

include 'db_config.php';
$conn = connectToDatabase();

if (isset($_GET['form_id'])) {
    $formId = $_GET['form_id'];
    $ethicsForm = new EthicsForm($formId, $conn);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $updatedData = array(
            'title' => $_POST['title'],
            'type_of_study' => $_POST['type_of_study'],
            'other_specify' =>isset($_POST['other_specify']) ? $_POST['other_specify'] : null,
            'researcher_name' => $_POST['researcher_name'],
            'department' => $_POST['department'],
            'institute' => $_POST['institute'],
            'phone' => $_POST['phone'],
            'address' => $_POST['address'],
            'email' => $_POST['email'],
            'num_researchers' => $_POST['num_researchers'],
            'researcherData' => isset($_POST['researcherData']) ? $_POST['researcherData'] : null,
            'advisor_title' => $_POST['advisor_title'],
            'advisor_name' => $_POST['advisor_name'],
            'advisor_address' => $_POST['advisor_address'],
            'advisor_department' => $_POST['advisor_department'],
            'advisor_phone' => $_POST['advisor_phone'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'organizationA' => $_POST['organizationA'],
            'organizationB' => $_POST['organizationB'],
            'organizationC' => $_POST['organizationC'],
            'external_organization' => $_POST['external_organization'],
            'external_organization_details' => $_POST['external_organization_details'],
            'supported' => $_POST['supported'],
            'supporting_institution' => isset($_POST['supporting_institution']) ? $_POST['supporting_institution'] : null,
            'universityInstitution' => $_POST['universityInstitution'],
            'tubitakInstitution' => $_POST['tubitakInstitution'],
            'internationalInstitution' => $_POST['internationalInstitution'],
            'otherInstitution' => $_POST['otherInstitution'],
            'approvalUsed' => isset($_POST['approvalUsed']) ? $_POST['approvalUsed'] : null,
            'applicationStatus' => $_POST['applicationStatus'],
            'previous_protocol_number' => $_POST['previous_protocol_number'],
            'new_completion_date' => $_POST['new_completion_date'],
            'study_changes' => isset($_POST['study_changes']) ? $_POST['study_changes'] : null,
            'protocol_changes' => $_POST['protocol_changes'],
            'unexpected' => isset($_POST['unexpected']) ? $_POST['unexpected'] : null,
            'unexpected_details' => $_POST['unexpected_details'],
            'ProtocolNo' => $_POST['ProtocolNo'],
            'Changes' => $_POST['Changes'],
            'unexpected1' => isset($_POST['unexpected1']) ? $_POST['unexpected1'] : null,
            'Reason' => $_POST['Reason'],
            'purposeStudy' => $_POST['purposeStudy'],
            'dataCollectionProcess' => isset($_POST['dataCollectionProcess']) ? $_POST['dataCollectionProcess'] : null,
            'deception' => $_POST['deception'],
            'negative_effects' => $_POST['negative_effects'],
            'effects_details' => $_POST['effects_details'],
            'expectedParticipants' => $_POST['expectedParticipants'],
            'controlGroup' => $_POST['controlGroup'],
            'participantType' => isset($_POST['participantType']) ? implode(',', $_POST['participantType']) : null,
            'participantTypeOtherText' => $_POST['participantTypeOtherText'],
            'sampleCharacteristics' => $_POST['sampleCharacteristics'],
            'invitationMethod' => $_POST['invitationMethod'],
            'methodsToBeUsed' => isset($_POST['methodsToBeUsed']) ? implode(',', $_POST['methodsToBeUsed']) : null,
            'methodOtherText' => $_POST['methodOtherText'],
            'contributions' => $_POST['contributions'],
            'supervisorName' => $_POST['supervisorName'],
            'supervisorSignature' => $_POST['supervisorSignature'],
            'dateSupervisor' => $_POST['dateSupervisor'],
            'researcherName2' => $_POST['researcherName2'],
            'researcherSignature' => $_POST['researcherSignature'],
            'dateResearcher' => $_POST['dateResearcher']
        );
        $ethicsForm->updateFormData($updatedData);
    }

    $formData = $ethicsForm->getFormData();
    // Use $formData to populate your HTML form
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
        value="<?php echo isset($formData['title']) ? htmlspecialchars($formData['title']) : ''; ?>" >

      </div>

      <div class="form-group">
      <label>2. Type of study:</label>
    <div class="radio-options">
        <label for="academicStaff">
            <input type="radio" id="academicStaff" name="type_of_study" value="academicStaff"  <?php echo isset($formData['type_of_study']) && $formData['type_of_study'] === 'academicStaff' ? 'checked' : ''; ?>>
            Academic Staff Study
        </label>
        <label for="doctorateThesis">
            <input type="radio" id="doctorateThesis" name="type_of_study" value="doctorateThesis"  <?php echo isset($formData['type_of_study']) && $formData['type_of_study'] === 'doctorateThesis' ? 'checked' : ''; ?>>
            Doctorate Thesis
        </label>
        <label for="masterThesis">
            <input type="radio" id="masterThesis" name="type_of_study" value="masterThesis"  <?php echo isset($formData['type_of_study']) && $formData['type_of_study'] === 'masterThesis' ? 'checked' : ''; ?>>
            Master Thesis
        </label>
        <label for="undergraduate">
            <input type="radio" id="undergraduate" name="type_of_study" value="undergraduate"  <?php echo isset($formData['type_of_study']) && $formData['type_of_study'] === 'undergraduate' ? 'checked' : ''; ?>>
            Undergraduate
        </label>
        <label for="other">
            <input type="radio" id="other" name="type_of_study" value="other"  <?php echo isset($formData['type_of_study']) && $formData['type_of_study'] === 'other' ? 'checked' : ''; ?>>
            Other (Specify)
        </label>
        <input type="text" id="otherSpecify" name="otherSpecify" placeholder="Specify" style="<?php echo isset($formData['type_of_study']) && $formData['type_of_study'] === 'other' ? 'display: block;' : 'display: none;'; ?>"
               value="<?php echo isset($formData['otherSpecify']) ? htmlspecialchars($formData['otherSpecify']) : ''; ?>" >
    </div>
</div>
      

      <div class="form-group">
        <label for="researcherName">3. Researcher’s Name and surname:</label>
        <input type="text" id="researcher_name" name="researcher_name" placeholder="Enter your name and surname"
        value="<?php echo isset($formData['researcher_name']) ? htmlspecialchars($formData['researcher_name']) : ''; ?>" >

      </div>

      <div class="form-group">
        <label for="department">Department:</label>
        <input type="text" id="department" name="department" placeholder="Enter your department"
        value="<?php echo isset($formData['department']) ? htmlspecialchars($formData['department']) : ''; ?>">

      </div>

      <div class="form-group">
        <label for="institute">Institute:</label>
        <input type="text" id="institute" name="institute" placeholder="Enter your institute"
        value="<?php echo isset($formData['institute']) ? htmlspecialchars($formData['institute']) : ''; ?>">

      </div>

      <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" placeholder="Enter your phone number"
        value="<?php echo isset($formData['phone']) ? htmlspecialchars($formData['phone']) : ''; ?>" >

      </div>

      <div class="form-group">
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" placeholder="Enter your address"
        value="<?php echo isset($formData['address']) ? htmlspecialchars($formData['address']) : ''; ?>" >

      </div>

      <div class="form-group">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" placeholder="Enter your email address"
        value="<?php echo isset($formData['email']) ? htmlspecialchars($formData['email']) : ''; ?>" >

      </div>

      <div class="form-group">
        
      
  
      <div class="form-group">
      <label for="otherResearchers">Number of researchers (0-10):</label>
    <select id="numResearchers" name="num_researchers" >
        <?php for ($i = 0; $i <= 10; $i++) {
            echo '<option value="' . $i . '"';
            if (isset($formData['num_researchers']) && $formData['num_researchers'] == $i) {
                echo ' selected';
            }
            echo '>' . $i . '</option>';
        } ?>
    </select>
      </div>
      
      <div class="researchers-container">
    <?php
    if (isset($formData['researcherData'])) {
      $researcherEntries = explode('; ', $formData['researcherData']);
      foreach ($researcherEntries as $index => $entry) {
        list($researcherName, $researcherInstitution) = explode(' (', $entry);
        $researcherInstitution = rtrim($researcherInstitution, ')');
        ?>
        <div class="form-group">
          <label for="researcherName<?php echo $index + 1; ?>">Researcher Name and Surname:</label>
          <input type="text" name="researcherName<?php echo $index + 1; ?>" value="<?php echo $researcherName; ?>" required>
          <label for="researcherInstitution<?php echo $index + 1; ?>">Institution:</label>
          <input type="text" name="researcherInstitution<?php echo $index + 1; ?>" value="<?php echo $researcherInstitution; ?>" required>
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
        <option value="Instr."  <?php if (isset($formData['advisor_title']) && $formData['advisor_title'] === 'Instr.') echo 'selected'; ?>>Instr.</option>
        <option value="Sen Instr."  <?php if (isset($formData['advisor_title']) && $formData['advisor_title'] === 'Sen Instr.') echo 'selected'; ?>>Sen Instr.</option>
        <option value="Dr."  <?php if (isset($formData['advisor_title']) && $formData['advisor_title'] === 'Dr.') echo 'selected'; ?>>Dr.</option>
        <option value="Asst.Prof.Dr." diabled <?php if (isset($formData['advisor_title']) && $formData['advisor_title'] === 'Asst.Prof.Dr.') echo 'selected'; ?>>Asst.Prof.Dr.</option>
        <option value="Assoc.Pro.Dr."  <?php if (isset($formData['advisor_title']) && $formData['advisor_title'] === 'Assoc.Pro.Dr.') echo 'selected'; ?>>Assoc.Prof.Dr.</option>
    </select>
    <br>
        <label for="advisorName">Name and Surname:</label>
        <input type="text" id="advisorName" name="advisor_name" placeholder="Enter the name of the advisor"
        value="<?php echo isset($formData['advisorName']) ? htmlspecialchars($formData['advisorName']) : ''; ?>">

        <label for="advisorAddress">Address:</label>
        <input type="text" id="advisorAddress" name="advisor_address" placeholder="Enter address"
        value="<?php echo isset($formData['advisor_address']) ? htmlspecialchars($formData['advisor_address']) : ''; ?>">

        <div class="advisor-info" style="display: none;">
          <label for="advisorDepartment">Department:</label>
          <input type="text" id="advisorDepartment" name="advisor_department" placeholder="Enter the advisor's department"
          value="<?php echo isset($formData['advisor_department']) ? htmlspecialchars($formData['advisor_department']) : ''; ?>">

        </div>
      
        <div class="advisor-info" style="display: none;">
          <label for="advisorPhone">Phone:</label>
          <input type="tel" id="advisorPhone" name="advisor_phone" placeholder="Enter the advisor's phone number"
          value="<?php echo isset($formData['advisor_phone']) ? htmlspecialchars($formData['advisor_phone']) : ''; ?>">

        </div>
      </div>
      
      
      
        
      
      
      <div class="form-group">
        <label for="studyTimeFrame">6. Expected time frame of the study:</label>
        <label for="startDate">Start:</label>
        <input type="date" id="startDate" name="start_date"
        value="<?php echo isset($formData['start_date']) ? htmlspecialchars($formData['start_date']) : ''; ?>">

        <label for="endDate">End:</label>
        <input type="date" id="endDate" name="end_date"
        value="<?php echo isset($formData['end_date']) ? htmlspecialchars($formData['end_date']) : ''; ?>" >

        <p>The start date of the study should be at least three weeks from your date of application.</p>
      </div>

      <div class="form-group">
        <label for="organizations">7. Organizations, institutions in which data collection is planned to be accomplished:</label>
        <input type="text" id="organizations" name="organizationA" placeholder="Organization A"
        value="<?php echo isset($formData['organizationA']) ? htmlspecialchars($formData['organizationA']) : ''; ?>">

        <input type="text" id="organizations" name="organizationB" placeholder="Organization B"
        value="<?php echo isset($formData['organizationB']) ? htmlspecialchars($formData['organizationB']) : ''; ?>">

        <input type="text" id="organizations" name="organizationC" placeholder="Organization C"
        value="<?php echo isset($formData['organizationC']) ? htmlspecialchars($formData['organizationC']) : ''; ?>">

      </div>

      <div class="form-group">
      <label for="externalOrganization">8. Is the approval of organization/institution other than FIU required for data collection?</label>
    <input type="radio" id="externalOrganizationYes" name="external_organization" value="yes"  <?php if (isset($formData['external_organization']) && $formData['external_organization'] === 'yes') echo 'checked'; ?>>
    <label for="externalOrganizationYes">Yes</label>
    <input type="radio" id="externalOrganizationNo" name="external_organization" value="no"  <?php if (isset($formData['external_organization']) && $formData['external_organization'] === 'no') echo 'checked'; ?>>
    <label for="externalOrganizationNo">No</label>
    <textarea id="externalOrganizationDetails" name="external_organization_details" placeholder="If yes, please specify the organization details" ><?php echo isset($formData['external_organization_details']) ? htmlspecialchars($formData['external_organization_details']) : ''; ?></textarea>
</div>
      

      <div class="form-group">
      <label for="supported">9. Whether the project is supported/funded or not:</label>
    <input type="radio" id="supportedYes" name="supported" value="Supported"  <?php if (isset($formData['supported']) && $formData['supported'] === 'Supported') echo 'checked'; ?>>
    <label for="supportedYes">Supported</label>
    <input type="radio" id="supportedNo" name="supported" value="Not supported"  <?php if (isset($formData['supported']) && $formData['supported'] === 'Not supported') echo 'checked'; ?>>
    <label for="supportedNo">Not supported</label>
</div>

<div id="fundingOrganizationSection" <?php if (isset($formData['supported']) && $formData['supported'] === 'Supported') echo 'style="display: block;"'; else echo 'style="display: none;"'; ?>>
    <p>If supported, specify Institution</p>
    <input type="radio" id="University" name="supporting_institution" value="University"  <?php if (isset($formData['supporting_institution']) && $formData['supporting_institution'] === 'University') echo 'checked'; ?>>
    <label for="University">University</label>
    <div id="universityTextBox" <?php if (isset($formData['supporting_institution']) && $formData['supporting_institution'] === 'University') echo 'style="display: block;"'; else echo 'style="display: none;"'; ?>>
        <p>Specify the university:</p>
        <input type="text" id="universityInstitution" name="universityInstitution" placeholder="Enter university name" value="<?php echo isset($formData['universityInstitution']) ? htmlspecialchars($formData['universityInstitution']) : ''; ?>" >
    </div>
    <input type="radio" id="TUBITAK" name="supporting_institution" value="TUBITAK"  <?php if (isset($formData['supporting_institution']) && $formData['supporting_institution'] === 'TUBITAK') echo 'checked'; ?>>
    <label for="TUBITAK">TUBITAK</label>
    <div id="tubitakTextBox" <?php if (isset($formData['supporting_institution']) && $formData['supporting_institution'] === 'TUBITAK') echo 'style="display: block;"'; else echo 'style="display: none;"'; ?>>
        <p>Specify TUBITAK details:</p>
        <input type="text" id="tubitakInstitution" name="tubitakInstitution" placeholder="Enter TUBITAK details" value="<?php echo isset($formData['tubitakInstitution']) ? htmlspecialchars($formData['tubitakInstitution']) : ''; ?>" >
    </div>
    <input type="radio" id="International" name="supporting_institution" value="International" <?php if (isset($formData['supporting_institution']) && $formData['supporting_institution'] === 'International') echo 'checked'; ?>>
    <label for="International">International</label>
    <div id="internationalTextBox" <?php if (isset($formData['supporting_institution']) && $formData['supporting_institution'] === 'International') echo 'style="display: block;"'; else echo 'style="display: none;"'; ?>>
        <p>Specify the international institution:</p>
        <input type="text" id="internationalInstitution" name="internationalInstitution" placeholder="Enter international institution name" value="<?php echo isset($formData['internationalInstitution']) ? htmlspecialchars($formData['internationalInstitution']) : ''; ?>" >
    </div>
    <input type="radio" id="Other" name="supporting_institution" value="Other"  <?php if (isset($formData['supporting_institution']) && $formData['supporting_institution'] === 'Other') echo 'checked'; ?>>
    <label for="Other">Other</label>
    <div id="otherTextBox" <?php if (isset($formData['supporting_institution']) && $formData['supporting_institution'] === 'Other') echo 'style="display: block;"'; else echo 'style="display: none;"'; ?>>
        <p>Specify other institution:</p>
        <input type="text" id="otherInstitution" name="otherInstitution" placeholder="Enter other institution name" value="<?php echo isset($formData['otherInstitution']) ? htmlspecialchars($formData['otherInstitution']) : ''; ?>" >
    </div>
</div>

<p>Will the ethical approval be used for a project submission (TUBITAK, EU projects, etc.)?</p>
<input type="radio" id="approvalUsedYes" name="approvalUsed" value="yes"  <?php if (isset($formData['approvalUsed']) && $formData['approvalUsed'] === 'yes') echo 'checked'; ?>>
<label for="approvalUsedYes">Yes</label>
<input type="radio" id="approvalUsedNo" name="approvalUsed" value="no"  <?php if (isset($formData['approvalUsed']) && $formData['approvalUsed'] === 'no') echo 'checked'; ?>>
<label for="approvalUsedNo">No</label>
      
      

      <div class="form-group">
      <label for="applicationStatus">10. Status of the application:</label>
<input type="radio" id="applicationStatusNew" name="applicationStatus" value="new" <?php if (isset($formData['applicationStatus']) && $formData['applicationStatus'] === 'new') echo 'checked'; ?>>
<label for="applicationStatusNew">New</label>
<input type="radio" id="applicationStatusRevised" name="applicationStatus" value="revised"  <?php if (isset($formData['applicationStatus']) && $formData['applicationStatus'] === 'revised') echo 'checked'; ?>>
<label for="applicationStatusRevised">Revised</label>
<input type="radio" id="applicationStatusExtension" name="applicationStatus" value="extension"  <?php if (isset($formData['applicationStatus']) && $formData['applicationStatus'] === 'extension') echo 'checked'; ?>>
<label for="applicationStatusExtension">Extension of a Previous Study</label>
<input type="radio" id="applicationStatusChanges" name="applicationStatus" value="changes" <?php if (isset($formData['applicationStatus']) && $formData['applicationStatus'] === 'changes') echo 'checked'; ?>>
<label for="applicationStatusChanges">Reporting changes</label>
<br>
<div class="form-group" id="extensionSection" <?php if (isset($formData['applicationStatus']) && $formData['applicationStatus'] === 'extension') echo 'style="display: block;"'; else echo 'style="display: none;"'; ?>>
    <label for="previousProtocolNumber">Protocol No (if extension):</label>
    <input type="text" id="previousProtocolNumber" name="previous_protocol_number" value="<?php echo isset($formData['previous_protocol_number']) ? htmlspecialchars($formData['previous_protocol_number']) : ''; ?>" >
    <br>
    <label for="newCompletionDate">The new expected date of completion:</label>
    <input type="date" id="newCompletionDate" name="new_completion_date" value="<?php echo isset($formData['new_completion_date']) ? htmlspecialchars($formData['new_completion_date']) : ''; ?>" >
    <br>
    <p>If this application is a request for the extension of a previous study, does the current study show any differences from the previously approved one?</p>
    <input type="radio" id="studyChangesYes" name="study_changes" value="yes"  <?php if (isset($formData['study_changes']) && $formData['study_changes'] === 'yes') echo 'checked'; ?>>
    <label for="studyChangesYes">Yes</label>
    <input type="radio" id="studyChangesNo" name="study_changes" value="no"  <?php if (isset($formData['study_changes']) && $formData['study_changes'] === 'no') echo 'checked'; ?>>
    <label for="studyChangesNo">No</label>
    <br>
    <!-- Hidden section for "If yes, please explain the changes you want to make" -->
    <!-- Hidden section for "If yes, please explain the changes you want to make" -->
<div class="form-group" id="studyChangesSection" style="display: none;">
  <label for="protocolChanges">If yes, please explain the changes you want to make:</label>
  <textarea id="protocolChanges" name="protocol_changes" placeholder="Explain the changes in a simple language (two paragraphs maximum)" ><?php echo isset($formData['protocol_changes']) ? htmlspecialchars($formData['protocol_changes']) : ''; ?></textarea>
</div>

      <br>
      <p>Is the reason for the proposed changes an unexpected situation that happens to a participant in the study (e.g., an event that could harm the participant’s psychological or physical health)?</p>
    <input type="radio" id="unexpectedYes" name="unexpected" value="yes"  <?php if (isset($formData['unexpected']) && $formData['unexpected'] === 'yes') echo 'checked'; ?>>
    <label for="unexpectedYes">Yes</label>
    <input type="radio" id="unexpectedNo" name="unexpected" value="no"  <?php if (isset($formData['unexpected']) && $formData['unexpected'] === 'no') echo 'checked'; ?>>
    <label for="unexpectedNo">No</label>
      <br>
      <!-- Hidden section for "If your answer is yes..." -->
      <div class="form-group" id="unexpectedDetailsSection" style="display: none;">
        <label for="unexpectedDetails">If your answer is yes; describe the unexpected situation that requires you to make changes. Please indicate what measures you have taken to prevent similar situations from occurring in the future.</label>
        <textarea id="unexpected_details" name="unexpected_details" placeholder="Describe the unexpected situation and preventive measures" ><?php echo isset($formData['unexpected_details']) ? htmlspecialchars($formData['unexpected_details']) : ''; ?> </textarea>
        

      </div>
    </div>
  </div>
</div>

<div class="form-group" id="reportingChangesSection" style="display: none;">

        <p>Reporting changes (if any)</p>
        <p>Protocol Number</p> 
        <br>
        <input type="text" id="Protocol No." name="ProtocolNo" placeholder="Enter Protocol Number"
        value="<?php echo isset($formData['ProtocolNo']) ? htmlspecialchars($formData['ProtocolNo']) : ''; ?>" >

        <br>
        <p>Please explain the changes you want to make (e.g., adding a new researcher to the research team, adding a new measure, adding a new study similar to your approved study) in a simple language so that people with no expertise in the field can understand (two paragraphs maximum). If your change(s) will be new informed consent form, debriefing form, etc., submit these forms together with the revised application to the Ethics Committee.</p>
        <input type="text" id="Changes" name="Changes"
        value="<?php echo isset($formData['Changes']) ? htmlspecialchars($formData['Changes']) : ''; ?>" >

        <p>Is the reason for the proposed changes an unexpected situation that happens to a participant in the study (e.g., an event that could harm the participant’s psychological or physical health)?</p>
    <input type="radio" id="unexpectedYes" name="unexpected1" value="yes"  <?php if (isset($formData['unexpected1']) && $formData['unexpected1'] === 'yes') echo 'checked'; ?>>
    <label for="unexpectedYes">Yes</label>
    <input type="radio" id="unexpectedNo" name="unexpected1" value="no"  <?php if (isset($formData['unexpected1']) && $formData['unexpected1'] === 'no') echo 'checked'; ?>>
    <label for="unexpectedNo">No</label>
        <br>
        <p>If your answer is yes; describe the unexpected situation that requires you to make changes. Please indicate what measures you have taken to prevent similar situations from occurring in the future.</p>
        <input type="text" id="Reason" name="Reason"
        value="<?php echo isset($formDat2a['Reason']) ? htmlspecialchars($formData['Reasons']) : ''; ?>"  >

      </div>
      <div class="form-group" id="question11To21" style="display: none;">
      <div class="form-group">
        <label for="purposeStudy">11. Please explain the purpose of your study and the research question you are trying to answer with this study:</label>
        <input type="text" id="purposeStudy" name="purposeStudy" placeholder="Explain the purpose and research question in a simple language (maximum of two paragraphs)"
        value="<?php echo isset($formData['purposeStudy']) ? htmlspecialchars($formData['purposeStudy']) : ''; ?>" >

      </div>

      <div class="form-group">
        <label for="dataCollectionProcess">12. Write down your data collection process, including the method, scale, tools, and techniques to be used. (Submit a copy of any measure or questionnaire used in the research with this document.)</label>
        <input type="text" id="dataCollectionProcess" name="dataCollectionProcess" placeholder="Explain the data collection process"
        value="<?php echo isset($formData['dataCollectionProcess']) ? htmlspecialchars($formData['dataCollectionProcess']) : ''; ?>" >

      </div>
      <div class="form-group">
    <label for="deception">13. Does the study aim to partially/completely provide the participants with incorrect information in any way? Is there deception? Does the study require secrecy?</label>
    <input type="radio" id="deceptionYes" name="deception" value="yes"  <?php if (isset($formData['deception']) && $formData['deception'] === 'yes') echo 'checked'; ?>>
    <label for="deceptionYes">Yes</label>
    <input type="radio" id="deceptionNo" name="deception" value="no"  <?php if (isset($formData['deception']) && $formData['deception'] === 'no') echo 'checked'; ?>>
    <label for="deceptionNo">No</label>
</div>


      <div class="form-group">
    <label for="negativeEffects">14. Beyond the minimum stress and discomfort that participants may encounter in their daily lives, does your work contain elements that threaten their physical and/or mental health or that may be a source of stress for them?</label>
    <input type="radio" id="negativeEffectsYes" name="negative_effects" value="yes"  <?php if (isset($formData['negative_effects']) && $formData['negative_effects'] === 'yes') echo 'checked'; ?>>
    <label for="negativeEffectsYes">Yes</label>
    <input type="radio" id="negativeEffectsNo" name="negative_effects" value="no"  <?php if (isset($formData['negative_effects']) && $formData['negative_effects'] === 'no') echo 'checked'; ?>>
    <label for="negativeEffectsNo">No</label>
        <br>
        <label for="effectsDetails">If your answer is yes; what negative effects does your work have on the physical and/or mental health of the participants? Please explain in detail. Please write down the measures taken in order to eliminate or minimize the effects of these elements.</label>
        <input type="text" id="effectsDetails" name="effects_details" placeholder="Explain the negative effects and preventive measures"
        value="<?php echo isset($formData['effects_details']) ? htmlspecialchars($formData['effects_details']) : ''; ?>" >

      </div>

      <div class="form-group">
        <label for="expectedParticipants">15. The expected number of participants:</label>
        <input type="number" id="expectedParticipants" name="expectedParticipants"
        value="<?php echo isset($formData['expectedParticipants']) ? htmlspecialchars($formData['expectedParticipants']) : ''; ?>" >

      </div>

      <div class="form-group">
    <label for="controlGroup">16. If you are doing an education or intervention study, will a control group be used?</label>
    <input type="radio" id="controlGroupYes" name="controlGroup" value="yes"  <?php if (isset($formData['controlGroup']) && $formData['controlGroup'] === 'yes') echo 'checked'; ?>>
    <label for="controlGroupYes">Yes</label>
    <input type="radio" id="controlGroupNo" name="controlGroup" value="no"  <?php if (isset($formData['controlGroup']) && $formData['controlGroup'] === 'no') echo 'checked'; ?>>
    <label for="controlGroupNo">No</label>
</div>


      <div class="form-group" id="question17To21" style="display: none;">

      <div class="form-group">
    <label for="participantTypes">17. From the list presented below, tick the options that best describe the participants:</label>

    <input type="checkbox" id="participantTypeUniversityStudents" name="participantType[]" value="universityStudents"  <?php if (!empty($formData['participantType']) && in_array('universityStudents', explode(',', $formData['participantType']))) echo 'checked'; ?>>
    <label for="participantTypeUniversityStudents">University students</label>

    <input type="checkbox" id="participantTypeAdultsEmployment" name="participantType[]" value="adultsEmployment"  <?php if (!empty($formData['participantType']) && in_array('adultsEmployment', explode(',', $formData['participantType']))) echo 'checked'; ?>>
    <label for="participantTypeAdultsEmployment">Adults in employment</label>

    <input type="checkbox" id="participantTypeUnemployedAdults" name="participantType[]" value="unemployedAdults"  <?php if (!empty($formData['participantType']) && in_array('unemployedAdults', explode(',', $formData['participantType']))) echo 'checked'; ?>>
    <label for="participantTypeUnemployedAdults">Unemployed adults</label>

    <input type="checkbox" id="participantTypePreschoolChildren" name="participantType[]" value="preschoolChildren"  <?php if (!empty($formData['participantType']) && in_array('preschoolChildren', explode(',', $formData['participantType']))) echo 'checked'; ?>>
    <label for="participantTypePreschoolChildren">Preschool children</label>

    <input type="checkbox" id="participantTypePrimarySchoolPupils" name="participantType[]" value="primarySchoolPupils"  <?php if (!empty($formData['participantType']) && in_array('primarySchoolPupils', explode(',', $formData['participantType']))) echo 'checked'; ?>>
    <label for="participantTypePrimarySchoolPupils">Primary school pupils</label>

    <input type="checkbox" id="participantTypeHighSchoolStudents" name="participantType[]" value="highSchoolStudents"  <?php if (!empty($formData['participantType']) && in_array('highSchoolStudents', explode(',', $formData['participantType']))) echo 'checked'; ?>>
    <label for="participantTypeHighSchoolStudents">High school students</label>

    <input type="checkbox" id="participantTypeChildWorkers" name="participantType[]" value="childWorkers"  <?php if (!empty($formData['participantType']) && in_array('childWorkers', explode(',', $formData['participantType']))) echo 'checked'; ?>>
    <label for="participantTypeChildWorkers">Child workers</label>

    <input type="checkbox" id="participantTypeElderly" name="participantType[]" value="elderly"  <?php if (!empty($formData['participantType']) && in_array('elderly', explode(',', $formData['participantType']))) echo 'checked'; ?>>
    <label for="participantTypeElderly">The elderly</label>

    <input type="checkbox" id="participantTypeMentally" name="participantType[]" value="mentally"  <?php if (!empty($formData['participantType']) && in_array('mentally', explode(',', $formData['participantType']))) echo 'checked'; ?>>
    <label for="participantTypeMentally">Mentally /challenged individuals</label>

    <input type="checkbox" id="participantTypePhysically" name="participantType[]" value="physically"  <?php if (!empty($formData['participantType']) && in_array('physically', explode(',', $formData['participantType']))) echo 'checked'; ?>>
    <label for="participantTypePhysically">Physically /challenged individuals</label>

    <input type="checkbox" id="participantTypePrisoners" name="participantType[]" value="prisoners"  <?php if (!empty($formData['participantType']) && in_array('prisoners', explode(',', $formData['participantType']))) echo 'checked'; ?>>
    <label for="participantTypePrisoners">Prisoners</label>

    <input type="checkbox" id="participantTypeOther" name="participantType[]" value="Other"  <?php if (!empty($formData['participantType']) && in_array('Other', explode(',', $formData['participantType']))) echo 'checked'; ?>>
    <label for="participantTypeOther">Other (please specify)</label>

    <input type="text" id="participantTypeOtherText" name="participantTypeOtherText" style="display: none;" value="<?php echo isset($formData['participantTypeOtherText']) ? htmlspecialchars($formData['participantTypeOtherText']) : ''; ?>" >
            <br>
        <p>If applicable, submit the Parental Approval Form or Informed Consent Form for children and pupils participating in the study.</p>
      </div>
      </div>

      <div class="form-group">
        <label for="sampleCharacteristics">18. Briefly describe the sample characteristics, special restrictions, and conditions for participation (e.g., age group restriction, certain social group requirements, etc.):</label>
        <textarea id="sampleCharacteristics" name="sampleCharacteristics" placeholder="Explain the sample characteristics and restrictions" ><?php echo isset($formData['sampleCharacteristics']) ? htmlspecialchars($formData['sampleCharacteristics']) : ''; ?> </textarea>
        

      </div>

      <div class="form-group">
        <label for="invitationMethod">19. Explain how you will invite participants to the study. If the invitation will be via e-mail, social media, various websites, and similar channels, insert the text of the announcement into the application file:</label>
        <textarea id="invitationMethod" name="invitationMethod" placeholder="Explain the method of invitation and insert the announcement text" ><?php echo isset($formData['invitationMethod']) ? htmlspecialchars($formData['invitationMethod']) : ''; ?></textarea>
       

      </div>
      <div class="form-group">
    <label for="methodsToBeUsed">20. Please tick the method(s) to be used:</label>
    
    <input type="checkbox" id="methodSurvey" name="methodsToBeUsed[]" value="survey"  <?php if (!empty($formData['methodsToBeUsed']) && in_array('survey', explode(',', $formData['methodsToBeUsed']))) echo 'checked'; ?>>
    <label for="methodSurvey">Survey</label>
    
    <input type="checkbox" id="methodInterview" name="methodsToBeUsed[]" value="interview"  <?php if (!empty($formData['methodsToBeUsed']) && in_array('interview', explode(',', $formData['methodsToBeUsed']))) echo 'checked'; ?>>
    <label for="methodInterview">Interview</label>
    
    <input type="checkbox" id="methodObservation" name="methodsToBeUsed[]" value="observation"  <?php if (!empty($formData['methodsToBeUsed']) && in_array('observation', explode(',', $formData['methodsToBeUsed']))) echo 'checked'; ?>>
    <label for="methodObservation">Observation</label>
    
    <input type="checkbox" id="methodComputerTest" name="methodsToBeUsed[]" value="computerTest"  <?php if (!empty($formData['methodsToBeUsed']) && in_array('computerTest', explode(',', $formData['methodsToBeUsed']))) echo 'checked'; ?>>
    <label for="methodComputerTest">Computer test</label>
    
    <input type="checkbox" id="methodVideoRecording" name="methodsToBeUsed[]" value="videoRecording"  <?php if (!empty($formData['methodsToBeUsed']) && in_array('videoRecording', explode(',', $formData['methodsToBeUsed']))) echo 'checked'; ?>>
    <label for="methodVideoRecording">Video/film recording</label>
    
    <input type="checkbox" id="methodVoiceRecording" name="methodsToBeUsed[]" value="voiceRecording"  <?php if (!empty($formData['methodsToBeUsed']) && in_array('voiceRecording', explode(',', $formData['methodsToBeUsed']))) echo 'checked'; ?>>
    <label for="methodVoiceRecording">Voice recording</label>
    
    <input type="checkbox" id="methodPhysiologicalMeasurement" name="methodsToBeUsed[]" value="physiologicalMeasurement"  <?php if (!empty($formData['methodsToBeUsed']) && in_array('physiologicalMeasurement', explode(',', $formData['methodsToBeUsed']))) echo 'checked'; ?>>
    <label for="methodPhysiologicalMeasurement">Physiological measurement</label>
    
    <input type="checkbox" id="methodBiologicalSample" name="methodsToBeUsed[]" value="biologicalSample"  <?php if (!empty($formData['methodsToBeUsed']) && in_array('biologicalSample', explode(',', $formData['methodsToBeUsed']))) echo 'checked'; ?>>
    <label for="methodBiologicalSample">Biological sample</label>
    
    <input type="checkbox" id="methodAlcoholDrugs" name="methodsToBeUsed[]" value="alcoholDrugs"  <?php if (!empty($formData['methodsToBeUsed']) && in_array('alcoholDrugs', explode(',', $formData['methodsToBeUsed']))) echo 'checked'; ?>>
    <label for="methodAlcoholDrugs">Making participants use alcohol, drugs, or any other chemical substance</label>
    
    <input type="checkbox" id="methodExposureStimulation" name="methodsToBeUsed[]" value="exposureStimulation"  <?php if (!empty($formData['methodsToBeUsed']) && in_array('exposureStimulation', explode(',', $formData['methodsToBeUsed']))) echo 'checked'; ?>>
    <label for="methodExposureStimulation">Exposure to high stimulation (such as light, sound)</label>
    
    <input type="checkbox" id="methodExposureRadioactive" name="methodsToBeUsed[]" value="exposureRadioactive"  <?php if (!empty($formData['methodsToBeUsed']) && in_array('exposureRadioactive', explode(',', $formData['methodsToBeUsed']))) echo 'checked'; ?>>
    <label for="methodExposureRadioactive">Exposure to radioactive material</label>
    
    <input type="checkbox" id="methodOther" name="methodsToBeUsed[]" value="other"  <?php if (!empty($formData['methodsToBeUsed']) && in_array('other', explode(',', $formData['methodsToBeUsed']))) echo 'checked'; ?>>
    <label for="methodOther">Other (please specify)</label>
    
    <input type="text" id="methodOtherText" name="methodOtherText" style="display: none;" value="<?php echo isset($formData['methodOtherText']) ? htmlspecialchars($formData['methodOtherText']) : ''; ?>" >
</div>


      <div class="form-group">
        <label for="contributions">21. Write down the possible contributions of this work to your field and/or society (one paragraph at most):</label>
        <textarea id="contributions" name="contributions" placeholder="Explain the possible contributions of the study" >
        <?php echo isset($formData['contributions']) ? htmlspecialchars($formData['contributions']) : ''; ?></textarea>

      </div>
    </div>

      <div class="form-group">
        <p>I confirm that the information I have given above is accurate to the best of my knowledge.</p>
        <label for="supervisorName">Supervisor’s (if any) Name and Surname:</label>
        <input type="text" id="supervisorName" name="supervisorName" placeholder="Enter supervisor's name and surname"
        value="<?php echo isset($formData['supervisorName']) ? htmlspecialchars($formData['supervisorName']) : ''; ?>" >

        <label for="supervisorSignature">Signature:</label>
        <input type="text" id="supervisorSignature" name="supervisorSignature" placeholder="Enter supervisor's signature"
        value="<?php echo isset($formData['supervisorSignature']) ? htmlspecialchars($formData['supervisorSignature']) : ''; ?>" >

        <label for="dateSupervisor">Date:</label>
        <input type="date" id="dateSupervisor" name="dateSupervisor"
        value="<?php echo isset($formData['dateSupervisor']) ? htmlspecialchars($formData['dateSupervisor']) : ''; ?>">

        <br>
        <label for="researcherSignature">Researcher’s Name and Surname:</label>
        <input type="text" id="researcherSignature" name="researcherName2" placeholder="Enter researcher's name and surname"
        value="<?php echo isset($formData['researcherName2']) ? htmlspecialchars($formData['researcherName2']) : ''; ?>">

        <label for="researcherSignature">Signature:</label>
        <input type="signature" id="researcherSignature" name="researcherSignature" placeholder="Enter researcher's signature"
        value="<?php echo isset($formData['researcherSignature']) ? htmlspecialchars($formData['researcherSignature']) : ''; ?>">

        <label for="dateResearcher">Date:</label>
        <input type="date" id="dateResearcher" name="dateResearcher"
        value="<?php echo isset($formData['dateResearcher']) ? htmlspecialchars($formData['dateResearcher']) : ''; ?>">

      </div>

      <button type="button" id="updateButton">Update</button>
    </form>
    </div>
</body>

</html>