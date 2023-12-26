<?php

$id = $_GET['busid'];
$salary = $_POST['salary'];
$equipment = $_POST['equipment'];
$oil = $_POST['oil'];
$tcost = $_POST['tcost'];

$conn = pg_connect("host=localhost port=5432 dbname=vehicle_management user=postgres password=postgres");
$sql = "INSERT INTO bill VALUES(DEFAULT, '$id', '$salary', '$equipment', '$oil', '$tcost')";

if (pg_query($conn, $sql)) {
    $msg = "<script language='javascript'>
               swal(
                   'Success!',
                   'Registration Completed!',
                   'success'
                );
            </script>";

    header("Location: indexbill.php");
} else {
    echo "Not inserted";
}
?>
