<?php

$id = $_GET['id'];

$host = "localhost";
$port = "5432";
$dbname = "vehicle_management";
$user = "postgres";
$password = "postgres";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

// Update the bill table based on tripcost values
$updateSql = "UPDATE bill b
JOIN tripcost t ON b.username = t.username
SET
    b.salary = t.total_km,
    b.equipment = t.oil_cost,
    b.oil = t.extra_cost,
    b.tcost = t.total_cost";

pg_query($conn, $updateSql);

// Retrieve the updated data for the specified id
$selectSql = "SELECT * FROM bill WHERE id='$id'";
$result = pg_query($conn, $selectSql);

$bill = pg_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Welcome</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    
    <br><br><br>
	 <?php include 'navbar_admin.php';?>
     
    <div class="container">
      <div class="row">
        <div class="col-md-2">
          <a class="btn btn-info" href="indexbill.php">Bill List</a>
        </div> 
        <div class="col-md-6">
        <h2>Billing Information</h2>
        <hr>
          
        <table class="table" >
           
          <tr>
            <th >Service Charge:</th>
            <td><?php echo $bill['salary']; ?></td>
          </tr>
          <tr>
            <th >Equipment:</th>
            <td><?php echo $bill['equipment']; ?></td>
          </tr>
          <tr>
            <th >Oil:</th>
            <td><?php echo $bill['oil']; ?></td>
          </tr>
          <tr>
            <th >Total Cost:</th>
            <td><?php echo $bill['tcost']; ?></td>
          </tr>
        </table>  

        </div>
      </div>
    </div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html> 