//Hide the element on load
document.getElementById("form_add_machine").style.display = "none"

//Toggle the add form
function toggleForm() {
  var x = document.getElementById("form_add_machine");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}