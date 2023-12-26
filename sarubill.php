<?php 
    if (!isset($_SESSION)) {   
        session_start(); 
    } 
    $id = $_GET['id'];

    $host = "localhost";
    $port = "5432";
    $dbname = "vehicle_management";
    $user = "postgres";
    $password = "postgres";

    $connection = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");


    $sql = "SELECT * FROM booking WHERE username='$id'";
$res = pg_query($connection, $sql);
$row = pg_fetch_assoc($res);

$sql1 = "SELECT * FROM vehicle WHERE veh_available='0'";
$res1 = pg_query($connection, $sql1);

$sql2 = "SELECT * FROM driver WHERE dr_available='0'";
$res2 = pg_query($connection, $sql2);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bill</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
     <script src="https://unpkg.com/scrollreveal/dist/scrollreveal.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./slick/slick.css">
    <link rel="stylesheet" type="text/css" href="./slick/slick-theme.css"> 
   
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="animate.css">
    <link rel="stylesheet" href="style.css">
   
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <script src="phpqrcode\qrlib.php"></script>
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container">
        <div class="row">
            <div class="page-header">
                <h1 style="text-align: center;">My Bill</h1>
            </div>
        </div>
        
    
            
    <div class="col-md-12">
    <p><strong>Booking Id: </strong><?php echo $row['booking_id']; ?></p> 
                
               
                <p><strong>Customer Name: </strong><?php echo $row['name']; ?></p> 
                
                
                <p><strong>Requested Date: </strong><?php echo $row['req_date']; ?></p> 
                
                
                <p><strong>Requested Time: </strong><?php echo $row['req_time']; ?></p> 
                
                
                <p><strong>Return Date: </strong><?php echo $row['ret_date']; ?></p> 
                
                
                <p><strong>Return Time: </strong><?php echo $row['ret_time']; ?></p> 
                
                
                <p><strong>Destination: </strong><?php echo $row['destination']; ?></p> 
                
                
                <p><strong>PickUp Point: </strong><?php echo $row['pickup_point']; ?></p> 
                
                
                <p><strong>Email: </strong><?php echo $row['email']; ?></p> 
                
                
                <p><strong>Mobile: </strong><?php echo $row['mobile']; ?></p> 
                
                <p><strong>Vehicle registration: </strong><?php echo $row['veh_reg']; ?></p>

                <p><strong>Driver : </strong><?php echo $row['driverid']; ?></p>
              
<button onclick="displayPhoto()" class="btn btn-info">GET QR</button>


<div id="photoContainer" style="display: none;">
    <img id="photoImage" src="" alt="Photo">
</div>

<script>
    function displayPhoto() {
     
        var photoImagePath = 'picture/qr.png';

       
        $('#photoImage').attr('src', photoImagePath);
        $('#photoContainer').show();
    }
</script>

            
            
            <button onclick="printBill()" class="btn btn-primary">Print Bill</button>
        </div>
    </div>
    
     <script>
        
       
        var bookingId = <?php echo $row['booking_id']; ?>;
        new QRCode(document.getElementById("qrcode"), {
            text: bookingId.toString(),
            width: 128,
            height: 128
        });

       
        $(document).ready(function() {
           
            function checkPaymentStatus() {
               
                var isPaid = true;

                if (isPaid) {
                   
                    $("#paidMessage").show();
                }
            }


            setInterval(checkPaymentStatus, 5000);
        });

        function printBill() {
            window.print();
        }
    </script>

</body>
</html>


