<?php 
$name = $email = $comment = NULL;
$name_msg = $email_msg = $comment_msg = NULL;

if ($_SERVER['REQUEST_METHOD'] =='POST'){



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
  //else{
  //    echo "$name_msg : $email_msg : $comment_msg <br/>";
  //}
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">   
  <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- required to handle IE -->
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <title>PHP form handling</title>
 
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <style>
    label { display: block; }
    input, textarea { display:inline-block; font-family:arial; margin: 5px 10px 5px 40px; padding: 8px 12px 8px 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; width: 90%; font-size: small; }
    div { margin-left: auto; margin-right: auto; width: 60%; }
    h1 { text-align: center; }    
    input[type=submit] { padding:5px 15px; border:0 none; cursor:pointer; border-radius: 5px; }
    input[type=submit]:hover { background-color: #ccceee; }
    .msg { margin-left:40px; font-style: italic; color: red; }    
    html{ height:100%; }
    body{ min-height:100%; padding:0; margin:0; position:relative; }    
    footer { position: absolute; bottom: 0; width: 100%; height: 50px; color: WhiteSmoke; padding: 10px; }
   </style>   
</head>

<body>
<div>  
  <h1>PHP: Form Handling</h1>
   
  <!-- what are form inputs -->
  <!-- who will handle the form submission -->
  <!-- how are the request sent -->
   
  <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
    <label>Name: </label>
    <input type="text" name="name" value = "<?php if (!empty($_POST['name'])) echo $_POST['name']?>" /> <br/>
    <span class="msg">
      <?php if (empty($_POST['name'])) echo $name_msg ?>
    </span>
    <label>Email:</label>
    <input type="email" name="emailaddr" /> <br/>
    <span class="msg">
      <?php if (empty($_POST['emailaddr'])) echo $email_msg ?>
    </span>
    <label>Comment: </label>
    <textarea rows="5" cols="40" name="comment"></textarea> <br/>
    <span class="msg">
      <?php if (empty($_POST['comment'])) echo $comment_msg ?>
    </span>
     
    <input type="submit" value="Submit" class="btn btn-secondary" />

  </form>
</div>

  
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    
</body>
</html>