<?php
$hostname = 'usersrv01.cs.virginia.edu';
//$hostname = 'localhost:3306';
//$hostname = '128.143.69.130';

$dbname = 'bnp3nj';
//$dbname = 'BenP';

$username = 'bnp3nj';
//$username = 'BenP';
$password = '@Sarah524';

$dsn = "mysql:host=$hostname;dbname=$dbname";

try 
{

   $db = new PDO($dsn, $username, $password);
}
catch (PDOException $e) 
{

   $error_message = $e->getMessage();        
   echo "<p>An error occurred while connecting to the database: $error_message </p>";
}
catch (Exception $e) 
{
   $error_message = $e->getMessage();
   echo "<p>Error message: $error_message </p>";
}

?>
