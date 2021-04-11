//Set user's focus to the activity selection dropdown upon loading the page
function focusActivity() {
  document.activityInput.activity.focus();   	 
}

//Code for welcome message using anonymous function
//var welcomeUser = (function(){
  //document.addEventListener("load", alert("Welcome back Akbar!"));
//}());

//Inspired by an example from Upsorn Praphamontripong: http://www.cs.virginia.edu/~up3f/cs4640/examples/js/form-enhancement/template/validate-int.html
//Code to validate types of Time Spent and Distance input fields
function isInt(str){
  var val = parseInt(str);
  return (val > 0);
}

function validateInputTypes(){

  var timeSpent = document.getElementById("activity-time-spent");
  if (!isInt(timeSpent.value)){
    alert("Time Spent must be inputted as an integer");
    //Delete improper input in Time Spent and Distance fields
    document.getElementById("activity-time-spent").value = "";
    document.getElementById("activity-distance").value = "";
    return false;
  } 

  var distance = document.getElementById("activity-distance")
  if (!isInt(distance.value)){
    alert("Distance must be inputted as an integer");
    //Delete improper input in Time Spent and Distance fields
    document.getElementById("activity-time-spent").value = "";
    document.getElementById("activity-distance").value = "";
    return false;
  }               
}


//Code to add inputted data to below summary table
//Inspired by an example from Upsorn Praphamontripong: http://www.cs.virginia.edu/~up3f/cs4640/examples/js/add-rows-to-table.html
function logActivity() {
  var date = document.getElementById("activity-date");
  console.log(date);
  var time = document.getElementById("activity-time");
  var timeFormat = "";
  if (time.value.charAt(0) == '0'){
    timeFormat = time.value.slice(1);
  }
  else{
    timeFormat = time.value;
  }
  var activity = document.getElementById("activity");
  //Uppercase the activity
  var activityUppercase = activity.value.charAt(0).toUpperCase() + activity.value.slice(1);
  var distance = document.getElementById("activity-distance");
  var timeSpent = document.getElementById("activity-time-spent");
  var comments = document.getElementById("activity-comments");
  
  var activityData = [date.value, timeFormat + "pm", activityUppercase, distance.value + " miles", "512 calories"];
  var tableRef = document.getElementById("workout-table");
  var newRow = tableRef.insertRow(tableRef.rows.length);

  //Do not insert if values are null
  if(date.value == "" || time.value == "" || activity.value == "" || distance.value == "" || timeSpent.value == ""){
    return;
  }

  //Do not insert if Time Spent and Distance are not Integers
  if(isInt(distance.value) == false || isInt(timeSpent.value) == false){
    return;
  }

  var newCell = "";       
  var i = 0;         
  // Use insertCell(index) method to insert new cells (<td> elements) at the 1st, 2nd, 3rd position of the new <tr> element        	      
  while (i < 5)
  {
    newCell = newRow.insertCell(i);            
    newCell.innerHTML = activityData[i];    
    newCell.onmouseover = this.rowIndex; 
    i++;
  }

  //Clear input fields after succesfull submission
  document.getElementById("activity-date").value = "";
  document.getElementById("activity-time").value = "";
  document.getElementById("activity").value = "";
  document.getElementById("activity-time-spent").value = "";
  document.getElementById("activity-distance").value = "";
  document.getElementById("activity-comments").value = "";
}


//Functions to show/hide table on button press
//Code with help from: https://www.roseindia.net/javascript/javascriptexamples/javascript-show-hide-table.shtml
function showTable(){
  document.getElementById('workout-table').style.visibility = "visible";
}
function hideTable(){
  document.getElementById('workout-table').style.visibility = "hidden";
}

//Event Listeners to trigger functions
document.getElementById("input-button").addEventListener("click", validateInputTypes);
document.getElementById("input-button").addEventListener("click", logActivity);
document.getElementById("show-button").addEventListener("click", showTable);
document.getElementById("hide-button").addEventListener("click", hideTable);