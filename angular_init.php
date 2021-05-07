<?php
require('connect-db.php');
// header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');
header('Access-Control-Max-Age: 1000');  
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');
session_start();


$query = "SELECT * FROM Activity_User WHERE User=:user";
$statement = $db->prepare($query);
$user = 'Ben';
$statement->bindParam(':user', $user);
$statement->execute();
$output = $statement->fetchAll();
foreach ($output as $row){
    $db_Name = $row['User'];
    $db_Password = $row['Password'];
    $db_Height = $row['Height'];
    $db_Weight = $row['Weight'];
    $db_Quote = $row['Quote'];
    $db_Activity = $row['Activity'];
    $db_Meal = $row['Meal'];
}
$statement->closeCursor();

//Send response (in json format) back to the front end
//echo json_encode(['user_name'=>$ng_name, 'user_password'=>$ng_password, 'user_height'=>$ng_height, 'user_weight'=>$ng_weight, 'user_quote'=>$ng_quote]);
echo json_encode(['User'=>$db_Name, 'Password'=>$db_Password, 'Height'=>$db_Height, 'Weight'=>$db_Weight, 'Quote'=>$db_Quote, 'Activity'=>$db_Activity, 'Meal'=>$db_Meal]);
?>