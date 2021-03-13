<?php 
$name = $email = $comment = NULL;
$name_msg = $email_msg = $comment_msg = NULL;

if (!empty($_POST['name'])){
    $name = $_POST['name'];
}
else{
    $name_msg = "Please enter name";
}

if (!empty($_POST['emailaddr'])){
    $email = $_POST['emailaddr'];
}
else{
    $email_msg = "Please enter email";
}
if (!empty($_POST['comment'])){
    $comment = $_POST['comment'];
}
else{
    $comment_msg = "Please enter comment";
}

 //$name = $_POST['name'];
 //$email = $_POST['emailaddr'];
 //$comment = $_POST['comment'];
if ($name != NULL && $email != NULL && $comment != NULL){
    echo "Thanks for the comment, $name <br/>";
    echo "<i> $comment</i> <br/>";
    echo "We will reply to $email  <br/>";
}
else{
    echo "$name_msg : $email_msg : $comment_msg <br/>";
}
 ?>