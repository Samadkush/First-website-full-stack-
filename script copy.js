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

// Call setSavedStatus() on page load to set the saved status values
setSavedStatus();
