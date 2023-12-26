<?php
if (!isset($_SESSION)) {
    session_start();
}

// Assuming you have a PostgreSQL database connection, replace these variables with your actual connection details
$host = "localhost";
$port = "5432";
$dbname = "vehicle_management";
$user = "postgres";
$password = "postgres";

// Create a connection
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

// Check the connection
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Query to select all rows from the tollgate_feedback table
$sql = "SELECT * FROM tollgate_feedback";
$result = pg_query($conn, $sql);

// Close the database connection
pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="animate.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
   <?php include 'navbar_admin.php'?>
   <br><br>
   <div class="container">
       <div class="row">
           <div class="page-header">
               <h1 style="text-align: center">User feedback</h1>
           </div>
           <div class="col-md-2"></div>
           <div class="col-md-8">
               <table class="table table-bordered">
                   <thead>
                       <tr>
                           <th>ID</th>
                           <th>Vehicle Type</th>
                           <th>Date</th>
                           <th>Entry Time</th>
                           <th>Exit Time</th>
                           <th>Amount Paid</th>
                           <th>Feedback</th>
                       </tr>
                   </thead>
                   <tbody>
                       <?php
                       while ($row = pg_fetch_assoc($result)) {
                           echo "<tr>";
                           echo "<td>" . $row["id"] . "</td>";
                           echo "<td>" . $row["vehicle_type"] . "</td>";
                           echo "<td>" . $row["date"] . "</td>";
                           echo "<td>" . $row["entry_time"] . "</td>";
                           echo "<td>" . $row["exit_time"] . "</td>";
                           echo "<td>" . $row["amount_paid"] . "</td>";
                           echo "<td>" . $row["feedback"] . "</td>";
                           echo "</tr>";
                       }
                       ?>
                   </tbody>
               </table>
           </div>
           <div class="col-md-2"></div>
       </div>
   </div>
</body>
</html>
