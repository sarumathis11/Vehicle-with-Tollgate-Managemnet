<?php
session_start();
$connection = pg_connect('host=localhost port=5432 dbname=vehicle_management user=postgres password=postgres');

if (!$connection) {
    die("Connection failed: " . pg_last_error());
}

$select_query = "SELECT * FROM tollgate ORDER BY tollgateid";
$result = pg_query($connection, $select_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Toll Gate List</title>
    <!-- Include your CSS and JS files here -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            padding: 10px;
            text-align: center;
            color: white;
            font-size: 24px;
        }

        .container {
            margin-top: 50px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        input[type="text"] {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .search-container {
            text-align: center;
        }

        .navbar {
            background-color: #333;
            color: white;
            padding: 15px;
        }

.navbar ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

.navbar li {
    display: inline-block;
    margin-right: 20px;
}

.navbar a {
    color: white;
    text-decoration: none;
}       
    .navbar-nav.gabali {
        margin: 0; 
    }

    .navbar-nav.navbar-right {
        margin-right: 0; 
    }
/* styles.css */

.navbar {
    background-color: black;
    color: white;
}

.navbar-inverse .navbar-nav > li > a {
    color: white;
}

.navbar-inverse .navbar-nav > li > a:hover,
.navbar-inverse .navbar-nav > li > a:focus {
    color: red; /* Change color on hover/focus if desired */
}

.navbar-inverse .navbar-right > li > a {
    color: white;
}

.navbar-inverse .navbar-right > li > a:hover,
.navbar-inverse .navbar-right > li > a:focus {
    color: #ccc; /* Change color on hover/focus if desired */
}

    </style>
</head>

<body>
<?php include 'navbar.php';?>
<?php
  
    if(isset($_SESSION['username'])==false) {
        
?>  
  
 
      
        
   
       
    <?php } else { ?> 
   
    
    <?php } ?> 
    
    
    
    
   
    
    
<header>
Toll Gate List
</header>
<i class="fa-sharp fa-solid fa-arrow-left"></i>
<i class="fas fa-arrow-left back-arrow" onclick="redirectToHome()"></i>
</header>

<div class="container">
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search...">
    </div>

    <table id="myTable" class="table table-bordered animated bounce">
        <thead>
        <th>Tollgate ID</th>
        <th>State</th>
        <th>Tollgate Number</th>
        <th>Toll Name</th>
        <th>Toll KM</th>
        <th>Section</th>
        </thead>

        <tbody>
        <?php while ($row = pg_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['tollgateid']; ?></td>
                <td><?php echo $row['state']; ?></td>
                <td><?php echo $row['tollgatenumber']; ?></td>
                <td><?php echo $row['tollname']; ?></td>
                <td><?php echo $row['tollkm']; ?></td>
                <td><?php echo $row['section']; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</div>

<script>
    $(document).ready(function () {
        $('#myTable').dataTable();

        $('#searchInput').on('keyup', function () {
            var value = $(this).val().toLowerCase();
            $('#myTable tbody tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
    function redirectToHome() {
        window.location.href = 'index.php';
    }
</script>
</body>
</html>
