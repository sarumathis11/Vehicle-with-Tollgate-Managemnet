<?php

$id = $_GET['id'];

$host = "localhost";
$port = "5432";
$dbname = "vehicle_management";
$user = "postgres";
$password = "postgres";
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die('Connection failed: ' . pg_last_error());
}

$sql = "DELETE FROM bill WHERE bill_id='$id'";
$result = pg_query($conn, $sql);

if ($result) {
    header("Location: indexbill.php");
} else {
    echo "Not deleted";
}

?>
