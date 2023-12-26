<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$paymentAmount = isset($_SESSION['paymentAmount']) ? $_SESSION['paymentAmount'] : 0;

$connection = pg_connect('host=localhost port=5432 dbname=vehicle_management user=postgres password=postgres');

if (!$connection) {
    die('Connection failed: ' . pg_last_error());
}

$msg = "";
$redirectTime = 60;

if (isset($_POST['submit'])) {
    $username = $_SESSION['username'];

    $query = "SELECT first_name, last_name, email FROM user1 WHERE username='$username'";
    $result = pg_query($connection, $query);
    $row = pg_fetch_assoc($result);

    $route = $_POST['route'];
    $hyphenCount = substr_count($route, '-');
    $paymentAmount = 100 + ($hyphenCount * 100);
    $_SESSION['paymentAmount'] = $paymentAmount;

    $_SESSION['paymentSuccess'] = true;
    $_SESSION['redirectTime'] = time() + $redirectTime;

    //Clear old values before updating totalcost
    $clearOldValuesQuery = "UPDATE user1 SET totalcost = 0 WHERE username = '$username'";
    pg_query($connection, $clearOldValuesQuery);
    // Update the totalcost column in user1 table
    $updateTotalCostQuery = "UPDATE user1 SET totalcost = $paymentAmount WHERE username = '$username'";
    pg_query($connection, $updateTotalCostQuery);

    header("Location: bookingaction.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Toll Payment</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="sweetalert2/sweetalert2.css">
    <script src="sweetalert2/sweetalert2.min.js"></script>
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
                    <p>You need to pay: $<?php echo $paymentAmount; ?></p>
                    <form method="post" action="">
                        <button id="payButton" class="btn btn-primary" name="submit">Pay</button>
                    </form>
                <?php else : ?>
                    <p>Amount: $<?php echo $paymentAmount; ?> paid successfully! Congratulations!</p>
                    <button class="btn btn-success" disabled>Paid</button>
                <?php endif; ?>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
    <?php
                 // Fetch wallet_balance from user1 table
        $username = $_SESSION['username'];
        $walletQuery = "SELECT wallet_balance FROM user1 WHERE username='$username'";
        $walletResult = pg_query($connection, $walletQuery);

        if ($walletResult) {
            $walletRow = pg_fetch_assoc($walletResult);
            $walletBalance = $walletRow['wallet_balance'];

            // Display wallet balance
            echo "<p>Your wallet balance: $$walletBalance</p>";
        } else {
            // Handle the error if the query fails
            echo "<p>Error fetching wallet balance: " . pg_last_error($connection) . "</p>";
        }
                ?>

    <script>
        <?php if (isset($_SESSION['paymentSuccess'])) : ?>
            // Display success alert
            swal({
                title: "Paid Successfully",
                text: "Amount: $<?php echo $paymentAmount; ?> paid successfully! Congratulations!",
                icon: "success",
            });

            setTimeout(function () {
                window.location = 'booking.php';
            }, 50000); // Redirect after 50 seconds
        <?php endif; ?>

        <?php echo $msg; ?>
    </script>
</body>
</html>

<?php
$connection = pg_connect("host=localhost port=5432 dbname=vehicle_management user=postgres password=postgres");

if (!$connection) {
    die('Connection failed: ' . pg_last_error());
}


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
    $route = $_POST['route'];
    $reason = $_POST['reason'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $username = $_POST['username'];

    $deductAmount = 10;

    $checkBalanceQuery = "SELECT wallet_balance FROM user1 WHERE user_id=(SELECT user_id FROM user WHERE username='$username')";
    $checkBalanceResult = pg_query($connection, $checkBalanceQuery);
    if ($checkBalanceResult) {
        $row = pg_fetch_assoc($checkBalanceResult);
        if ($row) {
            $walletBalance = $row['wallet_balance'];

            if ($walletBalance >= $deductAmount) {
                $newBalance = $walletBalance - $deductAmount;
                $updateBalanceQuery = "UPDATE user1 SET wallet_balance='$newBalance' WHERE user_id=(SELECT user_id FROM user WHERE username='$username')";
                $updateBalanceResult = pg_query($connection, $updateBalanceQuery);

                if ($updateBalanceResult) {
                    $insertQuery = "INSERT INTO booking(name, username, department, type, req_date, req_time, ret_date, ret_time, destination, pickup_point, resons, email, mobile, confirmation, veh_reg, driverid, finished, paid) VALUES ('$name','$username','$department','$type','$req_date','$req_time','$return_date','$return_time','$destination','$pickup','$reason','$email','$mobile','','','','','','$deductAmount')";
                    
                    $insertResult = pg_query($connection, $insertQuery);

                    if ($insertResult) {
                        $msg = "<script language='javascript'>
                                swal(
                                    'Success!',
                                    'Registration Completed!',
                                    'success'
                                );
                                </script>";
                    } else {
                        die('Unsuccessful Insert: ' . pg_last_error($connection));
                    }
                } else {
                    die('Unsuccessful Update: ' . pg_last_error($connection));
                }
            }
        } else {
            $msg = "<script language='javascript'>
                    swal(
                        'Error!',
                        'Insufficient wallet balance. Please recharge your wallet!',
                        'error'
                    );
                    </script>";
        }
    } else {
        die('Error: ' . pg_last_error($connection));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include your head content here -->
</head>
<body>
    <?php echo $msg; ?>
</body>
</html>