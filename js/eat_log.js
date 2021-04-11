//Code for welcome message using anonymous function
//var welcomeUser = (function(){
    //document.addEventListener("load", alert("Welcome back Akbar!"));
//}());

//Inspired by an example from Upsorn Praphamontripong: http://www.cs.virginia.edu/~up3f/cs4640/examples/js/form-enhancement/template/validate-int.html
//Code to validate types of Calories and Sugar input fields
function isInt(str){
    var val = parseInt(str);
    return (val > 0);
}

function validateInputTypes(){
//Validate input on the calories and sugar text fields
var calories = document.getElementById("eat-calories");
if (!isInt(calories.value)){
    alert("Calories must be inputted as an integer")
    //Delete improper input in Calories and Sugar fields
    document.getElementById("eat-calories").value = "";
    document.getElementById("eat-sugar").value = "";
    return false
} 

var sugar = document.getElementById("eat-sugar")
if (!isInt(sugar.value)){
    alert("Grams of sugar must be inputted as an integer")
    //Delete improper input in Calories and Sugar fields
    document.getElementById("eat-calories").value = "";
    document.getElementById("eat-sugar").value = "";
    return false
} 
}

//Code to add inputted data to below summary table, anonymous function
//Inspired by an example from Upsorn Praphamontripong: http://www.cs.virginia.edu/~up3f/cs4640/examples/js/add-rows-to-table.html
var logMeal = function() {
var date = document.getElementById("eat-date");
var time = document.getElementById("eat-time");
var timeFormat = "";
if (time.value.charAt(0) == '0'){
    timeFormat = time.value.slice(1);
}
else{
    timeFormat = time.value;
}
var meal = document.getElementById("meal");
//Uppercase the meal name
var mealUppercase = meal.value.charAt(0).toUpperCase() + meal.value.slice(1);
var calories = document.getElementById("eat-calories");
var sugar = document.getElementById("eat-sugar");
var comments = document.getElementById("eat-comments");

var eatData = [date.value, timeFormat + "pm", mealUppercase, calories.value + " calories", sugar.value + " grams", comments.value];
var tableRef = document.getElementById("eat-table");
var newRow = tableRef.insertRow(tableRef.rows.length);

//Do not insert if values are null
if(date.value == "" || time.value == "" || calories.value == "" || sugar.value == "" || meal.value == "" || comments.value == ""){
    return;
}

//Do not insert if sugar and calories are not Integers
if(isInt(sugar.value) == false || isInt(calories.value) == false){
    return;
}

var newCell = "";       
var i = 0;              	      
while (i < 6)
{
    newCell = newRow.insertCell(i);            
    newCell.innerHTML = eatData[i];    
    newCell.onmouseover = this.rowIndex; 
    i++;
}

//Clear input fields after submission
    document.getElementById("eat-date").value = "";
    document.getElementById("eat-time").value = "";
    document.getElementById("meal").value = "";
    document.getElementById("eat-calories").value = "";
    document.getElementById("eat-sugar").value = "";
    document.getElementById("eat-comments").value = "";
}


//Functions to show/hide table on button press
//Code with help from: https://www.roseindia.net/javascript/javascriptexamples/javascript-show-hide-table.shtml
function showTable(){
    document.getElementById('eat-table').style.visibility = "visible";
}
function hideTable(){
    document.getElementById('eat-table').style.visibility = "hidden";
}

//Event Listeners to trigger functions
document.getElementById("input-button").addEventListener("click", validateInputTypes);
document.getElementById("input-button").addEventListener("click", logMeal);
document.getElementById("show-button").addEventListener("click", showTable);
document.getElementById("hide-button").addEventListener("click", hideTable);