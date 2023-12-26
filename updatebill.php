<?php
$id = $_POST['id'];
$salary = $_POST['salary'];
$equipment = $_POST['equipment'];
$oil = $_POST['oil'];
$tcost = $_POST['tcost'];

$conn = pg_connect("host=localhost port=5432 dbname=vehicle_management user=postgres password=postgres");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

$sql = "UPDATE bill SET id='$id', salary='$salary', equipment='$equipment', oil='$oil', tcost='$tcost' WHERE id='$id'";

if (pg_query($conn, $sql)) {
    header("Location: showbill.php?id=" . $id);
} else {
    echo "Not updated";
}
?>
