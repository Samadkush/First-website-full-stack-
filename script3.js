document.addEventListener('DOMContentLoaded', function () {
  const ethicsForm = document.getElementById('ethicsForm');
  const otherRadio = document.getElementById('other');
  const otherSpecifyInput = document.getElementById('otherSpecify');
   
  
    // Function to check if the form is valid before submission
    function validateForm(event) {
      const titleInput = document.getElementById('title');
      const researcherNameInput = document.getElementById('researcherName');
      const emailInput = document.getElementById('email');

      if (otherRadio.checked && otherSpecifyInput.value.trim() === '') {
        alert('Please specify the type of study.');
        event.preventDefault();
        return false;
      }
      if (titleInput.value.trim() === '') {
        alert('Please enter the title of the study.');
        event.preventDefault();
        return false;
      }
  
  
      if (otherRadio.checked && otherSpecifyInput.value.trim() === '') {
        alert('Please specify the type of study.');
        event.preventDefault();
        return false;
      }
  
      if (emailInput.value.trim() === '') {
        alert('Please enter your email address.');
        event.preventDefault();
        return false;
      }
  
      // Add more validations for other required fields if necessary
  
      // Form validation successful, show confirmation message
      return true;
    }
  
    // Add form validation on form submission
   //ethicsForm.addEventListener('submit', validateForm);
    
  
    otherRadio.addEventListener('change', function () {
      if (otherRadio.checked) {
        otherSpecifyInput.style.display = 'block';
      } else {
        otherSpecifyInput.style.display = 'none';
      }
    });
  });
  document.addEventListener('DOMContentLoaded', function () {
    const numResearchersSelect = document.getElementById('numResearchers');
    const researchersContainer = document.querySelector('.researchers-container');
  
    numResearchersSelect.addEventListener('change', function () {
      const numResearchers = parseInt(numResearchersSelect.value, 10);
      researchersContainer.innerHTML = ''; // Clear previous inputs
  
      for (let i = 1; i <= numResearchers; i++) {
        const researcherDiv = document.createElement('div');
        researcherDiv.classList.add('form-group');
  
        const nameLabel = document.createElement('label');
        nameLabel.textContent = `Researcher ${i} Name and Surname:`;
        const nameInput = document.createElement('input');
        nameInput.type = 'text';
        nameInput.name = `researcherName${i}`;
        nameInput.placeholder = 'Enter name and surname';
        nameInput.required = true;
  
        const institutionLabel = document.createElement('label');
        institutionLabel.textContent = 'Institution:';
        const institutionInput = document.createElement('input');
        institutionInput.type = 'text';
        institutionInput.name = `researcherInstitution${i}`;
        institutionInput.placeholder = 'Enter institution';
        institutionInput.required = true;
  
        const nameInstitutionDiv = document.createElement('div');
        nameInstitutionDiv.classList.add('name-institution-input');
        nameInstitutionDiv.appendChild(nameInput);
        nameInstitutionDiv.appendChild(institutionLabel);
        nameInstitutionDiv.appendChild(institutionInput);
  
        researcherDiv.appendChild(nameLabel);
        researcherDiv.appendChild(nameInstitutionDiv);
  
        researchersContainer.appendChild(researcherDiv);
      }
    });
  
    const ethicsForm = document.getElementById('ethicsForm');
  
    ethicsForm.addEventListener('submit', function (event) {
      event.preventDefault();
  
      const formData = new FormData(ethicsForm);
      const researcherData = [];
      const numResearchers = parseInt(numResearchersSelect.value, 10);
  
      for (let i = 1; i <= numResearchers; i++) {
        const researcherName = document.querySelector(`input[name="researcherName${i}"]`).value;
        const researcherInstitution = document.querySelector(`input[name="researcherInstitution${i}"]`).value;
        researcherData.push(`Researcher ${i}: ${researcherName} (${researcherInstitution})`);
      }
  
      formData.append('researcherData', researcherData.join('; '));
  
      fetch('save_data2.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.text())
      .then(responseText => {
        console.log(responseText); // Display the response from PHP
        const individualResearcherData = researcherData.map(entry => {
          const parts = entry.split(':');
          const name = parts[0].trim();
          const institution = parts[1].trim();
          return { name, institution };
        });
  
        console.log(individualResearcherData);
        // You can redirect or show a success message here
        window.location.href = 'dashboard.php'; 

      })
      .catch(error => {
        console.log('Error:', error);
      });
    });
  });
  document.addEventListener('DOMContentLoaded', function () {
    const advisorSection = document.getElementById('advisorSection');
    
    const undergraduateRadio = document.getElementById("undergraduate");
const masterThesisRadio = document.getElementById("masterThesis");

// Add event listeners to the radio buttons
undergraduateRadio.addEventListener("change", toggleAdvisorSection);
masterThesisRadio.addEventListener("change", toggleAdvisorSection);

// Function to toggle the visibility of the advisor section
function toggleAdvisorSection() {
    if (undergraduateRadio.checked || masterThesisRadio.checked) {
        advisorSection.style.display = "block";
    } else {
        advisorSection.style.display = "none";
    }
}

// Initially hide the advisor section
toggleAdvisorSection();
});
  
 // JavaScript code to toggle visibility of the textarea based on radio button selection
document.addEventListener('DOMContentLoaded', function () {
  const externalOrganizationYes = document.getElementById('externalOrganizationYes');
  const externalOrganizationDetails = document.getElementById('externalOrganizationDetails');

  // Function to update visibility of textarea
  function updateTextareaVisibility() {
    externalOrganizationDetails.style.display = externalOrganizationYes.checked ? 'block' : 'none';
  }

  // Initial setup
  updateTextareaVisibility();

  // Add event listener to update visibility when the radio buttons are clicked
  externalOrganizationYes.addEventListener('change', updateTextareaVisibility);
  document.getElementById('externalOrganizationNo').addEventListener('change', updateTextareaVisibility);
});
// JavaScript code to handle visibility based on radio button selections
document.addEventListener('DOMContentLoaded', function () {
  const supportedYes = document.getElementById('supportedYes');
  const fundingOrganizationSection = document.getElementById('fundingOrganizationSection');
  const universityTextBox = document.getElementById('universityTextBox');
  const tubitakTextBox = document.getElementById('tubitakTextBox');
  const internationalTextBox = document.getElementById('internationalTextBox');
  const otherTextBox = document.getElementById('otherTextBox');

  // Function to toggle visibility of the funding organization text boxes
  function updateFundingOrganizationVisibility() {
    const fundingOrganizationRadios = document.getElementsByName('supportingInstitution');
    const selectedSupported = supportedYes.checked;

    if (selectedSupported) {
      fundingOrganizationSection.style.display = 'block';
    } else {
      fundingOrganizationSection.style.display = 'none';
      for (const radio of fundingOrganizationRadios) {
        radio.checked = false;
      }
      // Clear all the text boxes when funding organization section is hidden
      document.getElementById('universityInstitution').value = '';
      document.getElementById('tubitakInstitution').value = '';
      document.getElementById('internationalInstitution').value = '';
      document.getElementById('otherInstitution').value = '';
    }
  }

  // Function to toggle visibility of the 'International' or 'Other' text box
  function updateInstitutionTextBoxVisibility() {
    const internationalRadio = document.getElementById('International');
    const otherRadio = document.getElementById('Other');

    internationalTextBox.style.display = internationalRadio.checked ? 'block' : 'none';
    otherTextBox.style.display = otherRadio.checked ? 'block' : 'none';

    // Clear the text box when it's hidden
    if (!internationalRadio.checked) {
      document.getElementById('internationalInstitution').value = '';
    }
    if (!otherRadio.checked) {
      document.getElementById('otherInstitution').value = '';
    }
  }

  // Initial setup
  updateFundingOrganizationVisibility();
  updateInstitutionTextBoxVisibility();

  // Add event listeners to update visibility when the radio buttons are clicked
  supportedYes.addEventListener('change', updateFundingOrganizationVisibility);
  document.getElementById('supportedNo').addEventListener('change', updateFundingOrganizationVisibility);

  // Add event listeners to update visibility for the 'International' and 'Other' text boxes
  document.getElementById('International').addEventListener('change', updateInstitutionTextBoxVisibility);
  document.getElementById('Other').addEventListener('change', updateInstitutionTextBoxVisibility);

  // Add event listeners to update visibility when the funding organization radio buttons are clicked
  const fundingOrganizationRadios = document.getElementsByName('supportingInstitution');
  for (const radio of fundingOrganizationRadios) {
    radio.addEventListener('change', function () {
      universityTextBox.style.display = radio.value === 'University' ? 'block' : 'none';
      tubitakTextBox.style.display = radio.value === 'TUBITAK' ? 'block' : 'none';
      updateInstitutionTextBoxVisibility(); // Call the function to handle 'International' and 'Other' text boxes
    });
  }
});

function handleReportingChangesVisibility() {
  const reportingChangesRadio = document.getElementById("applicationStatusChanges");
  const reportingChangesSection = document.getElementById("reportingChangesSection");

  if (reportingChangesRadio.checked) {
    reportingChangesSection.style.display = "block";
  } else {
    reportingChangesSection.style.display = "none";
  }
}

// Attach the function to the change event of the radio button
document.addEventListener("DOMContentLoaded", function() {
  const reportingChangesRadio = document.getElementById("applicationStatusChanges");
  reportingChangesRadio.addEventListener("change", handleReportingChangesVisibility);

  // Call the function on page load to handle initial visibility
  handleReportingChangesVisibility();
});

document.addEventListener('DOMContentLoaded', function () {
  const otherSpecifyInput = document.getElementById('otherSpecify');
  const typeOfStudyOptions = document.getElementsByName('typeOfStudy');

  function updateOtherSpecifyVisibility() {
    const otherRadioButton = document.getElementById('other');
    if (otherRadioButton.checked) {
      otherSpecifyInput.style.display = 'block';
    } else {
      otherSpecifyInput.style.display = 'none';
    }
  }

  // Initial setup
  updateOtherSpecifyVisibility();

  // Event listeners to update visibility when any radio button in the group is clicked
  for (const option of typeOfStudyOptions) {
    option.addEventListener('change', updateOtherSpecifyVisibility);
  }
});

document.addEventListener('DOMContentLoaded', function () {
  const reportingChangesSection = document.getElementById('reportingChangesSection');
  const applicationStatusOptions = document.getElementsByName('applicationStatus');

  function updateReportingChangesVisibility() {
    const reportingChangesRadioButton = document.getElementById('applicationStatusChanges');
    if (reportingChangesRadioButton.checked) {
      reportingChangesSection.style.display = 'block';
    } else {
      reportingChangesSection.style.display = 'none';
    }
  }

  // Initial setup
  updateReportingChangesVisibility();

  // Event listeners to update visibility when any radio button in the group is clicked
  for (const option of applicationStatusOptions) {
    option.addEventListener('change', updateReportingChangesVisibility);
  }
});

document.addEventListener('DOMContentLoaded', function () {
  const questions11To21Section = document.querySelector('.questions-11-to-21');
  const applicationStatusNew = document.getElementById('applicationStatusNew');
  const applicationStatusRevised = document.getElementById('applicationStatusRevised');
  const applicationStatusExtension = document.getElementById('applicationStatusExtension');
  const applicationStatusChanges = document.getElementById('applicationStatusChanges');
  const reportingChangesSection = document.querySelector('.reporting-changes-section');
  const extensionSection = document.querySelector('.extension-section');

  // Helper function to toggle visibility based on radio button values
  function toggleVisibility() {
    const showQuestions11To21 =
      applicationStatusNew.checked || applicationStatusRevised.checked;
    questions11To21Section.style.display = showQuestions11To21 ? 'block' : 'none';
    
    // Hide the other sections
    const applicationStatusChangesSection = document.querySelector('.application-status-changes-section');
    const applicationStatusExtensionSection = document.querySelector('.application-status-extension-section');
    applicationStatusChangesSection.style.display = 'none';
    applicationStatusExtensionSection.style.display = 'none';

    // Show additional sections if the corresponding radio buttons are checked
    if (applicationStatusChanges.checked) {
      reportingChangesSection.style.display = 'block';
    } else {
      reportingChangesSection.style.display = 'none';
    }

    if (applicationStatusExtension.checked) {
      extensionSection.style.display = 'block';
    } else {
      extensionSection.style.display = 'none';
    }
  }

  // Initial setup
  toggleVisibility();

  // Event listeners to update visibility when the "Status of the application" radio buttons are clicked
  applicationStatusNew.addEventListener('change', toggleVisibility);
  applicationStatusRevised.addEventListener('change', toggleVisibility);
  applicationStatusExtension.addEventListener('change', toggleVisibility);
  applicationStatusChanges.addEventListener('change', toggleVisibility);
});

document.addEventListener('DOMContentLoaded', function () {
  const applicationStatusOptions = document.getElementsByName('applicationStatus');
  const reportingChangesSection = document.querySelector('#reportingChangesSection');
  const extensionSection = document.querySelector('#extensionSection');
  const question11To21 = document.querySelector('#question11To21');

  const participantTypeOtherCheckbox = document.getElementById('participantTypeOther');
  const participantTypeOtherText = document.getElementById('participantTypeOtherText');

  const methodOtherCheckbox = document.getElementById('methodOther');
  const methodOtherText = document.getElementById('methodOtherText');

  function updateVisibility() {
    const selectedStatus = document.querySelector('input[name="applicationStatus"]:checked');

    if (selectedStatus) {
      const statusValue = selectedStatus.value;

      // Handle Question 11 to 21 visibility
      const question11To21Visible = statusValue === 'new' || statusValue === 'revised';
      question11To21.style.display = question11To21Visible ? 'block' : 'none';

      // Handle "Reporting changes" section visibility
      reportingChangesSection.style.display = statusValue === 'changes' ? 'block' : 'none';

      // Handle "Extension" section visibility
      extensionSection.style.display = statusValue === 'extension' ? 'block' : 'none';
    }
  }

  // Handle Other checkbox for question 17
  participantTypeOtherCheckbox.addEventListener('change', function () {
    participantTypeOtherText.style.display = this.checked ? 'block' : 'none';
  });

  // Handle Other checkbox for question 20
  methodOtherCheckbox.addEventListener('change', function () {
    methodOtherText.style.display = this.checked ? 'block' : 'none';
  });

  // Initial setup
  updateVisibility();

  // Event listeners to update visibility
  for (const statusOption of applicationStatusOptions) {
    statusOption.addEventListener('change', updateVisibility);
  }
  function toggleStudyChangesSection() {
    const studyChangesYes = document.getElementById("studyChangesYes");
    const studyChangesSection = document.getElementById("studyChangesSection");

    studyChangesSection.style.display = studyChangesYes.checked ? "block" : "none";
  }

  // Add event listeners to the studyChanges radio buttons
  const studyChangesYes = document.getElementById("studyChangesYes");
  const studyChangesNo = document.getElementById("studyChangesNo");

  studyChangesYes.addEventListener("change", toggleStudyChangesSection);
  studyChangesNo.addEventListener("change", toggleStudyChangesSection);

  // Trigger the toggleStudyChangesSection function initially
  toggleStudyChangesSection();

  function toggleQuestion17To21() {
    const controlGroupYes = document.getElementById("controlGroupYes");
    const question17To21 = document.getElementById("question17To21");

    question17To21.style.display = controlGroupYes.checked ? "block" : "none";
  }

  // Add event listeners to the controlGroup radio buttons
  const controlGroupYes = document.getElementById("controlGroupYes");
  const controlGroupNo = document.getElementById("controlGroupNo");

  controlGroupYes.addEventListener("change", toggleQuestion17To21);
  controlGroupNo.addEventListener("change", toggleQuestion17To21);

  // Trigger the toggleQuestion17To21 function initially
  toggleQuestion17To21();
});

function toggleDescription(formId) {
  const descriptionElement = document.getElementById(`${formId}-description`);
  descriptionElement.classList.toggle('active');
}


function toggleDescription(formId) {
  const descriptionElement = document.getElementById(`${formId}-description`);
  const button = document.querySelector(`button[onclick="toggleDescription('${formId}')"]`);

  if (descriptionElement.style.display === "none") {
    descriptionElement.style.display = "block";
    button.textContent = "Read Less";
  } else {
    descriptionElement.style.display = "none";
    button.textContent = "Read More";
  }
}

// Function to show the selected section when a link is clicked
document.addEventListener("DOMContentLoaded", function() {
  const navLinks = document.querySelectorAll("nav a");

  navLinks.forEach(link => {
    link.addEventListener("click", function(event) {
      event.preventDefault();
      const targetSectionId = this.getAttribute("href").substring(1);
      const targetSection = document.getElementById(targetSectionId);

      // Hide all sections
      const allSections = document.querySelectorAll(".section");
      allSections.forEach(section => {
        section.style.display = "none";
      });

      // Display the selected section
      targetSection.style.display = "block";
    });
  });
});

function logout() {
  // Clear any session data from local storage (if applicable)
  localStorage.clear();

  // Redirect to the login page
  window.location.href = "index.php";
}
document.addEventListener("DOMContentLoaded", function() {
  console.log("DOM loaded");
  
  const backButton = document.getElementById("backButton");
  backButton.addEventListener("click", function() {
            // Use window.history.back() to navigate back
            window.history.back();
  });
        });