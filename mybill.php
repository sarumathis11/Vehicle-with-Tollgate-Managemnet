<?php 
    if (!isset($_SESSION)) {   
        session_start(); 
    } 
    
    $username = $_GET['id'];
    // echo $username;
    
    // PostgreSQL connection parameters
    $host = "localhost";
    $port = "5432";
    $dbname = "vehicle_management";
    $user = "postgres";
    $password = "postgres";

    $connection = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

    // $query = "SELECT booking.booking_id, booking.req_date, booking.ret_date, booking.destination, booking.veh_reg, booking.driverid, tripcost.total_km, tripcost.oil_cost, tripcost.extra_cost, tripcost.total_cost, tripcost.paid FROM booking LEFT JOIN tripcost ON booking.username=tripcost.username WHERE booking.username='$username' AND booking.booking_id=tripcost.booking_id;";
    $query = "
    SELECT
        user1.user_id,
        user1.first_name,
        user1.last_name,
        user1.email,
        user1.wallet_balance,
        booking.booking_id,
        booking.type,
        booking.req_date,
        booking.req_time,
        booking.ret_date,
        booking.destination,
        booking.pickup_point,
        booking.mobile,
        booking.driverid,
        tripcost.total_km,
        tripcost.total_cost
    FROM
        user1
    LEFT JOIN
        booking ON user1.username= booking.username
    LEFT JOIN
        tripcost ON booking.booking_id = tripcost.booking_id
    WHERE
        user1.username = '$username';
";

    // echo $query;

    $result = pg_query($connection, $query);

    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bill</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
     <script src="https://unpkg.com/scrollreveal/dist/scrollreveal.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./slick/slick.css">
    <link rel="stylesheet" type="text/css" href="./slick/slick-theme.css"> 
   
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="animate.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container">
        <div class="row">
            <div class="page-header">
                <h1 style="text-align: center;">My Bill</h1>
            </div>
        </div>
        
    
            
    <div class="col-md-12">
            <?php
            while ($row = pg_fetch_assoc($result)) {
            ?>
            <div class="bill-details">
                <p><strong>Booking Id:</strong> <?php echo $row['booking_id']; ?></p>
                <p><strong>Requested Date:</strong> <?php echo $row['req_date']; ?></p>
                <p><strong>Return Date:</strong> <?php echo $row['ret_date']; ?></p>
                <p><strong>Destination:</strong> <?php echo $row['destination']; ?></p>
                <p><strong>Vehicle Registration:</strong> <a href="busprofile.php?busid=<?php echo $row['veh_reg'] ?>"><?php echo $row['veh_reg'] ?></a></p>
                <p><strong>Driver:</strong> <a href="driverprofile.php?driverid=<?php echo $row['driverid'] ?>"><?php echo $row['driverid'] ?></a></p>
                <p><strong>Total Km:</strong> <?php echo $row['total_km']; ?></p>
                <p><strong>Oil Cost:</strong> <?php echo $row['oil_cost']; ?></p>
                <p><strong>Extra Cost:</strong> <?php echo $row['extra_cost']; ?></p>
                <p><strong>Total Cost:</strong> <?php echo $row['total_cost']; ?></p>
            
            </div>
            <?php } ?>
            
            <!-- Add a print button -->
            <button onclick="printBill()" class="btn btn-primary">Print Bill</button>
        </div>
    </div>
     <!-- JavaScript function to initiate the print dialog -->
     <script>
        function printBill() {
            window.print();
        }
    </script>
</body>
</html>