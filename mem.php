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
    <title>Ichida Progress Union | All Members</title>
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

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Members</h1>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">View Members</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <?php
                        $i = 1;
                        if(mysqli_num_rows($get)){
                echo "<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
                  <thead>
                                        <tr>
                                            <th>Membership No</th>
                                            <th>Member Name</th>
                                            <th>Group</th>
                                        </tr>
                                    </thead><tfoot>
                                        <tr>
                                            <th>Membership No</th>
                                            <th>Member Name</th>
                                            <th>Group</th>
                                            
                                            
                                        </tr>
                                    </tfoot>
                                    <tbody>";
                                    while ($a = mysqli_fetch_assoc($get)) {
                                        $title = $a['title'];
                                        $sname = $a['sname'];
                                        $fname = $a['fname'];
                                        $id = $a['id'];
                                        $wn = $a['phone'];
                                        $gn = $a['group_no'];
                                        $mn = $a['mem_number'];
                                        $getgroup = mysqli_query($con, "SELECT * FROM groups WHERE id = '".$gn."'");
                                        while ($gotg = mysqli_fetch_assoc($getgroup)) {
                                          $gname = $gotg['name'];
                                          echo    "<tr>
                                                        <td>".$mn."</td>
                                                        <td><a href ='user.php?id=".$id."'>".$title." ".$sname." ".$fname."</td>
                                                        <td>".$gname."</td>
                                                    </tr>";
                                        }
                                            
                                        $i++;
                                    }
                        echo        "</tbody>
                                  </table>";
                        }else{
                            echo "There are no Members yet";
                        }
                    ?>
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
        require 'includes/scriptstables.php';
    ?>


</body>

</html>
