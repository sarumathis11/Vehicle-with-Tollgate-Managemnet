<?php
if (!isset($_SESSION)) {
    session_start();
}


$host = "localhost";
$port = "5432";  
$dbname = "vehicle_management";
$user = "postgres";
$password = "postgres";

$connection = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

$username = $_SESSION['username'];

$query = "SELECT first_name, last_name, email FROM user1 WHERE username='$username'";
$result = pg_query($connection, $query);

$row = pg_fetch_assoc($result);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
     <link rel="stylesheet" href="css/wickedpicker.min.css">
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
     <link rel="stylesheet" href="sweetalert2/sweetalert2.css">
    <script src="sweetalert2/sweetalert2.min.js"></script>
    
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="js/wickedpicker.min.js"></script>
    <link rel="stylesheet" href="animate.css">
    <link rel="stylesheet" href="style.css">
</head>
<style>
    .navbar-fixed-top.scrolled {
   background-color: ghostwhite;
  transition: background-color 200ms linear;
}    
</style>

<body>
    <?php include 'navbar.php'; ?>
    <br>
    <div class="container">
        <div class="row">
            <div class="page-header">
                <h1 style="text-align:center;">Booking</h1>
                 <?php //echo $msg; ?>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form class="animated bounce" action="bookingaction.php" method="post">
                    <div class="input-group">
                      <span class="input-group-addon"><b>Name</b></span>
                      <input id="name" type="text" class="form-control" name="name" value="<?php echo isset($_SESSION['signup_name']) ? $_SESSION['signup_name'] : ''; ?>"  required>
                    </div>
                    
                    <br>
<div class="input-group">
    <span class="input-group-addon"><b>State</b></span>
    <input id="department" type="text" class="form-control" name="department" placeholder="State"  required>
</div>

                    <br>
                    <div class="input-group">
                      <span class="input-group-addon"><b>Vehicle Type</b></span> &nbsp;
                      <label><input type="radio" name="type" value="car">Car</label> &nbsp;
                      
                    </div>
                    <br>
                    <div class="input-group">
                      <span class="input-group-addon"><b>Time of Starting</b></span>
                      <input id="req_date" type="text" class="form-control" name="req_date" placeholder="dd/mm/yy" required>
                      <input type="text" name="req_time" id="req_time" class="form-control"/>
                      
                    </div>
                    
                    <script>
                      $( function() {
                        $( "#req_date" ).datepicker();
                        $("#req_time").wickedpicker();
                        
                      } ); 
                        
                        
                        
                    </script> 
                    <br>
                    
                    <div class="input-group">
                      <span class="input-group-addon"><b>Time of Finishing</b></span>
                      <input id="return_date" type="text" class="form-control" name="return_date" placeholder="dd/mm/yy" required>
                      <input type="text" name="return_time" id="return_time" class="form-control"/>
                    </div>
                    
                    <script>
                      $( function() {
                        $( "#return_date" ).datepicker();
                        $( "#return_time" ).wickedpicker();
                      } );
                    </script>
                    <br>
                    
                    <div class="input-group">
                      <span class="input-group-addon"><b>Starting Point</b></span>
                      <input id="pickup" type="text" class="form-control" name="pickup" placeholder="Starting point">
                    </div>
                    <br>

                    <div class="input-group">
                      <span class="input-group-addon"><b>Destination</b></span>
                      <input id="destination" type="text" class="form-control" name="destination" placeholder="Destination" required>
                    </div>
                    <br>
                    
                    
                    
                    <div class="input-group">
                        <span class="input-group-addon"><b>Route</b></span>
                        <input id="route" type="text" class="form-control" name="route" placeholder="For reference go to toll search in the above" required>
                    </div>
                    <br>
          

                    <div class="input-group">
                      <span class="input-group-addon"><b>Reason for journey</b></span>
                      <input id="reason" type="text" class="form-control" name="reason" placeholder="Reason">
                    </div>
                    <br>
                    
                    <div class="input-group">
                      <span class="input-group-addon"><b>Email</b></span>
                      <input id="email" type="email" class="form-control" name="email" value="<?php echo isset($_SESSION['signup_email']) ? $_SESSION['signup_email'] : '';  ?>" required>
                    </div>
                    <br>
                    
                    <div class="input-group">
                      <span class="input-group-addon"><b>Mobile</b></span>
                      <input id="mobile" type="text" class="form-control" name="mobile" placeholder="Mobile No" required>
                    </div>
                    <br>
                    
                    <input type="hidden" name="username" value="<?php echo $username; ?>">
                    
                    <div class="input-group">
                        <input type="submit" name="submit" class="btn btn-success">
                    </div>
                     
                    
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
    <script>
    $(function () {
        $("#req_date").datepicker();
        $("#req_time").wickedpicker();
        $("#return_date").datepicker();
        $("#return_time").wickedpicker();
    });

    function pay() {
        // Here you can add server-side logic to process the payment
        // For simplicity, we'll just show a SweetAlert2 message

        Swal.fire({
            title: "Paid Successfully",
            text: "Amount: ${paymentAmount} paid successfully! Congratulations!",
            icon: "success",
        });

        // After successful payment, update the button appearance
        $("#payButton").removeClass("btn-primary").addClass("btn-success").text("Paid");
    }
</script>

<script>
    $(function () {
      $(document).scroll(function () {
      var $nav = $(".navbar-fixed-top");
      $a= $(".navbar-fixed-top");
      $nav.toggleClass('scrolled', $(this).scrollTop() > $a.height());
  });
}); 
    
</script>  


</body>
</html>
