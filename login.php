<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Ben Phillips and Read Schlomer">
  <meta name="description" content="Login Page for the activity tracker webapp">  
  
  <title>Activity Tracker Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

</head>

<?php session_start(); require('connect-db.php');?>

  <div class="container">
    <h1>Welcome Back to Activity Tracker!</h1>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
      Name: <input type="text" name="username" class="form-control" autofocus required /> <br/>
      Password: <input type="password" name="pwd" class="form-control" required /> <br/>
      <input type="submit" value="Sign in" class="btn btn-light" />   
    </form>
  </div>

<?php 
  
  $password_warning = NULL;
  function login_and_authenticate(){
    //Read
    global $time_logged_in;
    date_default_timezone_set('US/Eastern');
    if($_SERVER['REQUEST_METHOD'] == 'POST' && strlen($_POST['username']) > 0)
    {
      global $db;
      $query = "SELECT User, Password FROM Activity_User WHERE User=:user";
      $statement = $db->prepare($query);
      $user = $_POST['username'];
      $statement->bindParam(':user', $user);
      $statement->execute();
      $output = $statement->fetchAll();

      if (count($output) > 0){
        foreach ($output as $row){
          echo $row['User'] . ' . ' . $row['Password'];
          if ($_POST['username'] == $row['User'] && $_POST['pwd'] == $row['Password']){
            $_SESSION['user'] = $_POST['username'];
            //Read
            $time_logged_in = date("h:i:s",time());
            header('Location: dashboard.php' . "?time=$time_logged_in");
          }
          else{
            echo "Wrong password!";
          }
        }
      }
      else {
        $query = "INSERT INTO Activity_User (User, Password) VALUES (:user, :password);";
        $statement = $db->prepare($query); //Compile string query into executable version
        $statement->bindParam(':user', $_POST['username']);
        $statement->bindParam(':password', $_POST['pwd']);
        $statement->execute();
        $statement->closeCursor();
        $_SESSION['user'] = $_POST['username'];
        //Read
        $time_logged_in = date('h:i:s',time());
        header('Location: dashboard.php'. "?time=$time_logged_in");
      }
    }

      //header('Location: dashboard.php');
  }  
  
  login_and_authenticate();
?>