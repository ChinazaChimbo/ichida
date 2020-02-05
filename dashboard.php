<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }
    $debit = 0;
    $getlevies = mysqli_query($con, "SELECT * FROM levy WHERE paid = FALSE");
    while($a = mysqli_fetch_assoc($getlevies)){
        $aamount = $a['amount'];

        $debit += $aamount;
    }
    
    $getalllevies = mysqli_query($con, "SELECT * FROM levy");
    $alllevy = mysqli_num_rows($getalllevies);
    $getallpaid = mysqli_query($con, "SELECT * FROM levy WHERE paid = TRUE");
    $paid = mysqli_num_rows($getallpaid);
    $percent = ceil(($paid/$alllevy) * 100);

    $totalinc = 0;
    $getcash = mysqli_query($con, "SELECT * FROM cash");
    while ($cashes = mysqli_fetch_assoc($getcash)) {
      $cashamount = $cashes['amount'];

      $totalinc += $cashamount;
    }

    $totalexp = 0;
    $getexp = mysqli_query($con, "SELECT * FROM expense");
    while ($c = mysqli_fetch_assoc($getexp)) {
      $camount = $c['amount'];
      $totalexp += $camount;
    }

    $credit = $totalinc - $totalexp;

    $totalbank = 0;
    $getbank = mysqli_query($con, "SELECT * FROM account");
    while ($d = mysqli_fetch_assoc($getbank)) {
      $dbalance = $d['balance'];
      $totalbank += $dbalance;
    }

    $totalcash = $totalbank + $credit;
 
    $totalincomer = $totalcash + $totalexp;

    $totalfresh = $totalcash / $totalincomer;
    $totalper = $totalfresh * 100;
    $totalexpper = $totalexp / $totalincomer;
    $totalpercent = $totalexpper * 100;
 
$dataPoints = array( 
  array($totalper),
  array($totalpercent)
  )
?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ichida Progress Union | Admin Dashboard</title>
    <?php
        require 'includes/header.php';
    ?>
  <meta name="description" content="">
  <meta name="author" content="">
  <script>
  window.onload = function() {
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["Income", "Expenses"],
    datasets: [{
      data: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>,
      backgroundColor: ['#4e73df', '#1cc88a'],
      hoverBackgroundColor: ['#2e59d9', '#17a673'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});
}

</script>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php
    require 'includes/sidebar.php';
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

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#report"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                </div>
                <div class="modal fade" id="report" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Select Report Type </h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body align-items-center">
        <select class="form-control" id="subjects">
            <option value="">Choose Report</option>
            <option value="http://ichidaprogressunion.org/generalreport.php">General Report</option>
            <option value="http://ichidaprogressunion.org/mem234.php">Membership Report</option>
            <option value="http://ichidaprogressunion.org/increport.php">Income Report</option>
            <option value="http://ichidaprogressunion.org/expreport.php">Expense Report</option>
        </select>
        <br>
        <div class="text-center"><input class="btn btn-success" type="button" value="Proceed" onclick="showPage()"  /></div></div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        
        </div>
      </div>
    </div>
  </div>
                <div class="row">

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Debts</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">&#8358;<?php echo $debit?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-money-check-alt fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total levies paid</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php 
                        if(!is_nan($percent)){
                            echo $percent;
                        }else{
                            echo "0";
                        }
                        ?>%</div>
                        </div>
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                          <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $percent?>%" aria-valuenow="<?php echo $percent?>" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
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
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Cash at Hand ((Cash + Cheque) - (Deposit + Expenses))</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">&#8358;<?php echo $credit?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-cash-register fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Bank Balance (All Account)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">&#8358;<?php echo $totalbank?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-piggy-bank fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Cash (Cash at hand + Bank Balance)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">&#8358;<?php echo $totalcash?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-money-bill-alt fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div></div>
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Accounting Chart</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> Income
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> Expenses
                    </span>
                    
                  </div>
                </div>
              </div>
            </div>
            </div>
            



            <!-- Earnings (Monthly) Card Example -->
            

            <!-- Pending Requests Card Example -->
          <!-- Content Row -->

          
        <!-- /.container-fluid -->

      </div></div>
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

  
 <?php
    require 'includes/logoutmodal.php';
?>
  <!-- Logout Modal-->
  

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="http://code.jquery.com/jquery-3.0.0.min.js"></script>
<script>
   function showPage() {
  var sel = document.getElementById('subjects');

  var option = sel.options[sel.selectedIndex].value;

  window.open(option, "_self");
}
</script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
   <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
</body>

</html>
