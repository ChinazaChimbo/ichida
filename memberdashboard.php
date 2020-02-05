<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['member'])) {
        header('Location:index.php');
    }
    $member = $_SESSION['member'];
    $getmember = mysqli_query($con, "SELECT * FROM members WHERE id = '".$_SESSION['member']."'");
    while ($got = mysqli_fetch_assoc($getmember)) {
        $pass = $got['password'];
    }
    if ($pass == "12345") {
        header("Location:memchpass.php");
    }
    $getunpaid = mysqli_query($con, "SELECT * FROM levy WHERE member_id='".$member."' AND paid = FALSE ");
    $getpaid = mysqli_query($con, "SELECT * FROM levy WHERE member_id='".$member."' AND paid = TRUE ");

    $totun=0;
    $totp = 0;
    while ($a = mysqli_fetch_assoc($getunpaid)) {
      $amount = $a['amount'];

      $totun += $amount;
    }
    while ($b = mysqli_fetch_assoc($getpaid)) {
      $amount = $a['amount'];

      $totp += $amount;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ichida Progress Union | Dashboard</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <title> <?php echo $fname?> - Dashboard</title>

  <!-- Custom fonts for this template-->
  <?php
        require 'includes/header.php';
    ?>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php
        require 'includes/memsidebar.php';
    ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php
        require 'includes/topbar.php';
    ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Debts</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">&#8358;<?php echo $totun?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total paid</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">&#8358;<?php echo $totp?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            

            <!-- Pending Requests Card Example -->
          
              <!-- Color System -->
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
     <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; IPU 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <?php
        require 'includes/logoutmodal.php';
    ?>

  <!-- Bootstrap core JavaScript-->
 <?php
        require 'includes/scriptstables.php';
    ?>

<script>
    $(document).ready(function() {
    $('#unpaid').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'print'
        ]
    } );
} );
</script>
</body>

</html>