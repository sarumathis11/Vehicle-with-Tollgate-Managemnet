<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$connection = pg_connect('host=localhost port=5432 dbname=vehicle_management user=postgres password=postgres');
$msg = "";

if (isset($_POST['submit'])) {
    $vehicleType = pg_escape_string($_POST['vehicle_type']);
    $date = pg_escape_string($_POST['date']);
    $entryTime = pg_escape_string($_POST['entry_time']);
    $exitTime = pg_escape_string($_POST['exit_time']);
    $amountPaid = pg_escape_string($_POST['amount_paid']);
    $feedback = pg_escape_string($_POST['feedback']);

    $createdAt = date('Y-m-d H:i:s');


   
    $insert_query = "INSERT INTO tollgate_feedback (vehicle_type, date, entry_time, exit_time, amount_paid, feedback, created_at) 
    VALUES ($1, $2, $3, $4, $5, $6, $7)";

    $res = pg_query_params($connection, $insert_query, array(
        $vehicleType,
        $date,
        $entryTime,
        $exitTime,
        $amountPaid,
        $feedback,
        $createdAt
    ));

    if ($res !== false) {
        $msg = "<script language='javascript'>
                swal(
                    'Success!',
                    'Feedback sent',
                    'success'
                );
                </script>";
    } else {
        die('Unsuccessful: ' . pg_last_error($connection));
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="feedback.css">
    <script src="feedback.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="animate.css">
    <link rel="stylesheet" href="style.css">
    <title>Tollgate Feedback Form</title>
</head>
<body>
<?php include 'navbar.php'; ?>
   <br><br><br>
<div class="container">
    <h1>Tollgate Feedback Form</h1>
    <form id="feedbackForm" method="POST" action=""  >
        <label for="vehicle_type">Vehicle Type:</label>
        <input type="text" id="vehicle_type" name="vehicle_type" required>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>

        <label for="entry_time">Entry Time:</label>
        <input type="time" id="entry_time" name="entry_time" required>

        <label for="exit_time">Exit Time:</label>
        <input type="time" id="exit_time" name="exit_time" required>

        <label for="amount_paid">Amount Paid:</label>
        <input type="number" id="amount_paid" name="amount_paid" required>

        <label for="feedback">Feedback:</label>
        <textarea id="feedback" name="feedback" required></textarea>

        <button type="submit" name="submit">Submit Feedback</button>
    </form>
</div>

<script src="script.js"></script>

</body>
</html>

