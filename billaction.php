<?php
$host = "localhost";
$port = "5432";
$dbname = "vehicle_management";
$user = "postgres";
$password = "postgres";
$connection = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$connection) {
    die('Connection failed: ' . pg_last_error());
}

session_start();

$id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? $_GET['id'] : 0;
$msg = "";

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $total_km = $_POST['total_km'];
    $oil_cost = $_POST['oil_cost'];
    $extra_cost = $_POST['extra_cost'];
    $total_cost = $_POST['total_cost'];

    $username = substr($username, 0, 100);

   $sql = "INSERT INTO tripcost(booking_id, username, total_km, oil_cost, extra_cost, total_cost, paid)
        VALUES ('$id', '$username', '$total_km', '$oil_cost', '$extra_cost', '$total_cost', false)";


    $result = pg_query($connection, $sql);

    if ($result == true) {
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


<<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
    
   
     <link rel="stylesheet" href="sweetalert2/sweetalert2.css">
    <script src="sweetalert2/sweetalert2.min.js"></script>
    
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
    <?php echo $msg;
    ?>
    
    <script>
    
        var timer = setTimeout(function() {
            window.location='bookinglist.php'
        }, 1000);
    </script>
</body>
</html>