<?php
$host = "localhost";
$port = "5432";
$dbname = "postgres";
$user = "postgres";
$password = "postgres";

$connection = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

session_start();
$msg = "";

if (isset($_POST['submit'])) {
    $firstname = pg_escape_string($connection, strtolower($_POST['firstname']));
    $lastname = pg_escape_string($connection, strtolower($_POST['lastname']));
    $email = pg_escape_string($connection, strtolower($_POST['email']));
    $username = pg_escape_string($connection, strtolower($_POST['username']));
    $password = pg_escape_string($connection, strtolower($_POST['password']));

    $signup_query = "INSERT INTO \"user\"(\"user_id\", \"first_name\", \"last_name\", \"email\", \"username\", \"password\") VALUES ('', '$firstname', '$lastname', '$email', '$username', '$password')";

    $check_query = "SELECT * FROM \"user\" WHERE username='$username' or email='$email'";

    $check_res = pg_query($connection, $check_query);

    if (pg_num_rows($check_res) > 0) {
        $msg = '<div class="alert alert-warning" style="margin-top:30px";>
                    <strong>Failed!</strong> Username or Email already exists.
                </div>';
    } else {
        $signup_res = pg_query($connection, $signup_query);
        $msg = '<div class="alert alert-success" style="margin-top:30px";>
                    <strong>Success!</strong> Registration Successful.
                </div>';
    }
}

pg_close($connection);
?>

<!-- Rest of your HTML code remains unchanged -->

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

























<?php
    session_start();
    $host = "localhost";
    $port = "5432";
    $dbname = "vehicle_management";
    $user = "postgres";
    $password = "postgres";

    $connection = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

    if (!$connection) {
        die("Connection failed: " . pg_last_error());
    }

    $select_query = "SELECT * FROM booking ORDER BY booking_id DESC";
    $result = pg_query($connection, $select_query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking list</title>
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">   
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="sweetalert2/sweetalert2.css">
    <script src="sweetalert2/sweetalert2.min.js"></script>
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="animate.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
  <?php include 'navbar_admin.php'; ?>
  <br><br>
   <div class="container">
        <div class="row">
           <div class="col-md-12">
             <div class="page-header">
                <h1 style="text-align: center;">Booking List</h1>
                 
              </div> 
              <table id="myTable" class="table table-bordered animated bounce">
                <thead>
                    
                    <th>Booking Id</th>
                    <th>Name</th>
                    <th>Type</th>
                    
                    <th>Delete</th>
                    <th>Release</th>
                    <th>Confirm Trip</th>
                    <th>Checked</th>
                    <th>Finished</th>
                    <th>Bill</th>
                    <th>Confirm Payment</th>
                    <th>Paid</th>
                    
                </thead>
                
                <tbody>
                <?php while($row = pg_fetch_assoc($result)) { ?>
                    <tr>
                       
                        <td><?php echo $row['booking_id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['type']; ?></td>
                       
                        
                        <td><a class="btn btn-danger" href="deletebooking.php?id=<?php echo $row['booking_id']; ?>">Delete</a></td>
                        
                        <?php if($row['confirmation']==0 or $row['finished']==1)  { ?>
                        <td><a class="btn btn-default disabled" href="releasebooking.php?id=<?php echo $row['booking_id']; ?>">Release Vehicle</a></td>
                        <?php } else{ ?>
                        <td><a class="btn btn-default" href="releasebooking.php?id=<?php echo $row['booking_id']; ?>">Release Vehicle</a></td>
                        <?php } ?>
                        
                        <?php if($row['confirmation']=='0'){ ?>
                        <td><a class="btn btn-success" href="confirmbooking.php?id=<?php echo $row['booking_id']; ?>">Confirm</a></td>
                        <?php } else { ?>
                        <td><a class="btn btn-success disabled" href="confirmbooking.php?id=<?php echo $row['booking_id']; ?>">Confirm</a></td>
                        <?php } ?>
                        
                        <?php if($row['confirmation']=='0'){ ?>
                        <td>No</td>
                        <?php } else { ?>
                        <td>Yes</td>
                        <?php }  ?>
                        
                        <?php if($row['finished']=='0'){ ?>
                        <td>No</td>
                        <?php } else { ?>
                        <td>Yes</td>
                        <?php }  ?>
                        
                        
                        
                        <?php if($row['finished']=='1' and $row['paid']==0 ){  ?>
                        <td><a class="btn btn-primary" href="bill.php?id=<?php echo $row['booking_id']; ?>">Bill</a></td> 
                         <?php } else if($row['paid']==1 ) { ?>
                          <td><a class="btn btn-primary disabled" href="bill.php?id=<?php echo $row['booking_id']; ?>">Bill</a></td> 
                          <?php }  ?>
                          
                         
                          <td><a href="confirmpayment.php?id=<?php echo $row['booking_id']; ?>">Confirm</a></td>
                          
                          <?php if($row['paid']=='0'){ ?>
                        <td>No</td>
                        <?php } else { ?>
                        <td>Yes</td>
                        <?php }  ?>
                          
                          
                          
                        
                    </tr>
                    

                    <?php }   ?>
                </tbody>
            </table>
            </div>
        </div>
        
        
   </div>  
</body>

<script>
$(document).ready(function(){
    $('#myTable').dataTable();
});
</script>
</html>
