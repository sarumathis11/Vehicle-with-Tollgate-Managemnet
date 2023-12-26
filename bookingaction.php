<br><br><br>
<br><br><br>

<?php
use function PHPSTORM_META\type;

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$connection = pg_connect('host=localhost port=5432 dbname=vehicle_management user=postgres password=postgres');
$msg = "";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $department = $_POST['department'];
    $type = $_POST['type'];
    $req_date = $_POST['req_date'];
    $req_time = $_POST['req_time'];
    $return_date = $_POST['return_date'];
    $return_time = $_POST['return_time'];
    $destination = $_POST['destination'];
    $pickup = $_POST['pickup'];
    $reason = $_POST['reason'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $username = $_POST['username'];

    // Use COALESCE to handle empty or unset values
    $confirmation = isset($_POST['confirmation']) ? $_POST['confirmation'] : 0;
    $veh_reg = isset($_POST['veh_reg']) ? $_POST['veh_reg'] : '';
    $driverid = isset($_POST['driverid']) ? $_POST['driverid'] : 0;
    $finished = isset($_POST['finished']) ? $_POST['finished'] : 0;

    // Construct the SQL query
    $insert_query = "INSERT INTO booking (name, username, department, type, req_date, req_time, ret_date, ret_time, destination, pickup_point, resons, email, mobile, confirmation, veh_reg, driverid, finished, paid) 
                VALUES ('$name', '$username', '$department', '$type', '$req_date', '$req_time', '$return_date', '$return_time', '$destination', '$pickup', '$reason', '$email', $mobile, $confirmation, '$veh_reg', $driverid, $finished, 0)";


    $res = pg_query($connection, $insert_query);

    if ($res == true) {
        $msg = "<script language='javascript'>
                swal(
                    'Success!',
                    'Registration Completed!',
                    'success'
                );
                </script>";
    } else {
        die('Unsuccessful: ' . pg_last_error($connection));
    }
    }



?>
<?php



$paymentAmount = isset($_SESSION['paymentAmount']) ? $_SESSION['paymentAmount'] : 0;

$connection = pg_connect('host=localhost port=5432 dbname=vehicle_management user=postgres password=postgres');

if (!$connection) {
    die('Connection failed: ' . pg_last_error());
}else{
    echo "   WALLET BALANCE    ";
}

$msg = "";
$redirectTime = 60;

if (isset($_POST['submit'])) {
    $username = $_SESSION['username'];

    $query = "SELECT wallet_balance FROM user1 WHERE username='$username'";
    $result = pg_query($connection, $query);
    $row = pg_fetch_assoc($result);

    $route = isset($_POST['route']) ? $_POST['route'] : ''; // Add isset check
    $hyphenCount = substr_count($route, '-');
    $paymentAmount = 100 + ($hyphenCount * 100);
    $_SESSION['paymentAmount'] = $paymentAmount;

    // Check wallet balance
    $walletBalance = $row['wallet_balance'] ?? 0; // Use null coalescing operator for better handling

    if ($walletBalance < $paymentAmount) {
        // Display an alert message
        $msg = "<script language='javascript'>
            alert('Low Balance! Your wallet balance is low. Recharge now!');
            window.location = 'recharge.php';
        </script>";
    } else {
        // Update the totalcost column in user1 table
        $clearOldValuesQuery = "UPDATE user1 SET totalcost = 0 WHERE username = '$username'";
        pg_query($connection, $clearOldValuesQuery);

        $updateTotalCostQuery = "UPDATE user1 SET totalcost = $paymentAmount WHERE username = '$username'";
        pg_query($connection, $updateTotalCostQuery);

        // Deduct paymentAmount from wallet_balance
        $newBalance = $walletBalance - $paymentAmount;
        $updateBalanceQuery = "UPDATE user1 SET wallet_balance = '$newBalance' WHERE username = '$username'";
        pg_query($connection, $updateBalanceQuery);

        $updatePaidQuery = "UPDATE booking SET paid = 1 WHERE username = '$username'";
        pg_query($connection, $updatePaidQuery);




        // Success message
        $msg = "<script language='javascript'>
            alert('Payment successful! Amount: $paymentAmount');
            window.location = 'bookingaction.php';
        </script>";
    }
}

// Fetch wallet_balance from user1 table
$username = $_SESSION['username'];
$walletQuery = "SELECT wallet_balance FROM user1 WHERE username='$username'";
$walletResult = pg_query($connection, $walletQuery);

if ($walletResult) {
    $walletRow = pg_fetch_assoc($walletResult);
    $walletBalance = $walletRow['wallet_balance'] ?? 0;

    // Display wallet balance
    echo "<p>Your wallet balance: $$walletBalance</p>";
} else {
    // Handle the error if the query fails
    echo "<p>Error fetching wallet balance: " . pg_last_error($connection) . "</p>";
}



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
     <!-- Include jQuery -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
     <?php include 'navbar.php';?>

    
    
    
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="page-header">
                <h1 style="text-align:center;">Toll Payment</h1>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?php if (!isset($_SESSION['paymentSuccess'])) : ?>
                    <p>Your paid amount is: $<?php echo $paymentAmount; ?></p>
                    <button id="payButton" class="btn btn-primary" name="submit">Paid</button>
                <?php else : ?>
                    <p>Amount: $<?php echo $paymentAmount; ?> paid successfully! Congratulations!</p>
                    <button class="btn btn-success" disabled>Paid</button>
                <?php endif; ?>
            </div>

            <div class="col-md-3"></div>
        </div>
    </div>
    <?php echo $msg; ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <a class="btn btn-default" href="index.php" style="color:black; background-color:green  ">Go Back</a>
</body>
</html>
