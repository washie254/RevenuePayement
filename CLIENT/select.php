<?php
  include('server.php');
	//session_start(); 

	if (!isset($_SESSION['username'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: login.php');
	}

	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header("location: login.php");
	}

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Smart Revenue</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="index.php">Smart Revenue</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->

    <?php
      $phone =$_SESSION['username'];
      $sql = "SELECT * FROM member WHERE mobile_number = '$phone'";
      $result = mysqli_query($db, $sql);

      while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $fname= strtoupper($row[1]);
        $names = $row[1]." ".$row[2];
        $phone = $row[3];
        $ver = $row[5];
        $email = $row [6];
        $evar = $row[8];
        $street = $row[10];
      }
      if($evar == 0){
        $stat = 'NOT VERIFIED';
      }elseif($evar==1){
        $stat = 'VERIFIED';
      }
      else{
        $stat = 'ERROR VERIFYING ACCOUNT';
      }
    ?>

  
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php  echo $phone." ".$fname; ?> <i class="fas fa-user-circle fa-fw"> </i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="makepayment.php">Make Payments</a>
          <a class="dropdown-item" href="#">Payment History</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="makepayment.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Make Payment</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-fw fa-table"></i>
          <span>Payment History</span></a>
      </li>
    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">PAYMENT SECTION</a>
          </li>
          <!-- <li class="breadcrumb-item active">SECTION</li> -->
        </ol>

        <div class="container">
            <div class="card card-register mx-auto mt-5">
            <div class="card-header">Select a package</div>
            <div class="card-body">
                <style>
                .error {
                    width: 92%; 
                    margin: 0px auto; 
                    padding: 10px; 
                    border: 1px solid #a94442; 
                    color: #a94442; 
                    background: #f2dede; 
                    border-radius: 5px; 
                    text-align: left;
                }
                </style>
                <form method="post" action="select.php">
                <?php include('errors.php'); ?>
                
                <div class="form-group">
                    <div class="form-label-group">
                    <select type="email" id="inputStreet" name="package" class="form-control" required="required">
                        <option value="Monthly">Monthly Package  </option>
                        <option value="Weekly">Weekly Package</option>
                        <option value="Daily">Daily Package </option>
                    </select>
                    <!-- <label for="inputEmail">Select Street</label> -->
                    </div>
                    <input type="text" name="tel" value="<?=$_SESSION["username"]?>" style="opacity:0;"/>
                </div>
                
                <button class="btn btn-primary btn-block" type="submit" name="select_pkg">Select Package</button>
                </form>
                <div class="text-center">
                <!-- <a class="d-block small mt-3" href="login.php">Login Page</a> -->
                <!-- <a class="d-block small" href="forgot-password.php">Forgot Password?</a> -->
                </div>
            </div>
            </div>
        </div>



      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Your Website 2019</span>
          </div>
        </div>
      </footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="index.php?logout='1'">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/datatables-demo.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>

</body>

</html>
