<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }

    $levycats = mysqli_query($con, "SELECT * FROM levy_categories");
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
          <h1 class="h3 mb-4 text-gray-800">Select Categories</h1>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Levies</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <?php
                        $i = 1;
                        if(mysqli_num_rows($levycats)){
                echo "<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
                  <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Category Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead><tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Category Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>";
                                    while ($a = mysqli_fetch_assoc($levycats)) {
                                        $name = $a['name'];
                                        $id = $a['id'];
                                        
                                        if ($id == 1) {
                                            echo    "<tr>
                                                        <td>".$i."</td>
                                                        <td>".$name."</td>
                                                        <td><a class='button is-info is-outlined' href='viewlevy.php?name=Old Debts&paid=FALSE'>View Owing Members</a> <a class='button is-info is-outlined' href='viewlevy.php?name=Old Debts&paid=TRUE'>View Paid Members</a><td>
                                                    </tr>";
                                        } else {
                                            echo    "<tr>
                                                        <td>".$i."</td>
                                                        <td><a href='category.php?id=$id'>".$name."</a></td>
                                                        <td></td>
                                                    </tr>";
                                        }
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
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php
        require 'includes/foooter.php';
    ?>

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
