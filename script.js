document.addEventListener('DOMContentLoaded', function () {
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

    // Add more validations for other required fields if necessary

    alert('Ethics Committee Application Form submitted successfully!');
    return true;
  }

  function updateAdvisorSectionVisibility() {
    let showAdvisor = false;

    for (const option of typeOfStudyOptions) {
      if (option.checked && (option.value === 'masterThesis' || option.value === 'undergraduate')) {
        showAdvisor = true;
        break;
      }
    }

    advisorSection.style.display = showAdvisor ? 'block' : 'none';
  }

  function updateTextareaVisibility() {
    externalOrganizationDetails.style.display = externalOrganizationYes.checked ? 'block' : 'none';
  }

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
      document.getElementById('universityInstitution').value = '';
      document.getElementById('tubitakInstitution').value = '';
      document.getElementById('internationalInstitution').value = '';
      document.getElementById('otherInstitution').value = '';
    }
  }

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

  function handleReportingChangesVisibility() {
    reportingChangesSection.style.display = reportingChangesRadio.checked ? "block" : "none";
  }

  function updateOtherSpecifyVisibility() {
    otherSpecifyInput.style.display = otherRadio.checked ? 'block' : 'none';
  }
  function toggleQuestions11To21() {
    const showQuestions11To21 = applicationStatusNew.checked || applicationStatusRevised.checked;
    questions11To21Section.style.display = showQuestions11To21 ? 'block' : 'none';
  }
  
  // Initial setup
  toggleQuestions11To21();
  
  // Event listeners to update visibility when the "Status of the application" radio buttons are clicked
  applicationStatusNew.addEventListener('change', toggleQuestions11To21);
  applicationStatusRevised.addEventListener('change', toggleQuestions11To21);

  function updateVisibility() {
    const selectedStatus = document.querySelector('input[name="applicationStatus"]:checked');

    if (selectedStatus) {
      const statusValue = selectedStatus.value;

      question11To21.style.display = statusValue === 'new' || statusValue === 'revised' ? 'block' : 'none';

      reportingChangesSection.style.display = statusValue === 'changes' ? 'block' : 'none';

      extensionSection.style.display = statusValue === 'extension' ? 'block' : 'none';
    }
  }

  function toggleStudyChangesSection() {
    studyChangesSection.style.display = studyChangesYes.checked ? "block" : "none";
  }

  function toggleQuestion17To21() {
    question17To21.style.display = controlGroupYes.checked ? "block" : "none";
  }

  function toggleDescription(formId) {
    const descriptionElement = document.getElementById(`${formId}-description`);
    descriptionElement.style.display = descriptionElement.style.display === 'none' ? 'block' : 'none';
  }

  ethicsForm.addEventListener('submit', validateForm);

  otherRadio.addEventListener('change', function () {
    otherSpecifyInput.style.display = otherRadio.checked ? 'block' : 'none';
  });

  numResearchersSelect.addEventListener('change', function () {
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
    radio.addEventListener('change', function () {
      universityTextBox.style.display = radio.value === 'University' ? 'block' : 'none';
      tubitakTextBox.style.display = radio.value === 'TUBITAK' ? 'block' : 'none';
      updateInstitutionTextBoxVisibility();
    });
  }

  reportingChangesRadio.addEventListener("change", handleReportingChangesVisibility);

  for (const option of applicationStatusOptions) {
    option.addEventListener('change', updateVisibility);
  }

  studyChangesYes.addEventListener("change", toggleStudyChangesSection);
  studyChangesNo.addEventListener("change", toggleStudyChangesSection);

  controlGroupYes.addEventListener("change", toggleQuestion17To21);
  controlGroupNo.addEventListener("change", toggleQuestion17To21);

  const navLinks = document.querySelectorAll("nav a");

  navLinks.forEach(link => {
    link.addEventListener("click", function(event) {
      event.preventDefault();
      const targetSectionId = this.getAttribute("href").substring(1);
      const targetSection = document.getElementById(targetSectionId);

      const allSections = document.querySelectorAll(".section");
      allSections.forEach(section => {
        section.style.display = "none";
      });

      targetSection.style.display = "block";
    });
  });
});
