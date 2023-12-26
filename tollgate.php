<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}

// Include your database connection here
$connection = pg_connect('host=localhost port=5432 dbname=vehicle_management user=postgres password=postgres');

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve the username from the session
    $username = $_SESSION['username'];

    // Retrieve other form values
    $email = $_POST['email'];
    $accountNumber = $_POST['accountNumber'];
    $vehicleNumber = $_POST['vehicleNumber'];
    $amount = $_POST['amount'];

    // Insert values into the wallet_new table
    $insertQuery = "INSERT INTO wallet_new (user_id, balance) VALUES (
        (SELECT user_id FROM user1 WHERE username = '$username'),
        $amount
    )";

    $insertResult = pg_query($connection, $insertQuery);

    // Retrieve the total cost from tripcost
    $totalCostQuery = "SELECT total_cost FROM tripcost WHERE username='$username'";
    $totalCostResult = pg_query($connection, $totalCostQuery);

    if ($totalCostResult) {
        $totalCostRow = pg_fetch_assoc($totalCostResult);
        $totalCost = $totalCostRow['total_cost'];

        // Deduct the payment amount from the total cost
        $newTotalCost = $totalCost - $amount;

        // Update the total cost in tripcost
        $updateTotalCostQuery = "UPDATE tripcost SET total_cost = $newTotalCost WHERE username = '$username'";
        $updateTotalCostResult = pg_query($connection, $updateTotalCostQuery);

        if (!$updateTotalCostResult) {
            die('Error updating total cost: ' . pg_last_error($connection));
        }
    } else {
        die('Error: ' . pg_last_error($connection));
    }

    if ($insertResult) {
        // Redirect to booking.php after successful payment
        header('Location: booking.php');
        exit();
    } else {
        die('Error: ' . pg_last_error($connection));
    }
}

// Retrieve the username from the session
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tollgate Home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="animate.css">
    <style>
        /* Add your custom styles here */
        body {
            background-color: #f2f2f2;
        }
        .welcome-message {
            text-align: center;
            margin-top: 50px;
        }
        .toll-form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <div class="welcome-message">
        <h2>Welcome, <?php echo $username; ?>!</h2>
        <p>Enjoy the Fast Tag facilities at our Tollgate.</p>
    </div>

    <div class="toll-form">
        <h3>Tollgate Payment Form</h3>
        <form action="booking.php" method="post">
            <!-- Add your account details form fields here -->
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required value="<?php echo isset($_SESSION['signup_email']) ? $_SESSION['signup_email'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="accountNumber">Account Number:</label>
                <input type="text" class="form-control" id="accountNumber" name="accountNumber"  placeholder="---- ---- ----" required>
            </div>
            <div class="form-group">
                <label for="vehicleNumber">Vehicle Number:</label>
                <input type="text" class="form-control" id="vehicleNumber" name="vehicleNumber"  placeholder="TN-- ----" required>
            </div>
            
            <button type="submit" class="btn btn-success">Pay Tollgate Tax</button>
        </form>
    </div>
</div>

</body>
</html>
