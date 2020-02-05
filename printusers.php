<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }

    $get = mysqli_query($con, "SELECT * FROM members ORDER BY fname ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ichida Progress Union | All Levies</title>
  <meta name="description" content="">
  <meta name="author" content="">
<?php
        require 'includes/header.php';
    ?>
  <!-- Custom fonts for this template-->
  
</head>

<body onload="printDiv('box')">

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
            <div id="box">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><img src="images/header.jpg" alt="header" style="width:100%;height:150px;"></h1>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Members</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <?php
                        $i = 1;
                        if(mysqli_num_rows($get)){
                echo "<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
                  <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Member Name</th>
                                            <th>phone</th>
                                        </tr>
                                    </thead><tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Member Name</th>
                                            <th>phone</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>";
                                    while ($a = mysqli_fetch_assoc($get)) {
                                        $title = $a['title'];
                                        $sname = $a['sname'];
                                        $fname = $a['fname'];
                                        $id = $a['id'];
                                        $wn = $a['phone'];
                                        
                                            echo    "<tr>
                                                        <td>".$id."</td>
                                                        <td><a href ='user.php?id=".$id."'>".$title." ".$sname." ".$fname."</td>
                                                        <td>".$wn."</td>
                                                    </tr>";
                                        $i++;
                                    }
                        echo        "</tbody>
                                  </table>";
                        }else{
                            echo "There are no levies yet";
                        }
                    ?>
              </div>
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
 <?php
        require 'includes/scripts.php';
    ?>


</body>

</html>
