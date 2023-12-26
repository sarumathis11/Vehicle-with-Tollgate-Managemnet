<?php
    $host = "localhost";
    $port = "5432";
    $dbname = "vehicle_management";
    $user = "postgres";
    $password = "postgres";

    $connection = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

    session_start();

    $id = $_GET['id'];

    $sql = "UPDATE tripcost SET paid='1' WHERE booking_id='$id'";
    $result = pg_query($connection, $sql);

    if ($result) {
        header('Location: bookinglist.php');
    }
?>
