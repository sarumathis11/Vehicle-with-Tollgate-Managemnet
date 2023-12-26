
     
<?php
  if(!isset($_SESSION)) {
    session_start();
}


$host = "localhost";
$port = "5432";
$dbname = "vehicle_management";
$user = "postgres";
$password = "postgres";

$connection = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$connection) {
    die("Connection failed: " . pg_last_error());
}
    if(isset($_SESSION['username'])==false) {
        
?>  
  
  <div class="container">
      
         <nav class="navbar navbar-inverse navbar-fixed-top gabanav">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
              </button>

            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
              <ul class="nav navbar-nav gabali">
                <li><a href="index.php">Home</a></li>
                <li><a href="buslist.php">Vehicle</a></li>
                <li><a href="driverlist.php">Driver</a></li>
                <li><a href="route.php">Watch Me!</a></li>
                <!-- <li><a href="schedule.php">Bus Schedule</a></li> -->
                <li><a href="tollgateaction.php">Toll Search</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="feedback.php">Feedback</a></li>
                <!-- <li><a href="update.php">Update</a></li> -->
                <li><a href="login.php">Tollgate</a></li>
                <!-- <li><a href="final.php">Final</a></li> -->
                
               
                

              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
              </ul>
            </div> 

            </div>   
        </nav>
             
      
       
  </div>
   
       
    <?php } else { ?> 
    <div class="container">
       <nav class="navbar navbar-inverse navbar-fixed-top gabanav">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
              </button>

            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
              <ul class="nav navbar-nav gabali">
                <li><a href="index.php">Home</a></li>
                <li><a href="buslist.php">Vehicle</a></li>
                <li><a href="driverlist.php">Driver</a></li>
                <li><a href="route.php">Watch me</a></li>
                <!-- <li><a href="schedule.php">Bus Schedule</a></li> -->
                <li><a href="tollgateaction.php">Toll Search</a></li>
                <li><a href="feedback.php">Feedback</a></li>
               
               
                <li><a href="sarubill.php?id=<?php echo $_SESSION['username']; ?>">My Account</a></td> 
                

              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li><a href="logout.php"><span class="glyphicon glyphicon-user"></span> Log Out</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Welcome <?php echo $_SESSION['username']; ?></a></li>
              </ul>
            </div> 

        </div> 
      
    </nav> 
    </div>
    
    
    <?php } ?> 
    
<style>

.navbar {
    background-color: black;
    color: white;
}

.navbar-inverse .navbar-nav > li > a {
    color: white;
}

.navbar-inverse .navbar-nav > li > a:hover,
.navbar-inverse .navbar-nav > li > a:focus {
    color: red; 
}

.navbar-inverse .navbar-right > li > a {
    color: white;
}

.navbar-inverse .navbar-right > li > a:hover,
.navbar-inverse .navbar-right > li > a:focus {
    color: #ccc; 
}
 
    
    
 </style>  
    
    