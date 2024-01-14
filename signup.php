<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SignUp - Online Test</title>
<?php
require_once 'db.php';

$user ="";
$pass = "";
$rpass="";
$error1 = "";// this will be use for displaying error (Username or password is incorrect)
$error = "";// this will be use for displaying sql connect errors

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    if($pass == $rpass){

      $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
      $result = $conn->query($sql);
  
      if ($result) {
        
          $last_id = $conn->insert_id;
          $_SESSION["user_id"] = $last_id;
          header("Location: index.php"); // Redirect to login page if not logged in
          exit();

      } else {
          $error = "Error: " . $sql . "<br>" . $conn->error;
      }
    }
    else {
      $error = "Passwords not matched!";
      }
}

$conn->close();
?>
<link href="css/bootstrap.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <h1 style="float:left; color:#494CE9; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace;"> TicTacToe </h1>
    <a href="index.php">
    <button style="float:right; margin:2%;" class="btn btn-default">Login </button></a>
      
</div></nav>

<div class="container text-center" >
  
  <h2>Sign Up</h2> 
 
  <hr>
  
    
    <form action="signup.php" method="post" >
    <div class="form-group text-left center-block" style=" width:50%;" >
      <label for="usr">UserName:</label>
      <input placeholder="Enter You Username..." type="text" class="form-control" name="username"required value="<?php echo $user?>"> 
    </div>
    <div class="form-group text-left center-block" style=" width:50%;" >
      <label for="pwd">Password:</label>
      <input placeholder="Enter your Password..." type="password" class="form-control" name="password" required value="<?php echo $pass?>"> 
    </div>
    <div class="form-group text-left center-block" style=" width:50%;" >
      <label for="pwd">Re-type Password:</label>
      <input placeholder="Re-type Password..." type="password" class="form-control" name="rpassword" required value="<?php echo $rpass?>"> 
    </div>
    <?php echo '<p style="color:red">'.$error. "</p>"?>
    <h4><input id="submit"  type="submit" class="btn-primary" value="Sign Up"/> <button class="btn-primary" type="reset" > Clear </button></h4>
  </form>
  
   <br><b>&copy; William</b> </div> 
</html>