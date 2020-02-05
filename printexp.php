<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $url = "https://";
    }else{
        $url = "http://";
    }
    $total = 0;
    
    $url.= $_SERVER['HTTP_HOST'];
    $url.= $_SERVER['REQUEST_URI']; 

    $report = mysqli_real_escape_string($con, $_GET['report']);
    $in = mysqli_query($con, "INSERT INTO print_log VALUES('', '".$report."')");
    $check = mysqli_query($con, "SELECT * FROM expense ORDER BY date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ichida Progress Union | Expenditure Log</title>
  <meta name="description" content="">
  <meta name="author" content="">
<?php
        require 'includes/header.php';
    ?>

  <!-- Custom fonts for this template-->
  
</head>

<body onload="myFunction()">
  

  <!-- Page Wrapper -->
  
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1> <img src="images/header.jpg" alt="header" style="width:100%;height:150px;"></h1>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Expenditure Log</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <?php 
                    if (mysqli_num_rows($check)) {
                        $i = 1;
                        echo    "<table class='table is-fullwidth is-striped' id='dataTable' width='100%' cellspacing='0'>";
                  echo    "<thead>";
                                echo    "<tr>";
                                    echo    "<th>No</th>";
                                    echo    "<th>Title</th>";
                                    echo    "<th>Handled By</th>";
                                    echo    "<th>Amount</th>";
                                    echo    "<th>Date</th>";
                                echo    "</tr>";
                            echo    "</thead>";
                            echo    "<tfoot>";
                                echo    "<tr>";
                                    echo    "<th>No</th>";
                                    echo    "<th>Title</th>";
                                    echo    "<th>Handled By</th>";
                                    echo    "<th>Amount</th>";
                                    echo    "<th>Date</th>";
                                echo    "</tr>";
                            echo    "</tfoot>";
                            echo    "<tbody>";
                            while ($a = mysqli_fetch_assoc($check)) {
                                $atitle = $a['name'];
                                $ahb = $a['handled_by'];
                                $aamount = $a['amount'];
                                $adate = $a['date'];
                                $total += $aamount;
                                echo "<tr>
                                        <td>".$i."</td>
                                        <td>".$atitle."</td>
                                        <td>".$ahb."</td>
                                        <td>&#8358;".$aamount."</td>
                                        <td>".$adate."</td>
                                      </tr>";

                                $i++;
                            }
                            echo    "
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Total</td>
                                            <td></td>
                                            <td>&#8358; ".$total."</td>
                                            <td>".$adate."</td>
                                        </tr>
                                    ";
                            echo    "</tbody>";
                        echo    "</table>";
                    } else {
                        echo    "There are no expenditures at the moment.";
                    }
                ?>
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
      </footer>>
      <!-- End of Footer -->

    
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
        require 'includes/scripts.php';
    ?>


</body>

</html>
