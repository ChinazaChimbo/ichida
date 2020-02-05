<?php
  require 'includes/conn.php';
  if (!isset($_SESSION['admin'])) {
      header('Location:index.php');
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ichida Progress Union | Member Information</title>
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
        <div class="container-fluid" >

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Fidelity| john Swamp</h1>
<div class="row">
<div class="col-lg-6">
         <div class="card mb-4">
                <div class="card-header py-3">
Account Details

</div>
<div class="card-body"><p><b>Account Owner:</b> John Swamp</p><br>
                        <p><b>Account Type:</b> Savings</p><br>
                        <p><b>Bank:</b> Fidelity</p><br>
                        <p><b>Balance:</b> #3000</p><br>
                        </div>
</div>

<div class="text-center">
<a href="editaccount.php" class="btn btn-warning btn-icon-split"><span class="icon text-white-50">
                      <i class="fas fa-wrench"></i>
                    </span>
                    <span class="text">Edit </span></a></div>
</div></div></div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php
        require 'includes/footer.php';
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
        require 'includes/scripts.php';
    ?>

</body>

</html>
