// Get the necessary elements
var decreaseBtn = document.getElementById("decreaseBtn");
var increaseBtn = document.getElementById("increaseBtn");
var countElement = document.getElementById("count");
var form = document.getElementById("myForm");

// Set the initial count value
var count = 1;

// Event listener for the decrease button
decreaseBtn.addEventListener("click", function (event) {
  event.preventDefault(); // Prevent form submission
  if (count > 1) {
    count--; // Decrease the count value by 1
    countElement.textContent = count; // Update the count element with the new value
  }
});

// Event listener for the increase button
increaseBtn.addEventListener("click", function (event) {
  event.preventDefault(); // Prevent form submission
  count++; // Increase the count value by 1
  countElement.textContent = count; // Update the count element with the new value
});

// Event listener for form submission
form.addEventListener("submit", function (event) {
  event.preventDefault(); // Prevent default form submission
  // You can perform additional actions here if needed
});
