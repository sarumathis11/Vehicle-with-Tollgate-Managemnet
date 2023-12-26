<?php
$host = "localhost";
$port = "5432";
$dbname = "vehicle_management";
$user = "postgres";
$password = "postgres";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Email sending code
$to = "karthika2004p@gmail.com";
$subject = 'Signup | Verification';
$message = 'balsal';
$headers = 'From: vehiclemanagementsaru@gmail.com' . "\r\n";

if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully!";
} else {
    echo "Email could not be sent.";
}

// Close the PostgreSQL connection
pg_close($conn);
?>
