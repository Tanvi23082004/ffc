<?php
  session_start();

 if(!isset($_SESSION['u_name'])){
 header("location: alogin.php"); 
}
 
 include_once "inc/dbh.inc.php";
 // Fetch total quantity of items ordered
 $sqlTotalQty = "SELECT SUM(qty) AS total_qty FROM foodorders";
 $resultQty = mysqli_query($con, $sqlTotalQty);
 $rowQty = mysqli_fetch_assoc($resultQty);
 $total_qty = $rowQty['total_qty'];

 // Fetch total price of all orders
 $sqlTotalPrice = "SELECT SUM(totalprice) AS total_price FROM foodorders";
 $resultPrice = mysqli_query($con, $sqlTotalPrice);
 $rowPrice = mysqli_fetch_assoc($resultPrice);
 $total_price = $rowPrice['total_price'];

 // Fetch count of unique restaurant names
 $sqlCountRname = "SELECT COUNT(DISTINCT rname) AS total_restaurants FROM restaurents";
 $resultCountRname = mysqli_query($con, $sqlCountRname);
 $rowCountRname = mysqli_fetch_assoc($resultCountRname);
 $total_restaurants = $rowCountRname['total_restaurants'];

 // Fetch all restaurant names
 $sqlListRname = "SELECT rname FROM restaurents";
 $resultListRname = mysqli_query($con, $sqlListRname);


$sqlTotalUsers = "SELECT COUNT(*) AS total_users FROM users";
$sqlTotalDeliveryBoys = "SELECT COUNT(*) AS total_delivery_boys FROM deliveryboy";
$sqlTotalDishes = "SELECT COUNT(*) AS total_dishes FROM foodlist";

// Execute queries
$resultUsers = mysqli_query($con, $sqlTotalUsers);
$resultDeliveryBoys = mysqli_query($con, $sqlTotalDeliveryBoys);
$resultDishes = mysqli_query($con, $sqlTotalDishes);

// Fetch the results
$total_users = 0;
$total_delivery_boys = 0;
$total_dishes = 0;

if ($resultUsers) {
    $rowUsers = mysqli_fetch_assoc($resultUsers);
    $total_users = $rowUsers['total_users'];
}

if ($resultDeliveryBoys) {
    $rowDeliveryBoys = mysqli_fetch_assoc($resultDeliveryBoys);
    $total_delivery_boys = $rowDeliveryBoys['total_delivery_boys'];
}

