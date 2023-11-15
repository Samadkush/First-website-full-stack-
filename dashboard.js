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
        if (link.getAttribute('href') === 'form1.php' || link.getAttribute('href') === 'form2.php') {
          // Load the form content when clicking on the respective links
          loadExternalContent(link.getAttribute('href'), targetSectionID);
        } else {
          hideAllSections();
          showSection(targetSectionID);
          currentSection = targetSectionID;
        }
      }
    });
  });

  // On page load, check if the applications section should be visible
  var applicationsSection = document.getElementById("Application-status");
  var isSectionVisible = sessionStorage.getItem("applicationsVisible");

  if (isSectionVisible === "true" && currentSection !== 'home-section') {
    hideAllSections();
    showSection('Application-status');
  }
});

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

function loadExternalContent(targetFile, targetSectionID) {
  // You can handle the dynamic loading of content here, for example, redirect to the URL
  window.location.href = targetFile;
}

function logout() {
  // Clear any session data from local storage (if applicable)
  localStorage.clear();

  // Redirect to the index.php page (you may adjust the URL as needed)
  window.location.href = "index.php";
}
