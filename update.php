<?php
if (!isset($_SESSION)) {
    session_start();
}

$host = "localhost";
$port = "5432";
$dbname = "vehicle_management";
$user = "postgres";
$password = "postgres";

$connection = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

$username = $_SESSION['username'];

// Fetch existing booking information
$query = "SELECT * FROM booking WHERE username='$username'";
$result = pg_query($connection, $query);
$bookingData = pg_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission to update booking information

    // Retrieve updated values from the form
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

    // Update the booking information in the database
    $updateQuery = "UPDATE booking SET 
                    name='$name', 
                    department='$department', 
                    type='$type', 
                    req_date='$req_date', 
                    req_time='$req_time', 
                    return_date='$return_date', 
                    return_time='$return_time', 
                    destination='$destination', 
                    pickup='$pickup', 
                    route='$route', 
                    reason='$reason', 
                    email='$email', 
                    mobile='$mobile' 
                    WHERE username='$username'";
    
    $updateResult = pg_query($connection, $updateQuery);

    if ($updateResult) {
        $msg = "Booking information updated successfully.";
    } else {
        $msg = "Error updating booking information.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<body>
   
    <br>
    <div class="container">
        <div class="row">
            <div class="page-header">
                <h1 style="text-align:center;">Update Booking</h1>
                <?php echo isset($msg) ? "<p>$msg</p>" : ""; ?>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form class="animated bounce" action="update.php" method="post">
                    <!-- Populate the form fields with existing booking data -->
                    <!-- Add other form elements as needed -->
                    <div class="input-group">
                        <span class="input-group-addon"><b>Name</b></span>
                        <input id="name" type="text" class="form-control" name="name" value="<?php echo $bookingData['name']; ?>" required>
                    </div>
                    
                    

                    <div class="input-group">
                        <input type="submit" name="submit" class="btn btn-success">
                    </div>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>

</body>
</html>
