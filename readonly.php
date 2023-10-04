<?php
// edit_form.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session to maintain login state across pages


// Check if the user is not logged in, then redirect to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit();
}

// Function to connect to the MySQL server


// Check if the form ID is provided as a query parameter
if (isset($_GET['form_id'])) {
    $formId = $_GET['form_id'];

    // Fetch the form data based on the form ID (You need to implement this function)
    $formData = getFormData($formId);

    // Process the form submission if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the updated form data from the submitted form
        $updatedStudyDescription = $_POST['StudyDescription'];
        $updatedExplainData = $_POST['ExplainData'];
        $updatedStudyResult = $_POST['StudyResult'];
        $updatedStudyDescription1 = $_POST['StudyDescription_1'];
        $updatedStudyDescription2 = $_POST['StudyDescription_2'];
        $updatedStudyResult1 = $_POST['StudyResult_1'];
        $updatedStudyDescription3 = $_POST['StudyDescription_3'];
        $updatedName = $_POST['Name'];
        $updatedResearcherSignature = $_POST['ResearcherSignature'];
        $updatedName1 = $_POST['Name_1'];
        $updatedSupervisorSignature = $_POST['SupervisorSignature'];

        // Update the form data in the database
        updateFormData($formId, $updatedStudyDescription, $updatedExplainData, $updatedStudyResult, $updatedStudyDescription1, $updatedStudyDescription2, $updatedStudyResult1, $updatedStudyDescription3, $updatedName, $updatedResearcherSignature, $updatedName1, $updatedSupervisorSignature);

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
function getFormData($formId) {
    $conn = connectToDatabase();

    // Prepare and execute a query to fetch form data by form ID
    // Replace 'your_table_name' with the actual name of your table
    $stmt = $conn->prepare("SELECT * FROM projectApplications WHERE form_id = ?");
    $stmt->bind_param("i", $formId);
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Fetch form data as an associative array
    $formData = $result->fetch_assoc();

    return $formData;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <img src="logo.jpg" alt="Final International University" class="logo">
    <title>Read-only Ethics Form</title>
    <style>
        .logo {
            width: 150px;
            display: block;
            margin: 0 auto;
            margin-top: 20px;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 50px;
            border: 2px solid black;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 18px;
            line-height: 1.5;
            color: #000;
            margin: 20px;
            background-color: #fff;
        }

        .center-align {
            text-align: left;
        }

        textarea {
            width: 100%;
            height: 150px;
            resize: none;
            background-color: #eceaea;
            box-sizing: border-box;
            border: 3px solid #f09e9e;
            transition: 0.5s;
            outline: none;
        }

        textarea:focus {
            border: 3px solid rgb(19, 147, 233);
            background-color: #fff;
        }

        .new {
            background-color: #ccc;
            box-sizing: border-box;
            border: 3px solid #f09e9e;
            transition: 0.5s;
            outline: none;
            text-align: left;
        }

        .new:focus {
            border: 3px solid rgb(19, 147, 233);
            background-color: #f5f0f0;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }
        .back-button {
  position: absolute;
  top: 10px;
  left: 10px;
  padding: 10px;
  background-color: #b42323;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.back-button:hover {
  background-color: #8d8181;
}
    </style>
</head>

<body>
<button id="backButton" class="back-button">Back to Applications</button>

    <header>
        <h1>ETHICS COMMITTEE PROJECT INFORMATION FORM (Read-only)</h1>
    </header>

    <main class="container">
        <form>
            <!-- Replace the following lines with your PHP code to generate the read-only form fields -->
            <label for="StudyTitle" class="center-align">1. Briefly describe the study to be conducted, including the
                sub-research questions, and hypotheses if any</label>
            <p class="center-align">
                <textarea name="StudyDescription" rows="8" cols="50" readonly><?php echo isset($formData['StudyDescription']) ? htmlspecialchars($formData['StudyDescription']) : ''; ?></textarea>
            </p>
            <label for="StudyTitle" class="center-align">2. Explain the data collection plan, specifying the methods,
                scales, tools, and techniques to be used.
                <p>
                    (Please hand in a copy of all types of instruments such as scales and questionnaires to be used in
                    the study along with this document.)
                </p>
            </label>
            <p class="center-align">
                <textarea name="ExplainData" rows="8" cols="50" readonly><?php echo isset($formData['ExplainData']) ? htmlspecialchars($formData['ExplainData']) : ''; ?></textarea>
            </p>
            <label for="StudyTitle" class="center-align">3. Write down the expected results of your study.</label>
            <p class="center-align">
                <textarea name="StudyResult" rows="8" cols="50" readonly><?php echo isset($formData['StudyResult']) ? htmlspecialchars($formData['StudyResult']) : ''; ?></textarea>
            </p>
            <label for="StudyTitle" class="center-align">
                4. Does your study involve items/procedures that may jeopardize the physical and/or psychological
                wellbeing of the participants or that may be distressing for them?.
            </label>
            <p>If yes, please explain. Specify the precautions that will be taken to eliminate or minimize the effects
                of these items/procedures</p>
            <br>
            <input type="radio" name="yesno1" value="yes" disabled <?php if (isset($formData['yesno1']) && $formData['yesno1'] === 'yes') echo 'checked'; ?>> Yes
            <input type="radio" name="yesno1" value="no" disabled <?php if (isset($formData['yesno1']) && $formData['yesno1'] === 'no') echo 'checked'; ?>> No
            <div id="inputBoxContainer1" style="display: <?php echo isset($formData['yesno1']) && $formData['yesno1'] === 'yes' ? 'block' : 'none'; ?>;">
                <textarea name="StudyDescription_1" rows="8" cols="50" readonly><?php echo isset($formData['StudyDescription_1']) ? htmlspecialchars($formData['StudyDescription_1']) : ''; ?></textarea>
            </div>
            <!-- YES_NO2 -->
            <label for="StudyTitle" class="center-align">
                <p>5. Will the participants be kept totally/partially uninformed of the aim of the study (i.e. is
                    there deception)?.</p>
                <p>If yes, explain why. Indicate how this will be explained to the participants at the end of the data
                    collection in debriefing the participants</p>
            </label>
            <br>
            <input type="radio" name="yesno2" value="yes" disabled <?php if (isset($formData['yesno2']) && $formData['yesno2'] === 'yes') echo 'checked'; ?>> Yes
            <input type="radio" name="yesno2" value="no" disabled <?php if (isset($formData['yesno2']) && $formData['yesno2'] === 'no') echo 'checked'; ?>> No
            <div id="inputBoxContainer2" style="display: <?php echo isset($formData['yesno2']) && $formData['yesno2'] === 'yes' ? 'block' : 'none'; ?>;">
                <textarea name="StudyDescription_2" rows="8" cols="50" readonly><?php echo isset($formData['StudyDescription_2']) ? htmlspecialchars($formData['StudyDescription_2']) : ''; ?></textarea>
            </div>
            <label for="StudyTitle" class="center-align"> <p>6. Indicate the potential contributions of the study to
                your research area and/or the society.</p></label>
            <p class="center-align">
                <textarea name="StudyResult_1" rows="8" cols="50" readonly><?php echo isset($formData['StudyResult_1']) ? htmlspecialchars($formData['StudyResult_1']) : ''; ?></textarea>
            </p>
            <!-- YES_NO3 -->
            <label for="StudyTitle" class="center-align">
                <p>7. Have you completed any previous research project?.</p>
                <p>If your answer is yes, write down the titles, and dates of previous research projects you have
                    conducted or that you have taken part in and the names of funding institution(s) if any</p>
            </label>
            <br>
            <input type="radio" name="yesno3" value="yes" disabled <?php if (isset($formData['yesno3']) && $formData['yesno3'] === 'yes') echo 'checked'; ?>> Yes
            <input type="radio" name="yesno3" value="no" disabled <?php if (isset($formData['yesno3']) && $formData['yesno3'] === 'no') echo 'checked'; ?>> No
            <div id="inputBoxContainer3" style="display: <?php echo isset($formData['yesno3']) && $formData['yesno3'] === 'yes' ? 'block' : 'none'; ?>;">
                <textarea name="StudyDescription_3" rows="8" cols="50" readonly><?php echo isset($formData['StudyDescription_3']) ? htmlspecialchars($formData['StudyDescription_3']) : ''; ?></textarea>
            </div>
            <!-- start of Questions with Signature -->
            <p>
                <label for="Name">Researcher’s name and surname:</label>
                <input type="text" class="new" size="45" name="Name"
                    value="<?php echo isset($formData['Name']) ? htmlspecialchars($formData['Name']) : ''; ?>" readonly>
                <label for="ResearcherSignature"><p>Signature</p></label>
                <div>
                    <input type="text" class="new" size="45" name="ResearcherSignature"
                        value="<?php echo isset($formData['ResearcherSignature']) ? htmlspecialchars($formData['ResearcherSignature']) : ''; ?>" readonly>
                </div>
            </p>
            <p>
                <label for="Name">Supervisor’s / Advisor’s name and surname</label>
                <input type="text" class="new" size="60" name="Name_1"
                    value="<?php echo isset($formData['Name_1']) ? htmlspecialchars($formData['Name_1']) : ''; ?>" readonly>
                <label for="SupervisorSignature"><p>Signature</p></label>
                <div>
                    <input type="text" class="new" size="45" name="SupervisorSignature"
                        value="<?php echo isset($formData['SupervisorSignature']) ? htmlspecialchars($formData['SupervisorSignature']) : ''; ?>" readonly>
                </div>
            </p>
            <!-- END of Questions with Signature -->
            <input type="submit" value="Submit" class="submit-button" disabled>
        </form>
    </main>
</body>
</html>
<script>
   function toggleInputBox(show, containerId) {
    var inputBoxContainer = document.getElementById(containerId);
    inputBoxContainer.style.display = show ? "block" : "none";

}
const backButton = document.getElementById("backButton");
        backButton.addEventListener("click", function() {
            // Use window.history.back() to navigate back
            window.history.back();
        });

</script>