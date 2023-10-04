let newRequestCount = 0;
let approvedCount = 0;
let awaitingRevisionCount = 0;

// Function to update the counters based on application status
function updateCounters(status) {
  if (status === "new") {
    newRequestCount++;
  } else if (status === "approved") {
    approvedCount++;
  } else if (status === "revision") {
    awaitingRevisionCount++;
  }

  document.getElementById("newRequestCount").textContent = newRequestCount;
  document.getElementById("approvedCount").textContent = approvedCount;
  document.getElementById("awaitingRevisionCount").textContent = awaitingRevisionCount;
}

// Function to update the status text based on the selected value
function updateStatusText(selectElement) {
  const selectedStatus = selectElement.value;
  const statusContainer = selectElement.closest(".status-container");
  const statusTextElement = statusContainer.querySelector(".status-text");
  statusTextElement.textContent = selectedStatus.charAt(0).toUpperCase() + selectedStatus.slice(1);

  // Update counters based on the selected status
  updateCounters(selectedStatus);
}

function generateNextAppNo() {
  let lastAppNo = localStorage.getItem("lastAppNo");
  let currentDate = new Date();
  let currentYear = currentDate.getFullYear().toString();
  let currentMonth = (currentDate.getMonth() + 1).toString().padStart(2, "0");

  if (!lastAppNo || !lastAppNo.startsWith(currentYear + currentMonth)) {
    // If lastAppNo is not available or not for the current month, start with 00
    lastAppNo = currentYear + currentMonth + "00";
  }

  let incrementedNumber = (parseInt(lastAppNo.slice(-2)) + 1).toString().padStart(2, "0");
  let nextAppNo = currentYear + currentMonth + incrementedNumber;

  // Save the nextAppNo in local storage for future use
  localStorage.setItem("lastAppNo", nextAppNo);

  return nextAppNo;
}

function setAppNo() {
  const appNoElement = document.getElementById("appNo");
  const nextAppNo = generateNextAppNo();
  appNoElement.textContent = nextAppNo;
}


// Function to set the saved status from local storage on page load
function setSavedStatus() {
  const statusElements = document.querySelectorAll(".status");
  statusElements.forEach((selectElement) => {
    const appNo = selectElement.closest("tr").querySelector("td:first-child").textContent;
    const savedStatus = localStorage.getItem(`status_${appNo}`);
    if (savedStatus) {
      selectElement.value = savedStatus;
      updateStatusText(selectElement);
    }
  });
}

// Function to update the status text based on the selected value
function updateStatusText(selectElement) {
  const selectedStatus = selectElement.value;
  const statusContainer = selectElement.closest(".status-container");
  statusContainer.querySelector(".status-text").textContent = selectedStatus.charAt(0).toUpperCase() + selectedStatus.slice(1);
}

// Function to handle the status change event
function changeStatus(selectElement) {
  updateStatusText(selectElement);
}

// Function to toggle the edit status mode
function toggleEditStatus(button) {
  const statusContainer = button.closest(".status-container");
  const editButton = statusContainer.querySelector(".edit-btn");
  const statusSelect = statusContainer.querySelector(".status");
  const statusEdit = statusContainer.querySelector(".status-edit");

  if (statusSelect.disabled) {
    // Enable the select menu
    statusSelect.disabled = false;
    editButton.textContent = "Save";
  } else {
    // Disable the select menu and save the status
    statusSelect.disabled = true;
    editButton.textContent = "Edit";
    const selectedStatus = statusSelect.value;
    updateStatusText(statusSelect);
    const appNo = statusSelect.closest("tr").querySelector("td:first-child").textContent;
    localStorage.setItem(`status_${appNo}`, selectedStatus);
  }
}

// Function to handle the row deletion
function deleteRow(button) {
  // Add the delete functionality here, e.g., removing the table row from the DOM or sending a request to the server to delete the record.
  // For example, you can use the following to remove the table row from the DOM:
  const row = button.closest("tr");
  row.remove();
}
function handleStatusChange(selectElement) {
  const formId = selectElement.closest("tr").querySelector("td:first-child").textContent;
  const newStatus = selectElement.value;

  // Make an AJAX request to update the status on the server
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "applications.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        // Output success message to the console for debugging
        console.log("Status Update Successful");

        // Optionally, you can refresh the page after the status is updated
        // to reflect the changes in the UI
        location.reload();
      } else {
        // Output error message to the console for debugging
        console.log("Error updating status:", xhr.status, xhr.statusText);
      }
    }
  };
  const params = "form_id=" + encodeURIComponent(formId) + "&status=" + encodeURIComponent(newStatus);
  xhr.send(params);
}

// Add event listeners for status change
const statusSelectElements = document.querySelectorAll('.status');
statusSelectElements.forEach((selectElement) => {
  selectElement.addEventListener('change', () => {
    handleStatusChange(selectElement);
  });
});



// Call setSavedStatus() on page load to set the saved status values
setSavedStatus();
document.addEventListener("DOMContentLoaded", function () {
  setAppNo();
});


// Add event listeners for status change

xhr.onreadystatechange = function () {
  if (xhr.readyState === 4) {
      if (xhr.status === 200) {
          // Output success message to the console for debugging
          console.log("Status Update Successful");

          // Update the status text in the UI
          updateStatusText(selectElement);
      } else {
          // Output error message to the console for debugging
          console.log("Error updating status:", xhr.status, xhr.statusText);
      }
  }
};
function filterByStatus(selectElement) {
  const selectedStatus = selectElement.value;
  console.log("Selected status:", selectedStatus); // Debug line
  const allRows = document.querySelectorAll("#applications tbody tr");

  allRows.forEach(row => {
      const statusContainer = row.querySelector(".status-container");
      const statusSelect = statusContainer.querySelector("select"); // Find the <select> element within the container
      console.log("Row status:", statusSelect.value); // Debug line

      if (selectedStatus === "all" || statusSelect.value === selectedStatus) {
          row.style.display = "table-row";
      } else {
          row.style.display = "none";
      }
  });
}

