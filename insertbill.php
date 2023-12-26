

<?php
use function PHPSTORM_META\type;


$connection = pg_connect('host=localhost port=5432 dbname=vehicle_management user=postgres password=postgres');
$msg = "";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $department = $_POST['department'];
    $type = $_POST['type'];
    $req_date = $_POST['req_date'];
    $req_time = $_POST['req_time'];
    $return_date = $_POST['return_date'];
    $return_time = $_POST['return_time'];
    $destination = $_POST['destination'];
    $pickup = $_POST['pickup'];
    $reason = $_POST['reason'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $username = $_POST['username'];

    
    $confirmation = isset($_POST['confirmation']) ? $_POST['confirmation'] : 0;
    $veh_reg = isset($_POST['veh_reg']) ? $_POST['veh_reg'] : '';
    $driverid = isset($_POST['driverid']) ? $_POST['driverid'] : 0;
    $finished = isset($_POST['finished']) ? $_POST['finished'] : 0;

    
    $insert_query = "INSERT INTO bill (name, username, department, type, req_date, req_time, ret_date, ret_time, destination, pickup_point, resons, email, mobile, confirmation, veh_reg, driverid, finished, paid) 
                VALUES ('$name', '$username', '$department', '$type', '$req_date', '$req_time', '$return_date', '$return_time', '$destination', '$pickup', '$reason', '$email', $mobile, $confirmation, '$veh_reg', $driverid, $finished, 0)";


    $res = pg_query($connection, $insert_query);

    if ($res == true) {
        $msg = "<script language='javascript'>
                swal(
                    'Success!',
                    'bill Completed!',
                    'success'
                );
                </script>";
    } else {
        die('Unsuccessful: ' . pg_last_error($connection));
    }
    }



?>


<?php
   $conn = pg_connect('host=localhost dbname=vehicle_management user=postgres password=postgres');
   $sql = "SELECT * FROM bill ";
   $result = pg_query($conn, $sql);
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Insert</title>

  
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="animate.css">
    <link rel="stylesheet" href="style.css">

    
  </head>
  <body>
    
    <br><br><br>
     
    <div class="container">
      <div class="row">
        <div class="col-md-2">
          <a class="btn btn-info" href="indexbill.php">Bill List</a>
        </div> 
        <div class="col-md-8 animated flash">
        <h2>Billing</h2>
        <hr>

        <form action="storebill.php?busid=<?php echo $veh_id; ?>" method="POST">
        

        <div class="form-group">
          <label for="Roll">Service Charge :</label>
          <input required type="text" class="form-control" name="salary" placeholder="Service Charge">
        </div>
        
        <div class="form-group">
          <label for="Age">Equipment :</label>
          <input type="text" class="form-control" name="equipment" placeholder="Equipment">
        </div>

        <div class="form-group">
          <label for="Address">Oil :</label>
          <input type="text" class="form-control" name="oil" placeholder="Oil">
        </div>

        <div class="form-group">
          <label for="Mobile">Total cost :</label>
          <input type="text" class="form-control" name="tcost" placeholder="Total cost">
        </div>
        <button type="submit" class="btn btn-info">Submit</button>
      </form>
        
        </div>
      </div>
    </div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html> 