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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $_POST['name'];
    $value = $_POST['value'];

   
    $insert_query = "INSERT INTO random (name, value) VALUES ('$name', $value)";

    
    $insert_result = pg_query($connection, $insert_query);

   
    if (!$insert_result) {
        echo "Insertion failed: " . pg_last_error();
    } else {
        echo "Values inserted into 'random' table successfully";
    }
}


pg_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Random Table Form</title>
</head>
<body>

<h2>Random Table Form</h2>

<form action="" method="post">
    <label for="name">Name:</label>
    <input type="text" name="name" required>
    <br>

    <label for="value">Value:</label>
    <input type="number" name="value" required>
    <br>

    <input type="submit" value="Submit">
</form>

</body>
</html>
