<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Ben Phillips and Read Schlomer">
  <meta name="description" content="Logout functionality for the activity tracker webapp">  
  
  <title>Logout</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

</head>


<body>
  
<?php session_start(); ?>

<?php
if (count($_SESSION) > 0)
{
  foreach ($_SESSION as $k => $v)
  {
    unset($_SESSION[$k]);    // remove key-value pair from session object (only server-side)
  }
  session_destroy();    // completely remove the instance (server)

  echo "sessionID = " . session_id() . "<br/>";
  setcookie("PHPSESSID", "", time()-3600, "/");
}

header("Location: login.php");
?>

</body>
</html>