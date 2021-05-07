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

$input_name = $data[0];
$input_email = $data[1];
$input_fav_comp = $data[2];
$input_least_fav_comp = $data[3];
$input_rating = $data[4];
$input_comments = $data[5];


global $db;
$query = 'INSERT INTO Feedback (Name, Email, Fav_Comp, Least_Fav_Comp, Rating, Comments) VALUES (:name, :email, :fav_comp, :least_fav_comp, :rating, :comments);';
$statement = $db->prepare($query); //Compile string query into executable version
$statement->bindParam(':name', $input_name);
$statement->bindParam(':email', $input_email);
$statement->bindParam(':fav_comp', $input_fav_comp);
$statement->bindParam(':least_fav_comp', $input_least_fav_comp);
$statement->bindParam(':rating', $input_rating);
$statement->bindParam(':comments', $input_comments);
$statement->execute();	



//Send response (in json format) back to the front end
echo json_encode(['Name'=>$input_name, 'Email'=>$input_email, 'Fav_Comp'=>$input_fav_comp, 'Least_Fav_Comp'=>$input_least_fav_comp, 'Rating'=>$input_rating, 'Comments'=>$input_comments]);
?>