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

  $user = $_SESSION["username"];
  $query = "SELECT * FROM staff WHERE username='$user'";
  $result = mysqli_query($db, $query);
  while($rowz = mysqli_fetch_array($result,MYSQLI_NUM)){
    $category = $rowz[6];
    $username = $rowz[1];
    $firstname = $rowz[2];
    $lastname = $rowz[3];
    $email = $rowz[4];
    $phone =$rowz[5];
    $description =$rowz[7];
    $status = $rowz[9]; 
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
    $user =$_SESSION['username'];
    $sql = "SELECT * FROM staff WHERE username = '$user'";
    $result = mysqli_query($db, $sql);

    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
      $uname= $row[1];
      $tuname= strtoupper($row[1]);
      $names = $row[2]." ".$row[3];
      $phone = $row[5];
      $email = $row[4];
      $dept = $row[6];
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
        <?php  echo $phone." ".$tuname; ?> <i class="fas fa-user-circle fa-fw"> </i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <?php
            if($category =='Finance'){

              echo '<a class="dropdown-item" href="#">Operations </a> ';
            }
            else if($category=='Field'){
                echo '
                    <a class="dropdown-item" href="#">View Users</a>
                ';
            }else{
              echo'
                  <a class="dropdown-item" href="#">cannot resolve dept </a>
              ';
            }
          ?>
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

      <?php
            if($category =='Finance'){

              echo '
                <li class="nav-item">
                  <a class="nav-link" href="successful.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Successful Transactions</span></a>
                </li>
                <li class="nav-item active">
                  <a class="nav-link" href="failed.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Failed Transactions</span></a>
                </li>
              ';
            }
            else if($category=='Field'){
                echo '
                  <li class="nav-item">
                    <a class="nav-link" href="#">
                      <i class="fas fa-fw fa-users"></i>
                      <span>View Users</span></a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link" href="#">
                      <i class="fas fa-fw fa-chart-area"></i>
                      <span>Users Search</span></a>
                  </li>
                ';
            }else{
              echo'
                <li class="nav-item">
                  <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Canot identify u Sorry !!</span></a>
                </li>
              ';
            }
          ?>
    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Overview</li>
        </ol>

        <!-- Icon Cards-->
       

        <!-- Area Chart Example-->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-chart-area"></i>
            Account Information
          </div>
          <div class="card-body">
          <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Tr. id# </th>
                  <th>Result Code</th>
                  <th>Checkout Request ID </th>
                  <th>state</th>
                  <th>datetime</th>
                  <th>Description</th>
                </tr>
              <thead>
              <?php
                $sql0 = "SELECT * FROM mpesa WHERE resultCode !='0' ORDER BY phoneNumber, amount";
                $result0 = mysqli_query($db, $sql0);

                while($row = mysqli_fetch_array($result0, MYSQLI_NUM)){
                    $id= $row[0];
                    $resultcode = $row[1];
                    $checkoutreqid = $row[4];
                    $datetime= $row[10];
                    $state = $row[9];
                    $resDesc = $row[2];
                
                    echo '
                        <tr>
                            <td>'.$id.'</td>
                            <td>'.$resultcode.'</td>
                            <td>'.$checkoutreqid.'</td>
                            <td>'.$state.'</td>
                            <td>'.$datetime.' </td>
                            <td>'.$resDesc.' </td>
                        </tr>';
                }
            ?>

            </table>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>

   

      </div>
      <!-- /.container-fluid -->

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
