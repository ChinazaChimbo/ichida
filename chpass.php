<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }
    $msg = "";
    if (isset($_POST['submit'])) {
        if (!empty($_POST['cpass']) && !empty($_POST['npass']) && !empty($_POST['cnpass'])) {
            $cpass = mysqli_real_escape_string($con, $_POST['cpass']);
            $npass = mysqli_real_escape_string($con, $_POST['npass']);
            $cnpass = mysqli_real_escape_string($con, $_POST['cnpass']);
            
            $check = mysqli_query($con, "SELECT * FROM admin WHERE password = '".$cpass."'");
            if(mysqli_num_rows($check)){
                if ($npass == $cnpass) {
                    $in = mysqli_query($con, "UPDATE admin SET password = '".$npass."'");
                    $inlog = mysqli_query($con, "INSERT INTO bank_log VALUES('', 'Changed password', '".$date."')");
                    $msg = "<div class='notification is-success'>
                                <button class='delete'></button>
                                Your password has been changed successfully.
                            </div>";
                } else {
                    $msg = "<div class='notification is-danger'>
                                <button class='delete'></button>
                                The new password entered does not match with the confirmation.
                            </div>";
                }
                
            }else{
                $msg = "<div class='notification is-danger'>
                        <button class='delete'></button>
                        The currernt password entered is incorrect.
                    </div>";
            }
        }else {
            $msg = "<div class='notification is-danger'>
                        <button class='delete'></button>
                        Please fill all fields.
                    </div>";
        }
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
          <h1 class="h3 mb-4 text-gray-800">Password</h1>
<div class="row">
<div class="col-lg-6">
         <div class="card mb-4">
                <div class="card-header py-3">
                  <p>Change Password</p></div>
                  <div class="card-body">
<div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" id='cpass' name='cpass' placeholder="Current Password">
                  </div></div>
<div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" id='npass' name='npass' placeholder="New Password">
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" id='cnpass' name='cnpass' placeholder="Repeat Password">
                  </div>
                </div>
                                            <?php echo $msg?><br>
                        <div class="field text-center">
                            <input type="submit" value="change" name="submit" class="btn btn-success">
                        
                  </div>
</div></div></div></div>
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
