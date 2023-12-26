<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$host = "localhost";
$port = "5432";
$dbname = "vehicle_management";
$user = "postgres";
$password = "postgres";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (isset($_POST["email"])) {
    $email = $_POST["email"];

    $mail = new PHPMailer(true);

    // SMTP Configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'vehiclemanagementsaru@.com'; // Your Gmail address
    $mail->Password = 'njlakxupoznlusmx'; // Your Gmail password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('vehiclemanagementsaru@gmail.com', 'sarumathi'); // Your name and email
    $mail->addAddress($email); // Recipient email
    $mail->isHTML(true);

    $mail->Subject = "Payment Successful";
    $mail->Body = "Confirmation page";

    try {
        if ($mail->send()) {
            echo "<script>alert('Email sent successfully');</script>";
            // Redirect to a success page if needed
        } else {
            echo 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
}
?>
