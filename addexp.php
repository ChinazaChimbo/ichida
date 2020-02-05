<?php
    $page='account';
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }

    $msg = "";
    if (isset($_POST['submit'])) {
        if (!empty($_POST['name']) && !empty($_POST['hb']) && !empty($_POST['amount'])) {
            $name = mysqli_real_escape_string($con, $_POST['name']);
            $hb =  mysqli_real_escape_string($con, $_POST['hb']);
            $amount =  mysqli_real_escape_string($con, $_POST['amount']);
            $date = date('d/m/Y');
            if (is_numeric($amount)) {
                $in = mysqli_query($con, "INSERT INTO expense VALUES('', '".$name."', '".$hb."', '".$amount."', '".$date."')");
                $inlog = mysqli_query($con, "INSERT INTO bank_log VALUES('', '".$name."', '".$hb."', 'Expenditure', '".$amount."', 'Cash', '".$date."')");
                $msg = "<div class='notification is-success'>
                            <button class='delete'></button>
                            Expenditure added successfully.
                        </div>";
            } else {
                $msg = "<div class='notification is-danger'>
                            <button class='delete'></button>
                            Amount must be numeric.
                        </div>";
            }
            
        } else {
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
    <title>Ichida Progress Union | Add Expenditure</title>
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
          <h1 class="h3 mb-4 text-gray-800">Expenses</h1>
<div class="row">
<div class="col-lg-6">
         <div class="card mb-4">
                <div class="card-header py-3">
                  <p>Add Expenses</p></div>
                  <div class="card-body">
                 <form action="addexp.php" method="post" data-parsley-validate>      
<div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Expenses title">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" id="amount" name="amount" placeholder="Amount">
                  </div>
                </div>
                <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="hb" name="hb" placeholder="Handled by "> </div> </div>
                                            <?php echo $msg?><br>
                        <div class="field text-center">
                            <input type="submit" value="Add" name="submit" class="btn btn-success">
                      
                  </div></form></div>
</div></div></div>
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
