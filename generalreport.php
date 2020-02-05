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
  $paid = 0;
  while ($p = mysqli_fetch_assoc($getallpaid)) {
    $amount = $p['amount'];
    $paid += $amount;
  }

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

  $credit2 = 0;
  $getusers = mysqli_query($con, "SELECT * FROM members");
  while ($gu = mysqli_fetch_assoc($getusers)) {
    $gucredit = $gu['credit'];

    $credit2 += $gucredit;
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
<?php
        require 'includes/header.php';
    ?>
  <title>IPU - General Report</title>

  <!-- Custom fonts for this template-->
  
</head>

<body id="page-top">
    <form>
      <input type="hidden" name="url" value="<?php echo $url?>" id="url">
    </form>
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
          <div class="card shadow mb-4">
            <div class="card-header py-3"><h6><p class="text-center"><input type="button" id="printbtn" class="btn btn-primary" onclick="printDiv('box')" value="Print" /></p></h6>
            </div>
            <div id="box"> 
            <div class="card-body">

              <h1><img src="images/header.jpg" alt="header" style="width:100%;height:150px;"></h1>
              <p class="text-center"><u><h4>IPU Town System Manager Report</h4></u></p> 
            <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                    <th>#</th>
                                      <th>Report</th>
                                      <th>Total Amount</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                <th>#</th>
                                  <th>Report</th>
                                  <th>Total Amount</th>
                                </tr>
                                  </tfoot>
                                <tbody>
                                <tr>
                                          <td>1</td>
                                          <td>Total Amount Owed by Debtors</td>
                                          <td>&#8358;<?php echo $debit?></td>
                                        </tr>
                                        <tr>
                                          <td>2</td>
                                          <td>Total Amount of Paid Levies</td>
                                          <td>&#8358;<?php echo $paid?></td>
                                        </tr>
                                        <tr>
                                          <td>3</td>
                                          <td>Income</td>
                                          <td>&#8358;<?php echo $totalinc?></td>
                                        </tr>
                                        <tr>
                                          <td>4</td>
                                          <td>Expenses</td>
                                          <td>&#8358;<?php echo $totalexp?></td>
                                        </tr>
                                        <tr>
                                          <td>5</td>
                                          <td>Total Credit</td>
                                          <td>&#8358;<?php echo $credit2?></td>
                                        </tr>
                                </tbody>
                            </table>
                           
              </div></div>
        <p class="text-center"><input type="button" id="printbtn" class="btn btn-primary" onclick="printDiv('box')" value="Print" />
        <!-- /.container-fluid -->
            </div>
      </div>
      <!-- End of Main Content -->

        
      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
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
<?php
        require 'includes/scripts.php';
    ?>
</body>

</html>
