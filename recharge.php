<br><br><br>

<?php
session_start();
$connection = pg_connect('host=localhost port=5432 dbname=vehicle_management user=postgres password=postgres');

if (!$connection) {
    die('Connection failed: ' . pg_last_error());
}

$msg = "";

if (isset($_POST['recharge'])) {
    $amount = $_POST['amount'];
    $username = $_SESSION['username'];

    // Get the current wallet_balance
    $getBalanceQuery = "SELECT wallet_balance FROM user1 WHERE username = '$username'";
    $getBalanceResult = pg_query($connection, $getBalanceQuery);
    
    if ($getBalanceResult) {
        $row = pg_fetch_assoc($getBalanceResult);

        if ($row) {
            $currentBalance = $row['wallet_balance'];

            // Update the wallet_balance
            $newBalance = $currentBalance + $amount;
            $updateBalanceQuery = "UPDATE user1 SET wallet_balance = '$newBalance' WHERE username = '$username'";
            $updateBalanceResult = pg_query($connection, $updateBalanceQuery);

            if ($updateBalanceResult) {
                $msg = "<script language='javascript'>
                        swal(
                            'Success!',
                            'Wallet recharge successful!',
                            'success'
                        );
                        </script>";
            } else {
                die('Update failed: ' . pg_last_error($connection));
            }
        }
    } else {
        die('Error: ' . pg_last_error($connection));
    }
}
?>
 <?php include 'navbar.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wallet Recharge</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="sweetalert2/sweetalert2.css">
    <script src="sweetalert2/sweetalert2.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="page-header">
                <h1 style="text-align:center;">Wallet Recharge</h1>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="amount">Recharge Amount:</label>
                        <input type="number" class="form-control" id="amount" name="amount" required>
                    </div>
                    <button class="btn btn-primary" name="recharge">Recharge</button>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>

    <?php echo $msg; ?>


    <a class="btn btn-default" href="booking.php" style="color:black; background-color:green  ">Go Back</a>

</body>
</html>
