<?php
session_start();
$host = "localhost";
$port = "5432";
$dbname = "vehicle_management";
$user = "postgres";
$password = "postgres";

$connection = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$connection) {
    die("Connection failed: " . pg_last_error());
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  
    $booking_id = $_GET["booking_id"];
    $additional_value = $_GET["additional_value"];

    
    $insert_query = "INSERT INTO 
                    (booking_id, name, type, req_date, return_date, destination, pickup, route, reason, email, mobile)
                    SELECT booking_id, name, type, req_date, return_date, destination, pickup, route, reason, email, mobile
                    FROM booking
                    WHERE booking_id = '$booking_id'";

    $insert_result = pg_query($connection, $insert_query);

    if ($insert_result) {
        echo "Data inserted successfully!";
    } else {
        echo "Error inserting data: " . pg_last_error();
    }
} else {
    echo "Invalid request method";
}

pg_close($connection);
?>