if ($resultDishes) {
  $rowDishes = mysqli_fetch_assoc($resultDishes);
  $total_dishes = $rowDishes['total_dishes'];
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width initial-scale=1">
  <title>Cloud Kitchen</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <script src="https://kit.fontawesome.com/041a644664.js" crossorigin="anonymous"></script>
</head>
<body>
    <!--navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">Cloud Kitchen</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <!-- <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="aboutus.php">About Us</a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="#contact">Contact Us</a>
      </li>
       
    </ul> -->

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="mr-2 d-none d-lg-inline text-gray-600 small">
            <?php echo $_SESSION['u_name']; ?>
          </span>
          <!-- <img class="img-profile rounded-circle" src="uploads/<?php echo $_SESSION['pic']; ?>" style="height: 2rem; width: 2rem;"> -->
        </a>
         <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
      </li>
    </ul>
  </div>
</nav>
    <!--end navigation-->
 <!--logout model-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below to end your current session</div>

        <form method="POST" action="inc/logout.inc.php">
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <button class="btn btn-danger" name="submit">Logout</button>
        </div>
      </form>

      </div>
    </div>
  </div>
 <!--logout model-->
 
<div class="jumbotron">
	<h1 style="font-size: 63px;">Hello admin <?php echo $_SESSION['u_name']; ?>!</h1>
	<!-- <p class="pt-3" style="font-size: 23px;">Manage Your Control Panel From Here</p> -->
  
</div>
 
 <div class="container">
    <div class="row pb-5">
      <!-- <div class="col-md-4 ">
            <div class="mylist list-group">
              <a href="dindex.php" class="list-group-item active">Live Status</a>
              <a href="dneworders.php" class="list-group-item ">New Orders</a>
            </div>    
      </div> -->

      <!-- <div class="col-md-8 pt-1 pb-3">
         <legend class="text-center" style="border:1px solid black; width: 100%; margin: 0 auto;">Ready to Ride?
          <?php
          //print_r($_SESSION);
           $dboy = $_SESSION['u_id'];
           $sql = "SELECT * FROM deliveryboy WHERE id='$dboy';";
           $result = mysqli_query($con, $sql);
           $resultcheck = mysqli_num_rows($result);
           if ($resultcheck > 0) {
          ?>
          <table class="table table-responsive-md mytbl text-center">
                <thead>
                <tr>
                <th>Name</th>
                <th>Acount Status</th>
                <th>Select Status</th>
                <th>Your Live Staus</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                <?php
                 while ($row = mysqli_fetch_assoc($result)) {
                  if ($row['status'] == 'yes') {
                    $new = 'active';
                    $active = 'green';
                  } else {
                    $new = 'suspended';
                    $active = 'red';
                  }  

                  if ($row['dstatus'] == 'Ready') {
                    $dnew = 'Ready';
                    $dactive = 'green';
                  } else {
                    $dnew = 'Not Ready';
                    $dactive = 'red';
                  }
                ?>  
                <td><?php echo $row['uname']; ?></td>
                <td><span style="color: <?php echo $active; ?>"><?php echo $new; ?></span></td>
                <td><a href="inc/dstatus.inc.php?id=<?php echo $dboy ?>&status=Ready&currentstatus=<?php echo $row['status']; ?>&type=success" class="btn btn-success btn-sm">Ready</a> <a class="btn btn-danger btn-sm" href="inc/dstatus.inc.php?id=<?php echo $dboy ?>&status=Not Ready&currentstatus=<?php echo $row['status']; ?>">Not Ready</a></td>
                <td><span style="color: <?php echo $dactive; ?>"><?php echo $dnew; ?></span></td>
                <?php
                 }
                ?>
                </tr>
                </tbody>
               </table> 
          <?php
           }
          ?>     
             </legend>
      </div> -->

    </div>
  </div>    
 
  <div class="container">
  <div class="row pb-5">
    <div class="col-md-12">
      <h2>Admin Dashboard</h2>

      <div class="d-flex justify-content-around mb-4">
        <p class="stat-item text-center py-2 px-4">
          <strong>Total Orders:</strong> <?php echo $total_qty; ?>
        </p>
        <p class="stat-item text-center py-2 px-4">
          <strong>Revenue:</strong> <?php echo $total_price; ?> INR
        </p>
        <p class="stat-item text-center py-2 px-4">
          <strong>Restaurants:</strong> <?php echo $total_restaurants; ?>
        </p>
        
      </div>

      <div class="d-flex justify-content-around mb-4">
      <p class="stat-item text-center py-2 px-4">
      <strong>Users:</strong> <?php echo $total_users; ?>
        </p>
        <p class="stat-item text-center py-2 px-4">
        <strong>Delivery Boys:</strong> <?php echo $total_delivery_boys; ?></p>
        <p class="stat-item text-center py-2 px-4">
        <strong>Food Dishes:</strong> <?php echo $total_dishes; ?></p>
        </div>

        <h3>List of Restaurants</h3>
<div class="overflow-auto" style="max-height: 160px;"> <!-- Adjust max-height as needed -->
    <ul class="list-group">
        <?php
        while ($rowRname = mysqli_fetch_assoc($resultListRname)) {
            echo "<li class='list-group-item'>" . $rowRname['rname'] . "</li>";
        }
        ?>
    </ul>
</div>

    </div>
  </div>
 
</div>

<style>
  .stat-item {
    background-color: #f8f9fa; /* Light background color */
    border: 2px solid #007bff; /* Border color */
    border-radius: 30px; /* Semi-circular ends */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Optional shadow for a 3D effect */
    transition: background-color 0.2s, transform 0.2s; /* Smooth color transition and scaling */
    flex: 1; /* Equal width for all buttons */
    margin: 0 10px; /* Space between buttons */
  }

  .stat-item:hover {
    background-color: #007bff; /* Change background color on hover */
    color: white; /* Change text color to white on hover */
    transform: scale(1.05); /* Slightly increase size on hover */
  }

  .list-group-item {
    background-color: #e9ecef; /* Light gray background */
    margin: 5px 0; /* Space between list items */
    transition: background-color 0.2s; /* Smooth color transition */
  }

  .list-group-item:hover {
    background-color: #007bff; /* Change to primary color on hover */
    color: white; /* Change text color to white on hover */
  }
</style>

</div>

<style>
  .stat-item {
    background-color: #f8f9fa; /* Light background color */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Optional shadow for a 3D effect */
    transition: transform 0.2s; /* Smooth scaling on hover */
  }

  .stat-item:hover {
    transform: scale(1.05); /* Slightly increase size on hover */
  }

  .list-group-item {
    background-color: #e9ecef; /* Light gray background */
    margin: 5px 0; /* Space between list items */
    transition: background-color 0.2s; /* Smooth color transition */
  }

  .list-group-item:hover {
    background-color: #007bff; /* Change to primary color on hover */
    color: white; /* Change text color to white on hover */
  }
</style>

  
</div>


<?php
 include "footer.php";
?>