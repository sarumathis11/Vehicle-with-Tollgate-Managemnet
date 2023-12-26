<?php

$id = $_GET['id'];

$host = "localhost";
$port = "5432";
$dbname = "vehicle_management";
$user = "postgres";
$password = "postgres";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
$sql = "SELECT
   b.booking_id,
   b.name,
   b.username AS booking_username,
   b.department,
   b.type,
   b.req_date,
   b.req_time,
   b.ret_date,
   b.ret_time,
   b.destination,
   b.pickup_point,
   b.resons,
   b.email,
   b.mobile,
   b.confirmation,
   b.veh_reg,
   b.driverid,
   b.finished,
   b.paid AS booking_paid,
   t.total_km,
   t.oil_cost,
   t.extra_cost,
   t.total_cost AS tripcost_total_cost,
   t.paid AS tripcost_paid
FROM
   booking b
JOIN
   tripcost t ON b.booking_id = t.booking_id
WHERE
   b.booking_id = '$id';";

$result = pg_query($conn, $sql);

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
            <div class="col-md-12">
                <h2>Billing Information</h2>
                <hr>
                <?php while ($bill = pg_fetch_assoc($result)) { ?>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <strong>Booking ID:</strong> <?php echo $bill['booking_id']; ?><br>
                            <strong>Name:</strong> <?php echo $bill['name']; ?><br>
                            <strong>Username:</strong> <?php echo $bill['booking_username']; ?><br>
                            <!-- Add other details as needed -->
                            <strong>Service Charge:</strong> <?php echo $bill['salary']; ?><br>
                            <strong>Equipment:</strong> <?php echo $bill['equipment']; ?><br>
                            <strong>Oil:</strong> <?php echo $bill['oil']; ?><br>
                            <strong>Total Cost:</strong> <?php echo $bill['tcost']; ?><br>
                            <strong>Paid:</strong> <?php echo $bill['tripcost_paid']; ?><br>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html> 