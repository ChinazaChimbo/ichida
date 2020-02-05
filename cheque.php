<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }
    if (isset($_GET['bounce'])) {
      $bid = mysqli_real_escape_string($con, $_GET['bounce']);
      $getcheque = mysqli_query($con, "SELECT * FROM cheque WHERE id = '".$bid."'");
      while ($got = mysqli_fetch_assoc($getcheque)) {
        $gid = $got['id'];
        $gby = $got['by_user'];
        $cno = $got['check_no'];
        $amount = $got['amount'];
        $date = $got['date'];
        $bounced = $got['bounced'];
      }
      $bounce = mysqli_query($con, "UPDATE cheque SET bounced = TRUE WHERE id='".$gid."'");
      $inlog = mysqli_query($con, "INSERT INTO bank_log VALUES('', 'Bounced Cheque', '".$gby."', 'Expenditure', '".$amount."', 'Cash', '".$date."')");
      header("Location:cheque.php");
    }

    if (isset($_GET['unbounce'])) {
      $bid = mysqli_real_escape_string($con, $_GET['unbounce']);
      $getcheque = mysqli_query($con, "SELECT * FROM cheque WHERE id = '".$bid."'");
      while ($got = mysqli_fetch_assoc($getcheque)) {
        $gid = $got['id'];
        $gby = $got['by_user'];
        $cno = $got['check_no'];
        $amount = $got['amount'];
        $date = $got['date'];
        $bounced = $got['bounced'];
      }
      $bounce = mysqli_query($con, "UPDATE cheque SET bounced = FALSE WHERE id='".$gid."'");
      $inlog = mysqli_query($con, "INSERT INTO bank_log VALUES('', 'Unbounced Cheque', '".$gby."', 'Income', '".$amount."', 'Cash', '".$date."')");
    }
  $getcheques = mysqli_query($con, "SELECT * FROM cheque ORDER BY date ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ichida Progress Union | Cheques</title>

  <meta name="description" content="">
  <meta name="author" content="">
<?php
        require 'includes/header.php';
    ?>

  <!-- Custom fonts for this template-->
  
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
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            </div>
            <div class="card-body">
            <?php 
              if (mysqli_num_rows($getcheques)) {
                $i = 1;
                echo  "
                      <div class='table-responsive'>
                        <table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>By</th>
                              <th>Cheque No</th>
                              <th>Amount</th>
                              <th>Date</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tfoot>
                            <tr>
                              <th>No</th>
                              <th>By</th>
                              <th>Cheque No</th>
                              <th>Amount</th>
                              <th>Date</th>
                              <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>";
                while ($got = mysqli_fetch_assoc($getcheques)) {
                  $gid = $got['id'];
                  $gby = $got['by_user'];
                  $cno = $got['check_no'];
                  $amount = $got['amount'];
                  $date = $got['date'];
                  $bounced = $got['bounced'];
                  if ($bounced == TRUE) {
                    $action = "<a href='cheque.php?unbounce=$gid' class='btn btn-outline-success'>Unbounce</a>";
                  } else {
                    $action = "<a href='cheque.php?bounce=$gid' class='btn btn-outline-danger'>Bounce</a>";
                  }
                  

                  echo  "
                          <tr>
                            <td>".$i."</td>
                            <td>".$gby."</td>
                            <td>".$cno."</td>
                            <td>&#8358;".$amount."</td>
                            <td>".$date."</td>
                            <td>".$action."</td>
                          </tr>
                         ";

                  $i++;
                }

                echo  "</tbody></table>
                      </div>";
              } else {
                echo "There are no cheques yet";
              }
              
            ?>
            </div>
          </div>
           </div>
        <!-- /.container-fluid -->

      </div>
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
  

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
