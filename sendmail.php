<?php
    
    $connection = pg_connect("host=localhost port=5432 dbname=vehicle_management user=postgres password=postgres");
    session_start();
    
    $id= $_GET['id'];

    $sql= "SELECT * FROM booking WHERE booking_id='$id'"; 

    
    $res= pg_query($connection, $sql);
    $row= pg_fetch_assoc($res);

if(isset($_POST['email'])) {
 
    $email_to = $row['email'];
    
    
    
    $first_name = $row['name']; 
    $email_from = "vehiclemanagementsaru@gmail.com"; 
    $telephone = $row['mobile']; 
    $driver_id= $_POST['driverid'];
    //echo $driver_id;
    
    $veh_reg= $_POST['veh_reg'];

        // Validate input data
        if (!is_numeric($driver_id) || empty($veh_reg)) {
            // Handle invalid input
            echo "Invalid input data.";
            exit;
        }
    
    $sql2="SELECT * FROM driver WHERE driverid='$driver_id'";
    $res2= pg_query($connection, $sql2);
    $row2= pg_fetch_assoc($res2);
    
    $driver_name=$row2['drname'];
    $driver_mobile=$row2['drmobile'];
    //echo $driver_name;
    //echo $driver_mobile;
     
    $email_message = " This is an email form RUET Vehicle Management to confirm your vehicle. Details are given below.\n\n";
 
    function clean_string($string) {
        $bad = array("content-type","bcc:","to:","cc:","href");
        return str_replace($bad,"",$string);
    }
 
    $email_message .= "first Name: ".clean_string($first_name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Phone: ".clean_string($telephone)."\n\n";
    $email_message .= "Driver's Name: ".clean_string($driver_name)."\n";
    $email_message .= "Vehicle Regitration: ".clean_string($veh_reg)."\n";
    $email_message .= "Driver's Phone Number: ".clean_string($driver_mobile)."\n";
 
    $headers = 'From: '.$email_from."\r\n".
               'Reply-To: '.$email_from."\r\n" .
               'X-Mailer: PHP/' . phpversion();
 
    @mail($email_to, $email_subject, $email_message, $headers); 
    
    $update_query="UPDATE booking SET confirmation='1', veh_reg='$veh_reg', driverid='$driver_id' WHERE booking_id='$id'; UPDATE vehicle SET veh_available='1' WHERE veh_reg='$veh_reg';UPDATE driver SET dr_available='1' WHERE driverid='$driver_id'";
    
    $res3=pg_query($connection, $update_query);  //to run multiple query
 
?>
 
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <title>success</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
     <link rel="stylesheet" href="animate.css">
     <link rel="stylesheet" href="style.css">
 </head>
 <body>
   <?php include 'navbar_admin.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
               <br><br><br><br><br>
                <div class="alert alert-success animated tada">
                      <strong>Success!</strong> Mail has been sent successfully.
                </div>
                
                <a class="btn btn-default" href="bookinglist.php">Go Back</a>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
     
 </body>
 </html>
 <?php
}
 
?>
