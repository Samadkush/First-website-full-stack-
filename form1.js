document.addEventListener('DOMContentLoaded', () => {
    const ethicsForm = document.getElementById('ethicsForm');
    const otherRadio = document.getElementById('other');
    const otherSpecifyInput = document.getElementById('otherSpecify');
    const numResearchersSelect = document.getElementById('numResearchers');
    const researchersContainer = document.querySelector('.researchers-container');
    const advisorSection = document.getElementById('advisorSection');
    const typeOfStudyOptions = document.getElementsByName('typeOfStudy');
    const externalOrganizationYes = document.getElementById('externalOrganizationYes');
    const externalOrganizationDetails = document.getElementById('externalOrganizationDetails');
    const supportedYes = document.getElementById('supportedYes');
    const fundingOrganizationSection = document.getElementById('fundingOrganizationSection');
    const universityTextBox = document.getElementById('universityTextBox');
    const tubitakTextBox = document.getElementById('tubitakTextBox');
    const internationalTextBox = document.getElementById('internationalTextBox');
    const otherTextBox = document.getElementById('otherTextBox');
    const applicationStatusOptions = document.getElementsByName('applicationStatus');
    const reportingChangesSection = document.getElementById('reportingChangesSection');
    const extensionSection = document.getElementById('extensionSection');
    const question11To21 = document.getElementById('question11To21');
    const participantTypeOtherCheckbox = document.getElementById('participantTypeOther');
    const participantTypeOtherText = document.getElementById('participantTypeOtherText');
    const methodOtherCheckbox = document.getElementById('methodOther');
    const methodOtherText = document.getElementById('methodOtherText');
    const studyChangesYes = document.getElementById("studyChangesYes");
    const studyChangesSection = document.getElementById("studyChangesSection");
    const controlGroupYes = document.getElementById("controlGroupYes");
    const question17To21 = document.getElementById("question17To21");
    const questions11To21Section = document.getElementById('question11To21');
  
    const validateForm = (event) => {
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
  
      if (researcherNameInput.value.trim() === '') {
        alert('Please enter your name and surname.');
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
  
      alert('Ethics Committee Application Form submitted successfully!');
      return true;
    };
  
    const updateAdvisorSectionVisibility = () => {
      const showAdvisor = Array.from(typeOfStudyOptions).some(option => 
        option.checked && (option.value === 'masterThesis' || option.value === 'undergraduate')
      );
  
      advisorSection.style.display = showAdvisor ? 'block' : 'none';
    };
  
    const updateTextareaVisibility = () => {
      externalOrganizationDetails.style.display = externalOrganizationYes.checked ? 'block' : 'none';
    };
  
    const updateFundingOrganizationVisibility = () => {
      const fundingOrganizationRadios = document.getElementsByName('supportingInstitution');
      const selectedSupported = supportedYes.checked;
  
      if (selectedSupported) {
        fundingOrganizationSection.style.display = 'block';
      } else {
        fundingOrganizationSection.style.display = 'none';
        for (const radio of fundingOrganizationRadios) {
          radio.checked = false;
        }
        document.getElementById('universityInstitution').value = '';
        document.getElementById('tubitakInstitution').value = '';
        document.getElementById('internationalInstitution').value = '';
        document.getElementById('otherInstitution').value = '';
      }
    };
  
    const updateInstitutionTextBoxVisibility = () => {
      const internationalRadio = document.getElementById('International');
      const otherRadio = document.getElementById('Other');
  
      internationalTextBox.style.display = internationalRadio.checked ? 'block' : 'none';
      otherTextBox.style.display = otherRadio.checked ? 'block' : 'none';
  
      if (!internationalRadio.checked) {
        document.getElementById('internationalInstitution').value = '';
      }
      if (!otherRadio.checked) {
        document.getElementById('otherInstitution').value = '';
      }
    };
  
    const handleReportingChangesVisibility = () => {
      reportingChangesSection.style.display = reportingChangesRadio.checked ? "block" : "none";
    };
  

  // Function to update visibility based on the selected application status
// Function to update visibility based on the selected application status
const updateVisibility = () => {
  const selectedStatus = document.querySelector('input[name="applicationStatus"]:checked');
  const question11To21Section = document.getElementById('question11To21');

  // Set the visibility of question11To21 based on the selected status
  question11To21Section.style.display = (selectedStatus && (selectedStatus.value === 'new' || selectedStatus.value === 'revised')) ? 'block' : 'none';

  // Set the visibility of reportingChangesSection based on the selected status
  reportingChangesSection.style.display = (selectedStatus && selectedStatus.value === 'changes') ? 'block' : 'none';

  // Set the visibility of extensionSection based on the selected status
  extensionSection.style.display = (selectedStatus && selectedStatus.value === 'extension') ? 'block' : 'none';
};

// Set the initial visibility of question11To21 to 'none'
document.getElementById('question11To21').style.display = 'none';

// Event listener to update visibility when the "Status of the application" radio buttons are clicked
document.querySelectorAll('input[name="applicationStatus"]').forEach(input => {
  input.addEventListener('change', updateVisibility);
});

// Initial call to set visibility based on the default selected status (if any)
updateVisibility();
  
    const toggleQuestion17To21 = () => {
      question17To21.style.display = controlGroupYes.checked ? "block" : "none";
    };
  
    const toggleDescription = (formId) => {
      const descriptionElement = document.getElementById(`${formId}-description`);
      descriptionElement.style.display = descriptionElement.style.display === 'none' ? 'block' : 'none';
    };
  
    ethicsForm.addEventListener('submit', validateForm);
  
    otherRadio.addEventListener('change', () => {
      otherSpecifyInput.style.display = otherRadio.checked ? 'block' : 'none';
    });
  
    numResearchersSelect.addEventListener('change', () => {
      const numResearchers = parseInt(numResearchersSelect.value, 10);
      researchersContainer.innerHTML = '';
  
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
        nameInstitutionDiv.classList.add('name-input');
        nameInstitutionDiv.appendChild(nameInput);
        nameInstitutionDiv.appendChild(institutionLabel);
        nameInstitutionDiv.appendChild(institutionInput);
  
        researcherDiv.appendChild(nameLabel);
        researcherDiv.appendChild(nameInstitutionDiv);
  
        researchersContainer.appendChild(researcherDiv);
      }
    });
  
    updateAdvisorSectionVisibility();
  
    for (const option of typeOfStudyOptions) {
      option.addEventListener('change', updateAdvisorSectionVisibility);
    }
  
    updateTextareaVisibility();
  
    externalOrganizationYes.addEventListener('change', updateTextareaVisibility);
    document.getElementById('externalOrganizationNo').addEventListener('change', updateTextareaVisibility);
  
    supportedYes.addEventListener('change', updateFundingOrganizationVisibility);
    document.getElementById('supportedNo').addEventListener('change', updateFundingOrganizationVisibility);
  
    document.getElementById('International').addEventListener('change', updateInstitutionTextBoxVisibility);
    document.getElementById('Other').addEventListener('change', updateInstitutionTextBoxVisibility);
  
    const fundingOrganizationRadios = document.getElementsByName('supportingInstitution');
    for (const radio of fundingOrganizationRadios) {
      radio.addEventListener('change', () => {
        universityTextBox.style.display = radio.value === 'University' ? 'block' : 'none';
        tubitakTextBox.style.display = radio.value === 'TUBITAK' ? 'block' : 'none';
        updateInstitutionTextBoxVisibility();
      });
    }
  
    reportingChangesSection.addEventListener("change", handleReportingChangesVisibility);
  
    for (const option of applicationStatusOptions) {
      option.addEventListener('change', updateVisibility);
    }
    const toggleStudyChangesSection = () => {
      studyChangesSection.style.display = studyChangesYes.checked ? "block" : "none";
  };

    studyChangesYes.addEventListener("change", toggleStudyChangesSection);
    studyChangesNo.addEventListener("change", toggleStudyChangesSection);
  
    controlGroupYes.addEventListener("change", toggleQuestion17To21);
    controlGroupNo.addEventListener("change", toggleQuestion17To21);
  
    const navLinks = document.querySelectorAll("nav a");
  
    navLinks.forEach(link => {
      link.addEventListener("click", (event) => {
        event.preventDefault();
        const targetSectionId = link.getAttribute("href").substring(1);
        const targetSection = document.getElementById(targetSectionId);
  
        const allSections = document.querySelectorAll(".section");
        allSections.forEach(section => {
          section.style.display = "none";
        });
  
        targetSection.style.display = "block";
      });
    });
  });