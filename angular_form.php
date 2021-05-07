<?php
require('connect-db.php');
// header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');
header('Access-Control-Max-Age: 1000');  
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');
session_start();


// retrieve data from the request
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$data = [];
foreach ($request as $k){
    $data[] = $k;
}

$query_fired = 'no';
$input_name = $data[0];
$input_password = $data[1];
$input_height = $data[2];
$input_weight = $data[3];
$input_quote = $data[4];
$input_activity = $data[5];
$input_meal = $data[6];

if (isset($input_height)){
    global $db;
    $query = 'UPDATE Activity_User SET Height=:height, Weight=:weight, Quote=:quote, Activity=:activity, Meal=:meal WHERE User=:user;';
    $statement = $db->prepare($query); //Compile string query into executable version
    $user = 'Ben';
    $statement->bindParam(':user', $user);
    $statement->bindParam(':height', $input_height);
    $statement->bindParam(':weight', $input_weight);
    $statement->bindParam(':quote', $input_quote);
    $statement->bindParam(':activity', $input_activity);
    $statement->bindParam(':meal', $input_meal);
    $statement->execute();	
    $query_fired = 'yes';
}

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