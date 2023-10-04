document.addEventListener("DOMContentLoaded", function () {
  // Initially hide all sections except "home-section"
  hideAllSections();
  showSection('home-section');

  // Variable to track the current section
  var currentSection = 'home-section';

  function hideAllSections() {
    var sections = document.querySelectorAll('.section');
    sections.forEach(function (section) {
      section.style.display = 'none';
    });
  }

  function showSection(sectionId) {
    var selectedSection = document.getElementById(sectionId);
    if (selectedSection) {
      selectedSection.style.display = 'block';
    }
  }
  var form1Link = document.querySelector('nav ul li a[href="form1.php"]');
  var form2Link = document.querySelector('nav ul li a[href="form2.php"]');

  if (form1Link) {
    form1Link.addEventListener("click", function (event) {
      event.preventDefault();
      loadFormContent("form1.php");
    });
  }

  if (form2Link) {
    form2Link.addEventListener("click", function (event) {
      event.preventDefault();
      loadFormContent("form2.php");
    });
  }
  // Add event listeners to all navigation links
  var navigationLinks = document.querySelectorAll('nav ul li a');
  navigationLinks.forEach(function (link) {
    link.addEventListener("click", function (event) {
      event.preventDefault();
      var targetSectionID = link.getAttribute('href').substr(1);

      if (targetSectionID === currentSection) {
        // Toggle between "home-section" and "Application Status"
        hideAllSections();
        showSection('Application-status');
        currentSection = 'Application-status';
      } else {
        if (link.getAttribute('href') === '#form2.php') {
          var navBar = document.querySelector('nav');
          navBar.classList.add('fixed-width');
          var header = document.querySelector('header');
          header.classList.remove('white-text');
          header.classList.add('black-text');
        }

        hideAllSections();
        showSection(targetSectionID);
        currentSection = targetSectionID;
      }
    });
  });

  // Add event listeners to all accordion buttons
  var accordionButtons = document.querySelectorAll('.accordion-btn');
  accordionButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      var description = document.getElementById(button.dataset.description);
      if (description.style.display === 'block') {
        description.style.display = 'none';
      } else {
        description.style.display = 'block';
      }
    });
  });

  

  // Add event listeners to all accordion buttons
  var accordionButtons = document.querySelectorAll('.accordion-btn');
  accordionButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      // Get the corresponding description element
      var description = document.getElementById(button.dataset.description);

      // Toggle the visibility of the description
      if (description.style.display === 'block') {
        description.style.display = 'none';
      } else {
        description.style.display = 'block';
      }
    });
  });
});

function showHomeSection() {
  // Hide all other sections and descriptions
  hideAllSections();
  hideAllDescriptions();

  // Show the Home section
  var homeSection = document.getElementById('home-section');
  homeSection.style.display = 'block';
}
function hideAllDescriptions() {
  // Hide all descriptions
  var descriptions = document.querySelectorAll('.description');
  descriptions.forEach(function(description) {
    description.style.display = 'none';
  });
}
function toggleApplicationsSection() {
  var applicationsSection = document.getElementById('Application-status');
  if (applicationsSection.style.display === 'none') {
    applicationsSection.style.display = 'block';
  } else {
    applicationsSection.style.display = 'none';
  }
}
// On page load, check if the applications section should be visible
document.addEventListener("DOMContentLoaded", function() {
  var applicationsSection = document.getElementById("applications");
  var isSectionVisible = sessionStorage.getItem("applicationsVisible");

  if (isSectionVisible === "true") {
      applicationsSection.style.display = "block";
  }
});

function editForm(formId, formType) {
  window.location.href = `edit_form.php?form_id=${formId}&type=${encodeURIComponent(formType)}`;
}
function deleteForm(formId) {
  // Display a confirmation dialog to confirm the deletion
  if (confirm("Are you sure you want to delete this form?")) {
      // If confirmed, redirect to the delete_form.php page with the form_id as a parameter
      window.location.href = "delete_form.php?form_id=" + formId;
  }

  
}
function logout() {
  // Clear any session data from local storage (if applicable)
  localStorage.clear();

  // Redirect to the index.php page
  window.location.href = "index.php";
}
function loadExternalContent(targetFile, targetSectionID) {
  // Make an AJAX request to load the external content
  fetch(targetFile)
    .then(function (response) {
      return response.text();
    })
    .then(function (content) {
      // Display the external content in the content-container
      var contentContainer = document.getElementById('content-container');
      contentContainer.innerHTML = content;

      // Hide all sections except the loaded one
      hideAllSections();
      showSection(targetSectionID);
    })
    .catch(function (error) {
      console.error('Error loading external content:', error);
    });
}

// Function to hide all sections
function hideAllSections() {
  var sections = document.querySelectorAll('.section');
  sections.forEach(function (section) {
    section.style.display = 'none';
  });
}

// Function to show a specific section
function showSection(sectionId) {
  var selectedSection = document.getElementById(sectionId);
  if (selectedSection) {
    selectedSection.style.display = 'block';
  }
}
function loadFormContent(formPage) {
  fetch(formPage)
    .then(function (response) {
      return response.text();
    })
    .then(function (content) {
      // Display the form content in the container
      var formContentContainer = document.getElementById('form-content-container');
      formContentContainer.innerHTML = content;
    })
    .catch(function (error) {
      console.error('Error loading form content:', error);
    });
}

