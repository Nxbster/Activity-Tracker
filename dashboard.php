<!DOCTYPE html>
<html lang = "en">
<head>
    <meta name="author" content="Read Schlomer, Ben Phillips">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Dashboard">
    <link rel='stylesheet' type= "text/css" href='./styles/stylesheet.css'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <title>Akbar's Dashboard</title>
</head>

<body>
<?php session_start(); ?>
<?php if (isset($_SESSION['user']))
{
?> 
<?php require('connect-db.php'); ?>
<?php include('dashboard_header.php');?> 
    <script>
      window.addEventListener('load', (event) => {
        document.getElementById("weight").focus();
      });

    </script>
    
    <?php
  function insertData() {   
	global $db;
    $height = $weight = $quote = NULL;
    $reminder_message = NULL;
    $user = htmlspecialchars($_SESSION['user']);
    //Input validation, ensure user cannot input null fields into database 
    //Also used htmlspecialchars to prevent against sql injection attacks
    if ($_GET['height'] != NULL){
      $height = htmlspecialchars($_GET['height']);
    }
    else {
      $reminder_message = "Please fill out all fields!";
    }
    if ($_GET['weight'] != NULL){
      $weight = htmlspecialchars($_GET['weight']);
    }
    else {
      $reminder_message = "Please fill out all fields!";
    }
    if ($_GET['quote'] != NULL){
      $quote = htmlspecialchars($_GET['quote']);
    }
    else {
      $reminder_message = "Please fill out all fields!";
    }

    if (isset($height) && isset($weight) && isset($quote)) {
      $query = "UPDATE Activity_User SET Height=:height, Weight=:weight, Quote=:quote WHERE User=:user;";
      $statement = $db->prepare($query); //Compile string query into executable version
      $statement->bindParam(':user', $user);
      $statement->bindParam(':height', $height);
      $statement->bindParam(':weight', $weight);
      $statement->bindParam(':quote', $quote);
      $statement->execute();
      $statement->closeCursor();	
    }
    //clear $_GET array
    //$_GET = array(); 
  }
  if (isset( $_GET['form-submit'] )){
    insertData();
  }
?>

  <?php 
    //Query database for Height, Weight, and Quote fields
    global $db;
      $query = "SELECT Height, Weight, Quote FROM Activity_User WHERE User=:user";
      $statement = $db->prepare($query);
      $user = $_SESSION['user'];
      $statement->bindParam(':user', $user);
      $statement->execute();
      $output = $statement->fetchAll();
      foreach ($output as $row){
        $db_Height = $row['Height'];
        $db_Weight = $row['Weight'];
        $db_Quote = $row['Quote'];
      }
      $statement->closeCursor();
    ?>

    <div class = "card-group">
    <div class = "card">
        <img src="https://farm9.staticflickr.com/8521/8472499482_d3edba87d9_z.jpg" class = "dashImg, img-center">
    </div>
    <div class = "card" name = "bio">
      <form action="" method="get">
        <label for="height">Height(inches): </label>
        <input type="text" value= "<?php echo $db_Height;?>" id="height" name="height"><br>
        <span class="msg" style="color:red">
          <?php if (empty($_GET['height']) && $db_Height == NULL) echo "Please fill out all fields!<br/>"?>
        </span>
        <label for="weight">Weight(lbs): </label>
        <input type="text" value = '<?php echo $db_Weight;?>' id="weight" name="weight"><br>
        <span class="msg" style="color:red">
          <?php if (empty($_GET['weight']) && $db_Weight == NULL) echo "Please fill out all fields! <br/>"?>
        </span>
        <div class="myDIV">
          <label for="quote">Quote: </label>
          <input type="text" value= "<?php echo $db_Quote;?>" id="quote" name="quote"><br>
        </div>
        <span class="msg" style="color:red">
          <?php if (empty($_GET['quote']) && $db_Quote == NULL) echo "Please fill out all fields!"?>
        </span>
        <div class="hide">Heard anything inspiring lately?</div>
        <input type="submit" value="Update" name="form-submit" class="btn btn-secondary" />
      </form>
    </div>
    </div>
    
    <div class="card-group">
        <div class="card">
          <img class="card-img-top" src="..." alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Activities</h5>
            <p class="card-text">Akbar has burned a total of 1238 calories!</p>
            <p class="card-text">Akbar has run for 13 consecutvie days!</p>
            <p class="card-text">Akbar's favorite activity is Swimming.</p>
            <a href="Activity_Log.php" class="btn btn-info" role="button">Activity Log</a>
            
          </div>
        </div>
        <div class="card">
          <img class="card-img-top" src="..." alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Meals</h5>
            <p class="card-text">Akbar has eaten a total of 1523 calories today!</p>
            <p class="card-text">Akbar has eaten 250 grams of sugar this week.</p>
            <p class="card-text">Akbar's favorite meal is breakfast!</p>
            <a href="Eat_Log.php" class="btn btn-info" role="button">Meal Log</a>
          </div>
        </div>
        <div class="card">
          <img class="card-img-top" src="..." alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Fun Stats</h5>
            <p class="card-text">Akbar is on a 4 day workout streak.</p>
            <p class="card-text">Akbar has consumed 5 sodas worth of sugar.</p>
            <p class="card-text">Akbar has eaten 285 more calories than they have burned!</p>
            <a href="#" class="btn btn-info" role="button">Statistics</a>
          </div>
        </div>
      </div>

<?php
}
else
{
  header('Location: login.php');
}
?>   
</body>
</html>