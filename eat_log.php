<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Ben Phillips and Read Schlomer">
  <meta name="description" content="Eating Log screen for the activity tracker webapp">  
  
  <title>Eating Log</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous"> 
  <link rel="stylesheet" type="text/css" href="./styles/eatlogstylesheet.css" />

  <!--Styling Rules in the HTML doc-->
  <style>
    /* change table body text color to black*/
    tbody{
      color: black;
    }

    /* change table body text color to orangered on hover*/
    tbody:hover{
      color:orangered;
    }

    /* Change color of last column to white (works in inputted tables as well) */
    table td:nth-child(6)
    {
      color:white;
    }

  </style>

</head>

<body>
<?php session_start(); ?>
<?php if (isset($_SESSION['user']))
{
?>
<?php require('connect-db.php'); ?>

<?php 
  function query_database(){

    global $db;
    $query = "SELECT * FROM Eat_Log WHERE User=:user ORDER BY Date DESC";

    $statement = $db->prepare($query); //Compile string query into executable version
    
    $user = $_SESSION['user'];
    $statement->bindParam(':user', $user);

    $statement->execute();

    $output = $statement->fetchAll();  //Returns an array of all row from execution
    $count = 0;
    foreach ($output as $row){
      if ($count < 5)
      {
        ?><tr>
            <td><?php echo $row['Date']; ?></td>
            <td><?php echo $row['Time']; ?>pm</td>
            <td><?php echo $row['Meal']; ?></td>
            <td><?php echo $row['Calories']; ?> calories</td>
            <td><?php echo $row['Sugar']; ?> grams</td>
            <td><?php echo $row['Comments']; ?></td>
            </tr>
            <?php  
            $count = $count + 1; 
          }
        }
    $statement->closeCursor();
  }
?>

<?php
  function insertData()
{   
	global $db;
    //Input validation, ensure user cannot input null fields into database 
    //Also used htmlspecialchars to prevent against sql injection attacks
    $reminder_message = NULL;
    $user = htmlspecialchars($_SESSION['user']);
    if ($_POST['meal'] != NULL) {
      $meal = htmlspecialchars($_POST['meal']);
    }
    else {
      $reminder_message = "Please fill out all fields!";
    }  
    if ($_POST['eat-date'] != NULL) {
      $date = htmlspecialchars($_POST['eat-date']);
    }
    else {
      $reminder_message = "Please fill out all fields!";
    }
    if ($_POST['eat-time'] != NULL) {
      $time = htmlspecialchars($_POST['eat-time']);
    }
    else {
      $reminder_message = "Please fill out all fields!";
    }  
    if ($_POST['eat-calories'] != NULL) {
      $calories = htmlspecialchars($_POST['eat-calories']);
    }
    else {
      $reminder_message = "Please fill out all fields!";
    }
    if ($_POST['eat-sugar'] != NULL) {
      $sugar = htmlspecialchars($_POST['eat-sugar']);
    }
    else {
      $reminder_message = "Please fill out all fields!";
    }
    if ($_POST['eat-comments'] != NULL) {
      $comments = htmlspecialchars($_POST['eat-comments']);
    }
    else {
      $reminder_message = "Please fill out all fields!";
    }

    $query = "INSERT INTO Eat_Log (User, Meal, Date, Time, Calories, Sugar, Comments) VALUES (:user, :meal, :date, :time, :calories, :sugar, :comments);";

    $statement = $db->prepare($query); //Compile string query into executable version
    
    $statement->bindParam(':user', $user);
    $statement->bindParam(':meal', $meal);
    $statement->bindParam(':date', $date);
    $statement->bindParam(':time', $time);
    $statement->bindParam(':calories', $calories);
    $statement->bindParam(':sugar', $sugar);
    $statement->bindParam(':comments', $comments);
    
    $statement->execute();

    $statement->closeCursor();	

}

if (isset( $_POST['form-submit'] )){
  insertData();
  header("Location: eat_redirect.php");
}
?>


  <?php include('eat_log_header.php') ?>

  <h2 class="page-subheading"> Hello <?php echo $_SESSION['user'] ?>! &nbsp; What have you eaten today? </h2> </br>

  <div class="form-input">
    <form action="" method="post">
      <label for="meal">Meal: &nbsp;&nbsp;</label>
      <select name="meal" id="meal" required>
          <option disabled selected value> -- select a meal -- </option>
          <option value="Breakfast">Breakfast</option>
          <option value="Lunch">Lunch</option>
          <option value="Dinner">Dinner</option>
          <option value="Snack">Snack</option>
      </select>

      <label for="eat-date">&nbsp;&nbsp;Date:&nbsp;&nbsp;</label>
      <input type="date" id="eat-date" name="eat-date" required> 
      
      <label for="eat-time">&nbsp;&nbsp;Time: &nbsp;&nbsp;</label>
      <input type="time" id="eat-time" name="eat-time" required ></br>

      <label for="eat-calories">Calories: </label>
      <input type="text" class="calorie-input" id="eat-calories" name="eat-calories" required><br>

      <label for="eat-sugar">Sugar: </label>
      <input type="text" class="sugar-input" id="eat-sugar" name="eat-sugar" required><br>

      <label for="eat-comments">Comments: </label> </br>
      <textarea name="eat-comments" id="eat-comments" rows="4" cols="50" placeholder="What did you eat?" required></textarea>

      <span class="msg">
        <?php if (!empty($reminder_message)) echo $reminder_message;?>
      </span>

      <input type="submit" value="Submit" name="form-submit" class="btn btn-secondary"></br></br></br>
    </form>
  </div>

    <!--Table for recording meal inputs: hard coded first two values for appearance-->
    <div>
      <h4 style="display:inline;padding-left: 20px;">&nbsp;&nbsp;Recent Meals: </h4>  &nbsp;&nbsp;
        <input type="button" class="btn btn-secondary btn-md" value=" Show Table " id="show-button" title="click to show table">  &nbsp;&nbsp; 
        <input type="button" class="btn btn-secondary btn-md" value=" Hide Table" id="hide-button" title="click to hide table">
    </div> </br> 

    <table id="eat-table" class="table table-striped table-hover">
        <thead class="thead-dark">
          <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Meal</th>
            <th>Calories</th>
            <th>Sugar (mg)</th>
            <th>Comments &nbsp;&nbsp;</th>
          </tr> 
        </thead>
        <tbody>
          <?php query_database();?>
        </tbody>
      </table>  

      <?php include('footer.html') ?>

      <script src="./js/eat_log.js"></script>

<?php
}
else
{
  header('Location: login.php');
}
?>
</body>