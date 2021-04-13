<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Ben Phillips and Read Schlomer">
  <meta name="description" content="Activity Log screen for the activity tracker webapp">  
  
  <title>Activity Log</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="./styles/activitylogstylesheet.css" />

  <!--Styling Rules in the HTML doc-->
  <style>
    /* change table body text color to black*/
    tbody {
      color:white;
    }

    /* change table body text color to orangered on hover*/
    tbody:hover{
      color: #db0030;
    }
  </style>

</head>

<body onload="focusActivity()">
  <?php session_start(); ?>
  <!--In order to keep people who haven't logged in out-->
  <?php if (isset($_SESSION['user']))
  {
  ?>  
  <?php require('connect-db.php'); ?>
  <?php include('activity_log_header.php') ?>

<?php 
  //Function that Queries the database and returns 5 most recent activities
  function query_database(){
    global $db;
    $query = "SELECT * FROM Activity_Log WHERE User=:user ORDER BY Date DESC";

    $statement = $db->prepare($query);
    
    $user = $_SESSION['user'];
    $statement->bindParam(':user', $user);

    $statement->execute();

    $output = $statement->fetchAll();
    $count = 0;
    foreach ($output as $row){
      //Shows the 5 most recent activites
      if ($count < 5)
      {
        //Puts each entry into the table format for display
        ?><tr>
            <td><?php echo $row['Date']; ?></td>
            <td><?php echo $row['Time']; ?>pm</td>
            <td><?php echo $row['Activity']; ?></td>
            <td><?php echo $row['Distance']; ?> miles</td>
            <td>501 calories</td>
          </tr>
        <?php 
        $count = $count + 1; 
      }
    }
    $statement->closeCursor();
  }
?>

  <h2 class="page-subheading"> Hello <?php echo $_SESSION['user'] ?>! &nbsp; What have you done today? </h2></br>
  
<?php
  //Function that takes inputted activity data and inserts it into the Activity_Log table
  function insertData() {   
	global $db;
    $user = htmlspecialchars($_SESSION['user']);
    //Input validation, ensure user cannot input null fields into database 
    //Also used htmlspecialchars to prevent against sql injection attacks
    if ($_POST['activity'] != NULL){
      $activity = htmlspecialchars($_POST['activity']);
    }
    else {
      return;
    }
    if ($_POST['activity-date'] != NULL){
      $date = htmlspecialchars($_POST['activity-date']);
    }
    else {
      return;
    }
    if ($_POST['activity-time'] != NULL){
      $time = htmlspecialchars($_POST['activity-time']);
    }
    else {
      return;
    }
    if ($_POST['activity-time-spent'] != NULL && is_numeric($_POST['activity-time-spent'])) {
      $time_spent = htmlspecialchars($_POST['activity-time-spent']);
    }
    else {
      //Throws user a message if they haven't inputted Time Spent as a string
      setcookie('time_spent_message', "Please fill out Time Spent with an integer!", time()+3600);
      return;
    }
    if ($_POST['activity-distance'] != NULL && is_numeric($_POST['activity-distance'])) {
      $distance = htmlspecialchars($_POST['activity-distance']);
    }
    else {
      //Throws user a message if they haven't inputted Distance as a string
      setcookie('distance_message', "Please fill out Distance with an integer!", time()+3600);
      return;
    }
    //User does not have to input a comment
    $comments = htmlspecialchars($_POST['activity-comments']);

    $query = "INSERT INTO Activity_Log (User, Activity, Date, Time, Time_Spent, Distance, Comments) VALUES (:user, :activity, :date, :time, :time_spent, :distance, :comments);";

    $statement = $db->prepare($query); //Compile string query into executable version
    
    $statement->bindParam(':user', $user);
    $statement->bindParam(':activity', $activity);
    $statement->bindParam(':date', $date);
    $statement->bindParam(':time', $time);
    $statement->bindParam(':time_spent', $time_spent);
    $statement->bindParam(':distance', $distance);
    $statement->bindParam(':comments', $comments);
    
    $statement->execute();

    $statement->closeCursor();	

    //Reset fields to null
    $activity = NULL;
    $date = NULL;
    $time = NULL;
    $time_spent = NULL;
    $distance = NULL;
    $comments = NULL;

    //clear $_POST array
    $_POST = array();  

  //Delete any Cookies we created for error messages:
  if (isset($_COOKIE['time_spent_message'])) setcookie("time_spent_message", "", time()-3600);
  if (isset($_COOKIE['distance_message'])) setcookie("distance_message", "", time()-3600);
}

if (isset( $_POST['form-submit'] )){
  //Run function when Submit button is pressed
  insertData();
  //Redirect user -> Solves bugs with $_POST array keeping data through refresh
  header("Location: activity_redirect.php");
}

?>

<div class="form-input">
  <form action="" method="post">
    <label for="activity">Activity:&nbsp;&nbsp; </label>
    <select name="activity" id="activity" required>
        <option disabled selected value> -- select an activity -- </option>
        <option value="Swimming">Swimming</option>
        <option value="Biking">Biking</option>
        <option value="Walking">Walking</option>
    </select>

    <label for="activity-date">&nbsp;&nbsp;Date:&nbsp;&nbsp;</label>
    <input type="date" id="activity-date" name="activity-date" required> 
    
    <label for="activity-time">&nbsp;&nbsp;Time: &nbsp;&nbsp;</label>
    <input type="time" id="activity-time" name="activity-time" required></br>

    <label for="activity-time-spent">Time Spent: &nbsp;&nbsp;</label>
    <input type="text" id="activity-time-spent" name="activity-time-spent" required><br>

    <!--Throw error message from cookie if the error message is set-->
    <span class="msg" style="color:red">
      <?php if (isset($_COOKIE['time_spent_message'])) echo $_COOKIE['time_spent_message'] . '<br/>';?>
    </span>

    <label for="activity-distance">Distance: &nbsp;&nbsp;</label>
    <input type="text" class="distance-input" id="activity-distance" name="activity-distance" required><br>
    
    <!--Throw error message from cookie if the error message is set-->
    <span class="msg" style="color:red">
      <?php if (isset($_COOKIE['distance_message'])) echo $_COOKIE['distance_message'] . '<br/>';?>
    </span>

    <label for="activity-comments">Comments: </label> </br>
    <textarea name="activity-comments" id="activity-comments" rows="4" cols="50" placeholder="How was your activity?"></textarea>

    <input type="submit" value="Submit" name="form-submit" class="btn btn-secondary" />
  </form> 

</div>
  
  </br></br>

  <!--Table for recording meal inputs: hard coded first two values for appearance-->
    <div>
      <h4 style="display:inline;padding-left: 20px;">&nbsp;&nbsp;Recent Workouts: </h4>  &nbsp;&nbsp;
        <input type="button" class="btn btn-secondary btn-md" value=" Show Table " id="show-button" title="click to show table">  &nbsp;&nbsp; 
        <input type="button" class="btn btn-secondary btn-md" value=" Hide Table" id="hide-button" title="click to hide table">
    </div> </br> 
      <table id="workout-table" class="table table-striped table-hover">
        <thead class="thead-dark">
          <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Activity</th>
            <th>Distance</th>
            <th>Calories Burned</th>
          </tr> 
        </thead>
        <tbody >
            <?php query_database();?>
        </tbody>
      </table>  

      <?php include('footer.html') ?>

    </div>

    <script src="./js/activity_log.js"></script>
  
<?php
}
else
{
  header('Location: login.php');
}
?>    

</body>