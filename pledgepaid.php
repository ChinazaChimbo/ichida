<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }

    $msg = "";
    $date = date("d/m/Y");
    $getpledge = mysqli_query($con, "SELECT * FROM pledge WHERE paid = TRUE ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ichida Progress Union | All Paid Pledges</title>
  <meta name="description" content="">
  <meta name="author" content="">
<?php
        require 'includes/header.php';
    ?>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">

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
          <h1 class="h3 mb-4 text-gray-800">Pledge</h1>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">View Pledge</h6>
            </div>
            <div class="card-body">

            <?php echo $msg?>
              <div class="table-responsive">
          
                <table id="myTable" class="table table-striped table-bordered" style="width:100%" pagination="true">
                  <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>On behalf of:</th>
                                            <th>For</th>
                                            <th>Amount</th>
                                            <th>Phone Number</th>
                                            <th>Date Paid</th>  
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
  if (mysqli_num_rows($getpledge)) {
    $i = 1;
    while ($a = mysqli_fetch_assoc($getpledge)) {
      $aid = $a['id'];
      $aname = $a['name'];
      $aphone = $a['phone'];
      $abehalf = $a['behalf'];
      $areason = $a['reason'];
      $aamount = $a['amount'];
      $apaid = $a['paid'];
      $adate = $a['date'];
      $getmember = mysqli_query($con, "SELECT * FROM members WHERE id = '".$abehalf."'");
      while ($b = mysqli_fetch_assoc($getmember)) {
        $bfname = $b['fname'];
        $bsname = $b['sname'];
        echo "<tr>
                  <td>".$i."</td>
                  <td>".$aname."</td>
                  <td>".$bfname." ".$bsname."</td>
                  <td>".$areason."</td>
                  <td>&#8358;".$aamount."</td>
                  <td>".$aphone."</td>
                  <td>".$adate."</td>  
              </tr>";
        $i++;
      }
    }
  } else {
    echo "There are no paid pledges";
  }
  
?>
                        </tbody>
                         <tfoot>
            <tr>
            <th>#</th>
                                            <th>Name</th>
                                            <th>On behalf of:</th>
                                            <th>For</th>
                                            <th>Amount</th>
                                            <th>Phone Number</th>
                                            <th>Date Paid</th>  
                                        </tr>
            </tr>
        </tfoot>
        
                                  </table>
                   
              </div>
            </div>
            
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
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
  <script>
    $(document).ready(function() {
    $('#myTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true },
            { extend: 'csvHtml5', footer: true }, 
            { extend: 'print', footer: true },
            { extend: 'pdfHtml5', footer: true }
        ],
         
    } );
} );
  </script>
  
  <!--<script type="text/javascript">
  
  </script>-->
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <script src="js/parsley.min.js"></script>
  <script src="js/wow.min.js"></script>



</body>

</html>
