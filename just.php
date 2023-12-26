<?php
$connection = pg_connect("host=localhost dbname=vehicle_management user=postgres password=postgres");

session_start();
$msg = "";

if (isset($_POST['submit'])) {
    $firstname = pg_escape_string($connection, strtolower($_POST['firstname']));
    $lastname = pg_escape_string($connection, strtolower($_POST['lastname']));
    $email = pg_escape_string($connection, strtolower($_POST['email']));
    $username = pg_escape_string($connection, strtolower($_POST['username']));
    $password = pg_escape_string($connection, strtolower($_POST['password']));
    $admin = pg_escape_string($connection, strtolower($_POST['admin']));
    $wallet_balance = pg_escape_string($connection, strtolower($_POST['wallet_balance']));

    $signup_query = "INSERT INTO user1(first_name, last_name, email, username, password, admin, wallet_balance) 
                     VALUES ('$firstname','$lastname','$email','$username','$password','$admin','$wallet_balance')";

    $check_query = "SELECT * FROM user1 WHERE username='$username' or email='$email'";
    $check_res = pg_query($connection, $check_query);

    if (pg_num_rows($check_res) > 0) {
        $msg = '<div class="alert alert-warning" style="margin-top:30px;">
                    <strong>Failed!</strong> Username or Email already exists.
                </div>';
    } else {
        $signup_res = pg_query($connection, $signup_query);
        $msg = '<div class="alert alert-success" style="margin-top:30px;">
                    <strong>Success!</strong> Registration Successful.
                </div>';
    }
}

// Set the session values 
// $_SESSION['signup_name'] = $firstname; // Assuming $firstname is the user's first name
// $_SESSION['signup_email'] = $email; // Assuming $email is the user's email address

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="swal/sweetalert.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <script src="swal/sweetalert.js"></script>
    <link rel="stylesheet" href="animate.css">
    <link rel="stylesheet" href="style.css">
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="50"> 
  <?php include 'navbar.php';?> 
  
  
  
  
   
    
    <br>
    <div class="container"> 
     <div class="row">
       <div class="col-md-3"></div>
        <div class="col-md-6"> 
           <?php echo $msg; ?>
            <div class="page-header">
                <h1 style="text-align: center;">Sign Up</h1>      
          </div> 
            <form class="form-horizontal animated bounce" action="" method="post"> 
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input id="firstname" type="text" class="form-control" name="firstname" placeholder="First Name">
                </div>
                <br>
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input id="lastname" type="text" class="form-control" name="lastname" placeholder="Lastname">
                </div>
                <br>
                 <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input id="email" type="email" class="form-control" name="email" placeholder="Email">
                </div>
                <br>
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input id="username" type="text" class="form-control" name="username" placeholder="Username">
                </div>
                <br>
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                  <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <br> 
                <!-- <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input id="admin" type="text" class="form-control" name="admin" placeholder="admin">
                </div>
                <br>  -->
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input id="wallet_balance" type="text" class="form-control" name="wallet_balance" placeholder="wallet_balance">
                </div>
                <br> 
                <!-- <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input id="totalcost" type="text" class="form-control" name="totalcost" placeholder="totalcost">
                </div>
                <br>  -->
                <div class="input-group">
                  <button type="submit" name="submit" class="btn btn-success">Sign Up</button>
                  
                </div>

              </form>   
        </div> 
        <div class="col-md-3"></div>
         
     </div> 
    
    </div> 
    
   
    
</body>
</html>