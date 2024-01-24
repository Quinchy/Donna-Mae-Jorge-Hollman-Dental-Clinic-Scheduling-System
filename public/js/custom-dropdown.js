const selectedAll = document.querySelectorAll(".wrapper-dropdown");

selectedAll.forEach((selected) => {
  const optionsContainer = selected.children[2];
  const optionsList = selected.querySelectorAll("div.wrapper-dropdown li");

  selected.addEventListener("click", () => {
    let arrow = selected.children[1];

    if (selected.classList.contains("active")) {
      handleDropdown(selected, arrow, false);
    } else {
      let currentActive = document.querySelector(".wrapper-dropdown.active");

      if (currentActive) {
        let anotherArrow = currentActive.children[1];
        handleDropdown(currentActive, anotherArrow, false);
      }

      handleDropdown(selected, arrow, true);
    }
  });

  // update the display of the dropdown
  for (let o of optionsList) {
    o.addEventListener("click", () => {
      selected.querySelector(".selected-display").innerHTML = o.innerHTML;
    });
  }
});

// check if anything else ofther than the dropdown is clicked
window.addEventListener("click", function (e) {
  if (e.target.closest(".wrapper-dropdown") === null) {
    closeAllDropdowns();
  }
});

// close all the dropdowns
function closeAllDropdowns() {
  const selectedAll = document.querySelectorAll(".wrapper-dropdown");
  selectedAll.forEach((selected) => {
    const optionsContainer = selected.children[2];
    let arrow = selected.children[1];

    handleDropdown(selected, arrow, false);
  });
}

// open all the dropdowns
function handleDropdown(dropdown, arrow, open) {
  if (open) {
    arrow.classList.add("rotated");
    dropdown.classList.add("active");
  } else {
    arrow.classList.remove("rotated");
    dropdown.classList.remove("active");
  }
}

// Listen for document ready to initialize everything
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Flatpickr on the calendar input
    const calendar = flatpickr("#calendar", {
        enableTime: false,
        dateFormat: "Y-m-d",
        inline: true,
        onChange: function(selectedDates, dateStr, instance) {
            // When a date is selected, fetch the time slots for that date
            fetchTimeSlotsForDate(dateStr);
        }
    });
});

// Function to perform AJAX and update dropdown
function fetchTimeSlotsForDate(date) {
    $.ajax({
        url: '/fetch-time-slots', // Replace with the actual URL to your PHP script
        type: 'GET',
        data: { 'date': date },
        success: function(response) {
            // Assuming response is an array of time slots
            // Update the dropdown with these time slots
            updateTimeSlotDropdown(response);
        },
        error: function(xhr, status, error) {
            // Handle any errors here, such as showing an error message
        }
    });
}

// Function to update time slot dropdown with new options
function updateTimeSlotDropdown(timeSlots) {
    const dropdown = document.getElementById('timeSlotDropdown');
    dropdown.innerHTML = ''; // Clear existing options

    // Create a default option
    let defaultOption = document.createElement('option');
    defaultOption.textContent = "Select a time slot";
    defaultOption.value = "";
    dropdown.appendChild(defaultOption);

    // Add new time slot options from the response
    timeSlots.forEach(function(slot) {
        let option = document.createElement('option');
        option.value = slot.id; // Use your actual identifier for time slots
        option.textContent = slot.time; // Adjust based on how you want to display time slots
        dropdown.appendChild(option);
    });
}